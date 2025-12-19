<?php

namespace App\Http\Controllers;

use App\Models\Documents;
use App\Models\Eagreement;
use App\Models\Lead;
use App\Models\Note;
use App\Models\User;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $query = Lead::with('agent', 'eagreement');

        // Exclude leads where client has accepted the agreement (move to disbursal)
        $query->where(function($q) {
            $q->doesntHave('eagreement')
              ->orWhereHas('eagreement', function($subQ) {
                  $subQ->where('is_accepted', false)
                       ->orWhereNull('is_accepted');
              });
        });

        // Admin vs Agent leads
        if (!in_array(Auth::user()->role, ['Admin', 'Manager'])) {
            $query->where('agent_id', Auth::user()->id);
        }

        $query->where(function (Builder $subQuery) {
            $subQuery->whereNull('disposition')
                ->orWhereNotIn('disposition', ['Docs received', 'Approved', 'Disbursed', 'Reopen', 'Hold', 'FI Negative']);
        });

        $this->applyLeadFilters($request, $query);

        $leads = $query->orderBy('created_at', 'desc')->paginate(10);

        $agents = User::where('role', 'Agent')
            ->where('status', 'Active')
            ->whereNull('deleted_at')
            ->get();

        return view('leads', compact('leads', 'agents'));
    }


    public function create($id)
    {
        $emp = User::whereNull('deleted_at')->where('status', 'Active')->get();
        $lead = Lead::with(['notesRelation', 'notesRelation.user', 'notesRelation.assignBy', 'eagreement'])
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();

        $doc =  Documents::where('lead_id', $lead->id)->first();
        return view('lead-form', compact('emp', 'lead', 'doc'));
    }

    public function assignAgent(Request $request)
    {
        // Handle both 'id' and 'lead_id' parameters for compatibility
        $leadId = $request->input('lead_id') ?? $request->input('id');
        $lead = Lead::findOrFail($leadId);
        
        // Handle both 'agent' and 'agent_id' parameters
        $agentId = $request->input('agent_id') ?? $request->input('agent');
        
        $agent = User::find($agentId);
        
        $lead->agent_id = $agentId;
        $lead->assign_by = Auth::id();
        $lead->save();

        // Create a note for the assignment
        Note::create([
            'lead_id' => $lead->id,
            'updated_by' => Auth::id(),
            'note' => 'Agent assigned: ' . ($agent ? $agent->name : 'N/A'),
            'disposition' => $lead->disposition ?? 'Pending',
            'lead_assign_by' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Lead assigned successfully.');
    }

    public function bulkAssignAgent(Request $request)
    {
        $request->validate([
            'lead_ids' => 'required|array',
            'lead_ids.*' => 'exists:leads,id',
            'agent_id' => 'required|exists:users,id',
        ]);

        $agentId = $request->input('agent_id') ?? $request->input('agent');
        $leadIds = $request->input('lead_ids');
        $assignedCount = 0;

        foreach ($leadIds as $leadId) {
            $lead = Lead::findOrFail($leadId);
            $lead->agent_id = $agentId;
            $lead->assign_by = Auth::id();
            $lead->save();

            Note::create([
                'lead_id' => $lead->id,
                'updated_by' => Auth::id(),
                'note' => 'Agent assigned via bulk assignment',
                'disposition' => $lead->disposition ?? 'Pending',
                'lead_assign_by' => Auth::id(),
            ]);
            $assignedCount++;
        }

        return redirect()->back()->with('success', "Successfully assigned {$assignedCount} lead(s) to agent.");
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'lead_ids' => 'required|array',
            'lead_ids.*' => 'exists:leads,id',
        ]);

        // Restrict Manager from deleting leads
        if (!in_array(Auth::user()->role, ['Admin'])) {
            return redirect()->back()->with('error', 'Only Admin can delete leads.');
        }

        $leadIds = $request->input('lead_ids');
        $deletedCount = 0;

        foreach ($leadIds as $leadId) {
            $lead = Lead::findOrFail($leadId);
            $lead->delete(); // Use soft delete
            $deletedCount++;
        }

        return redirect()->back()->with('success', "Successfully deleted {$deletedCount} lead(s).");
    }

    public function deletedLeads(Request $request)
    {
        if (Auth::user()->role !== 'Admin') {
            return redirect()->route('leads')->with('error', 'Access denied.');
        }

        $query = Lead::with('agent', 'eagreement')->onlyTrashed();

        $this->applyLeadFilters($request, $query);

        $leads = $query->orderBy('deleted_at', 'desc')->paginate(10);

        $agents = User::where('role', 'Agent')
            ->where('status', 'Active')
            ->whereNull('deleted_at')
            ->get();

        return view('deleted-leads', compact('leads', 'agents'));
    }

    public function restoreLead($id)
    {
        if (Auth::user()->role !== 'Admin') {
            return redirect()->back()->with('error', 'Access denied.');
        }

        $lead = Lead::withTrashed()->findOrFail($id);
        $lead->restore();

        Note::create([
            'lead_id' => $lead->id,
            'updated_by' => Auth::id(),
            'note' => 'Lead restored from deleted leads',
            'disposition' => $lead->disposition ?? 'Pending',
            'lead_assign_by' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Lead restored successfully.');
    }

    public function bulkRestore(Request $request)
    {
        if (Auth::user()->role !== 'Admin') {
            return redirect()->back()->with('error', 'Access denied.');
        }

        $request->validate([
            'lead_ids' => 'required|array',
            'lead_ids.*' => 'exists:leads,id',
        ]);

        $leadIds = $request->input('lead_ids');
        $restoredCount = 0;

        foreach ($leadIds as $leadId) {
            $lead = Lead::withTrashed()->findOrFail($leadId);
            $lead->restore();

            Note::create([
                'lead_id' => $lead->id,
                'updated_by' => Auth::id(),
                'note' => 'Lead restored from deleted leads via bulk restore',
                'disposition' => $lead->disposition ?? 'Pending',
                'lead_assign_by' => Auth::id(),
            ]);
            $restoredCount++;
        }

        return redirect()->back()->with('success', "Successfully restored {$restoredCount} lead(s).");
    }

    public function bulkDeletePermanent(Request $request)
    {
        if (Auth::user()->role !== 'Admin') {
            return redirect()->back()->with('error', 'Access denied.');
        }

        $request->validate([
            'lead_ids' => 'required|array',
            'lead_ids.*' => 'exists:leads,id',
        ]);

        $leadIds = $request->input('lead_ids');
        $deletedCount = 0;

        foreach ($leadIds as $leadId) {
            $lead = Lead::withTrashed()->findOrFail($leadId);
            $lead->forceDelete(); // Permanently delete
            $deletedCount++;
        }

        return redirect()->back()->with('success', "Successfully permanently deleted {$deletedCount} lead(s).");
    }

    public function updateInfo(Request $request)
    {
        // Restrict Agent from editing lead info (except disposition, re-assign, remark)
        if (Auth::user()->role === 'Agent') {
            return redirect()->back()->with('error', 'Agents can only edit disposition, agent assignment, and remarks. Contact Admin or Manager for other changes.');
        }

        // Validation
        $request->validate([
            'id' => 'required|exists:leads,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'mobile' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'lead_source' => 'nullable|string|max:255',
            'keyword' => 'nullable|string|max:255',
            'loan_type' => 'required|string|in:Personal Loan,Short Term Loan,Other Loan',
            'city' => 'required|string|max:255',
            'monthly_salary' => 'nullable|integer|min:0',
            'loan_amount' => 'nullable|integer|min:0',
            'duration' => 'nullable|integer|min:1',
            'pancard_number' => ['nullable', 'string', 'max:10', 'regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/i'],
            'gender' => 'nullable|string|in:Male,Female,Other',
            'dob' => 'nullable|date',
            'marital_status' => 'nullable|string|in:Single,Married,Divorced,Widowed',
            'education' => 'nullable|string|max:255',
            'disposition' => 'nullable|string|max:255',
            'agent_id' => 'nullable|exists:users,id',
            'notes' => 'nullable|string',
        ]);

        $lead = Lead::findOrFail($request->id);
        $lead->first_name      = $request->first_name;
        $lead->last_name       = $request->last_name;
        $lead->mobile          = $request->mobile;
        $lead->email           = $request->email;
        $lead->lead_source     = $request->lead_source;
        $lead->keyword         = $request->keyword;
        $lead->loan_type       = $request->loan_type;
        $lead->city            = $request->city;
        $lead->monthly_salary  = $request->monthly_salary;
        $lead->loan_amount     = $request->loan_amount;
        $lead->duration        = $request->duration;
        $lead->pancard_number  = strtoupper($request->pancard_number);
        $lead->gender          = $request->gender;
        // Handle DOB format conversion (DD/MM/YYYY to YYYY-MM-DD)
        $dob = $request->dob;
        if ($dob && strpos($dob, '/') !== false) {
            $parts = explode('/', $dob);
            if (count($parts) === 3) {
                $dob = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            }
        }
        $lead->dob             = $dob;
        $lead->marital_status  = $request->marital_status;
        $lead->education       = $request->education;
        $lead->disposition     = $request->disposition;
        $lead->agent_id        = $request->agent_id;
        $lead->save();

        Note::create([
            'lead_id'        => $lead->id,
            'updated_by'     => Auth::id(),
            'note'           => $request->notes,
            'disposition'    => $request->disposition,
            'lead_assign_by' => Auth::id(),
        ]);

        return redirect()->route('lead.info', $lead->id)->with('success', 'Lead Info updated successfully.');
    }

    public function updateAgreement(Request $request)
    {
        $lead = Lead::findOrFail($request->lead_id);
        $lead->disposition = $request->disposition;
        $lead->save();

        $eagreement = $lead->eagreement ?? new Eagreement();
        $isNew = !$eagreement->exists;
        
        $eagreement->lead_id             = $lead->id;
        $eagreement->disposition         = $request->disposition;
        // applied_amount is disabled, so use lead's loan_amount
        $eagreement->applied_amount      = $request->applied_amount ?? $lead->loan_amount;
        $eagreement->approved_amount     = $request->approved_amount;
        // duration is disabled, so use lead's duration
        $eagreement->duration            = $request->duration ?? $lead->duration ?? $eagreement->duration;
        $eagreement->interest_rate       = $request->interest_rate;
        $eagreement->processing_fees     = $request->processing_fees;
        $eagreement->repayment_amount    = $request->repayment_amount ?? null;
        $eagreement->disbursed_amount    = $request->disbursed_amount ?? null;
        
        // Generate Loan Application Number if it doesn't exist
        if (empty($eagreement->application_number)) {
            // Get the last application number with format MP0000XXX (ignore old RSHPL format)
            $lastAgreement = Eagreement::whereNotNull('application_number')
                ->where('application_number', 'like', 'MP%')
                ->orderBy('application_number', 'desc')
                ->first();
            
            if ($lastAgreement && preg_match('/MP0+(\d+)/', $lastAgreement->application_number, $matches)) {
                $nextNumber = intval($matches[1]) + 1;
                // Ensure it doesn't go below 301
                if ($nextNumber < 301) {
                    $nextNumber = 301;
                }
            } else {
                $nextNumber = 301; // Start from 301 as per example MP0000301
            }
            
            // Format: MP + 4 zeros + 3 digit number (e.g., MP0000301)
            $eagreement->application_number = 'MP' . str_pad($nextNumber, 7, '0', STR_PAD_LEFT);
        }
        
        // Generate acceptance token when loan is approved and application number exists
        if (!empty($eagreement->application_number) && empty($eagreement->acceptance_token) && !$eagreement->is_accepted) {
            $eagreement->acceptance_token = bin2hex(random_bytes(32)); // 64 character token
            $eagreement->token_expires_at = now()->addDays(30); // Token expires in 30 days
        }
        
        // Always allow updating customer_application_status and notes
        $eagreement->customer_application_status = $request->customer_application_status ?? ($eagreement->customer_application_status ?? 'Pending');
        $eagreement->notes = $request->notes ?? null;
        
        if ($request->hasFile('signed_application')) {
            if ($eagreement->signed_application && file_exists(public_path($eagreement->signed_application))) {
                unlink(public_path($eagreement->signed_application));
            }
            $fileName = time() . '_' . str_replace(' ', '_', strtolower($request->file('signed_application')->getClientOriginalName()));
            $path = 'uploads/e-agreement/';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $request->file('signed_application')->move($path, $fileName);
            $eagreement->signed_application = '/' . trim($path, '/') . '/' . trim($fileName, '/');
        }

        $eagreement->save();

        // Create note for e-agreement update
        if (!empty($request->notes)) {
            Note::create([
                'lead_id' => $lead->id,
                'updated_by' => Auth::id(),
                'note' => 'E-Agreement Updated: ' . ($request->notes),
                'disposition' => $request->disposition,
                'lead_assign_by' => Auth::id(),
            ]);
        } else {
            // Create note even if no notes field is filled, to track the update
            Note::create([
                'lead_id' => $lead->id,
                'updated_by' => Auth::id(),
                'note' => 'E-Agreement Updated. Application Number: ' . ($eagreement->application_number ?? 'Pending'),
                'disposition' => $request->disposition,
                'lead_assign_by' => Auth::id(),
            ]);
        }

        return redirect()->route('underwriting.review', $lead->id)->with('success', 'Lead Agreement updated successfully.');
    }

    public function storeDocument(Request $request)
    {
        $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'pan_card' => 'nullable|array',
            'pan_card.*' => 'nullable|file|mimes:png,jpg,jpeg,webp,pdf|max:2048',
            'photograph' => 'nullable|array',
            'photograph.*' => 'nullable|file|mimes:png,jpg,jpeg,webp,pdf|max:2048',
            'adhar_card' => 'nullable|array',
            'adhar_card.*' => 'nullable|file|mimes:png,jpg,jpeg,webp,pdf|max:2048',
            'current_address' => 'nullable|array',
            'current_address.*' => 'nullable|file|mimes:png,jpg,jpeg,webp,pdf|max:2048',
            'permanent_address' => 'nullable|array',
            'permanent_address.*' => 'nullable|file|mimes:png,jpg,jpeg,webp,pdf|max:2048',
            'salary_slip' => 'nullable|array',
            'salary_slip.*' => 'nullable|file|mimes:png,jpg,jpeg,webp,pdf|max:2048',
            'bank_statement' => 'nullable|array',
            'bank_statement.*' => 'nullable|file|mimes:png,jpg,jpeg,webp,pdf|max:2048',
            'cibil' => 'nullable|array',
            'cibil.*' => 'nullable|file|mimes:png,jpg,jpeg,webp,pdf|max:2048',
            'other_documents' => 'nullable|array',
            'other_documents.*' => 'nullable|file|mimes:png,jpg,jpeg,webp,pdf|max:2048',
        ]);

        $lead = Lead::findOrFail($request->lead_id);

        $documentFields = [
            'photograph',
            'pan_card',
            'adhar_card',
            'current_address',
            'permanent_address',
            'salary_slip',
            'bank_statement',
            'cibil',
            'other_documents'
        ];

        $documentsData = [];
        foreach ($documentFields as $field) {
            if ($request->hasFile($field)) {
                $filePaths = [];
                foreach ($request->file($field) as $file) {
                    $fileName = time() . '_' . str_replace(' ', '_', strtolower($file->getClientOriginalName()));
                    $relativeDir = 'uploads/documents/' . $field . '/';
                    $absoluteDir = public_path($relativeDir);
                    if (!file_exists($absoluteDir)) {
                        mkdir($absoluteDir, 0777, true);
                    }
                    $file->move($absoluteDir, $fileName);
                    $filePaths[] = '/' . trim($relativeDir, '/') . '/' . trim($fileName, '/');
                }
                $documentsData[$field] = $filePaths;
            }
        }

        $serializedDocumentsData = array_map(function ($item) {
            return is_array($item) ? json_encode($item) : $item;
        }, $documentsData);

        // Add individual remarks fields for each document type
        $remarksFields = [
            'photograph_remarks',
            'pan_card_remarks',
            'adhar_card_remarks',
            'current_address_remarks',
            'permanent_address_remarks',
            'salary_slip_remarks',
            'bank_statement_remarks',
            'cibil_remarks',
            'other_documents_remarks'
        ];

        foreach ($remarksFields as $field) {
            if ($request->filled($field)) {
                $serializedDocumentsData[$field] = $request->input($field);
            }
        }

        Documents::updateOrCreate(
            ['lead_id' => $lead->id],
            $serializedDocumentsData
        );

        return redirect()->route('document.info', $lead->id)->with('success', 'Documents uploaded successfully.');
    }

    public function delete($id)
    {
        // Restrict Manager from deleting leads
        if (Auth::user()->role !== 'Admin') {
            return redirect()->route('leads')->with('error', 'Only Admin can delete leads.');
        }

        $lead = Lead::findOrFail($id);
        $lead->delete(); // Use soft delete

        return redirect()->route('leads')->with('success', 'Lead deleted successfully.');
    }

    public function uploadDocs(Request $request)
    {
        $query = Lead::with(['agent', 'assignedTo', 'document', 'eagreement']);

        // Only show leads with "Docs received" disposition
        $query->where('disposition', 'Docs received');

        // Exclude leads where client has accepted the agreement (move to disbursal)
        $query->where(function($q) {
            $q->doesntHave('eagreement')
              ->orWhereHas('eagreement', function($subQ) {
                  $subQ->where('is_accepted', false)
                       ->orWhereNull('is_accepted');
              });
        });

        $this->restrictToAssignedLeads($query);
        $this->applyLeadFilters($request, $query);

        $leads = $query->orderBy('created_at', 'desc')->paginate(10);
        $agents = User::where('role', 'Agent')
            ->where('status', 'Active')
            ->whereNull('deleted_at')
            ->get();
        return view('upload-docs', compact('leads', 'agents'));
    }

    public function documentInfo($id)
    {
        $lead = Lead::findOrFail($id);
        $doc = Documents::where('lead_id', $lead->id)->first();
        $emp = User::whereNull('deleted_at')->where('status', 'Active')->get();
        return view('doc-upload-form', compact('lead', 'doc', 'emp'));
    }

    public function underwriting(Request $request)
    {
        $query = Lead::with(['agent', 'assignedTo', 'document', 'eagreement'])
            ->whereIn('disposition', ['Docs received', 'Approved', 'Reopen', 'Hold', 'FI Negative']);

        $this->restrictToAssignedLeads($query);
        $this->applyLeadFilters($request, $query);

        $leads = $query->orderBy('created_at', 'desc')->paginate(10);
        $agents = User::where('role', 'Agent')
            ->where('status', 'Active')
            ->whereNull('deleted_at')
            ->get();
        return view('underwriting', compact('leads', 'agents'));
    }

    public function reviewDocs($id)
    {
        $lead = Lead::with('eagreement')->findOrFail($id);
        $doc = Documents::where('lead_id', $id)->first();
        return view('underwriting-review', compact('lead', 'doc'));
    }

    public function reviewDocsSave(Request $request)
    {
        $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'statuses' => 'required|array'
        ]);
        $leadId = (int)$request->lead_id;
        $doc = Documents::where('lead_id', $leadId)->firstOrFail();
        $allowed = [
            'photograph', 'pan_card', 'adhar_card', 'current_address', 'permanent_address',
            'salary_slip', 'bank_statement', 'cibil', 'other_documents'
        ];
        foreach ($allowed as $key) {
            $statusKey = $key . '_status';
            if (array_key_exists($key, $request->statuses)) {
                // Lock once approved
                if ($doc->{$statusKey} === 'Approved') {
                    continue;
                }
                $value = $request->statuses[$key];
                if (in_array($value, ['Approved', 'Disapproved', 'Docs Received'])) {
                    $doc->{$statusKey} = $value;
                }
            }
        }
        $doc->save();
        
        // Create note for document status update
        $lead = Lead::findOrFail($leadId);
        $statusUpdates = [];
        foreach ($request->statuses as $docType => $status) {
            if (in_array($status, ['Approved', 'Disapproved', 'Docs Received'])) {
                $statusUpdates[] = ucfirst(str_replace('_', ' ', $docType)) . ': ' . $status;
            }
        }
        
        if (!empty($statusUpdates)) {
            Note::create([
                'lead_id' => $leadId,
                'updated_by' => Auth::id(),
                'note' => 'Document Status Updated: ' . implode(', ', $statusUpdates),
                'disposition' => $lead->disposition ?? 'Pending',
                'lead_assign_by' => Auth::id(),
            ]);
        }
        
        return redirect()->route('underwriting.review', $leadId)->with('success', 'Document statuses updated.');
    }

    public function deleteSingleDocument(Request $request)
    {
        $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'field' => 'required|string|in:photograph,pan_card,adhar_card,current_address,permanent_address,salary_slip,bank_statement,cibil,other_documents',
            'path' => 'required|string'
        ]);

        $lead = Lead::findOrFail($request->lead_id);
        $documents = Documents::where('lead_id', $lead->id)->first();
        if (!$documents) {
            return redirect()->back()->with('error', 'No documents found.');
        }

        $field = $request->field;
        $existing = $documents->{$field};
        $paths = [];
        if (!empty($existing)) {
            $decoded = json_decode($existing, true);
            if (is_array($decoded)) {
                $paths = $decoded;
            }
        }

        $targetPath = $request->path;
        $updated = array_values(array_filter($paths, function ($p) use ($targetPath) {
            return $p !== $targetPath;
        }));

        try {
            $absolute = public_path($targetPath);
            if (str_starts_with($absolute, public_path()) && file_exists($absolute)) {
                @unlink($absolute);
            }
        } catch (\Throwable $e) {
            // ignore file delete errors
        }

        $documents->{$field} = empty($updated) ? null : json_encode($updated);
        $documents->save();

        return redirect()->back()->with('success', 'Document removed successfully.');
    }

    public function disbursal(Request $request)
    {
        $query = Lead::with(['agent', 'assignedTo', 'document', 'eagreement']);

        // Only show leads where client has accepted the agreement
        $query->whereHas('eagreement', function($q) {
            $q->where('is_accepted', true);
        });

        $query->where('disposition', 'Disbursed');

        $this->restrictToAssignedLeads($query);
        $this->applyLeadFilters($request, $query);

        $leads = $query->orderBy('created_at', 'desc')->paginate(10);
        $agents = User::where('role', 'Agent')
            ->where('status', 'Active')
            ->whereNull('deleted_at')
            ->get();
        return view('disbursal', compact('leads', 'agents'));
    }

    public function disbursalInfo($id)
    {
        $lead = Lead::with(['agent', 'document', 'eagreement', 'notesRelation.user', 'notesRelation.assignBy'])->findOrFail($id);
        
        // Ensure this lead has an accepted e-agreement
        if (!$lead->eagreement || !$lead->eagreement->is_accepted) {
            return redirect()->route('disbursal')->with('error', 'This lead is not in disbursal status.');
        }
        
        $doc = Documents::where('lead_id', $lead->id)->first();
        return view('disbursal-info', compact('lead', 'doc'));
    }

    public function collection(Request $request)
    {
        $query = Lead::with(['agent', 'assignedTo', 'document', 'eagreement']);

        // Only show leads where client has accepted the agreement
        $query->whereHas('eagreement', function($q) {
            $q->where('is_accepted', true);
        });

        // Show leads with Disbursed or collection dispositions (Closed, Partially Received, Settled, NPA)
        $query->whereIn('disposition', ['Disbursed', 'Closed', 'Partially Received', 'Settled', 'NPA']);

        $this->restrictToAssignedLeads($query);
        $this->applyLeadFilters($request, $query);

        $leads = $query->orderBy('created_at', 'desc')->paginate(10);
        $agents = User::where('role', 'Agent')
            ->where('status', 'Active')
            ->whereNull('deleted_at')
            ->get();
        return view('collection', compact('leads', 'agents'));
    }

    public function collectionInfo($id)
    {
        $lead = Lead::with(['agent', 'document', 'eagreement', 'notesRelation.user', 'notesRelation.assignBy'])->findOrFail($id);
        
        // Ensure this lead has an accepted e-agreement and is in Disbursed or collection status
        if (!$lead->eagreement || !$lead->eagreement->is_accepted) {
            return redirect()->route('collection')->with('error', 'This lead is not in collection status.');
        }
        
        if (!in_array($lead->disposition, ['Disbursed', 'Closed', 'Partially Received', 'Settled', 'NPA'])) {
            return redirect()->route('collection')->with('error', 'This lead is not in collection status.');
        }
        
        $doc = Documents::where('lead_id', $lead->id)->first();
        return view('collection-info', compact('lead', 'doc'));
    }

    public function updateCollection(Request $request)
    {
        $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'disposition' => 'required|in:Closed,Partially Received,Settled,NPA',
            'closed_date' => 'required|date',
            'received_amount' => 'required|numeric|min:0',
            'note' => 'nullable|string|max:1000',
        ]);

        $lead = Lead::findOrFail($request->lead_id);
        
        if (!$lead->eagreement) {
            return redirect()->back()->with('error', 'No e-agreement found for this lead.');
        }

        $oldDisposition = $lead->disposition;
        
        // Update lead disposition
        $lead->disposition = $request->disposition;
        $lead->save();

        // Update eagreement with collection details
        $eagreement = $lead->eagreement;
        $eagreement->closed_date = $request->closed_date;
        $eagreement->received_amount = $request->received_amount;
        $eagreement->notes = $request->note ?? null;
        $eagreement->save();

        // Create note
        $noteText = 'Collection Updated. Disposition changed to ' . $request->disposition;
        if ($request->closed_date) {
            $noteText .= '. Closed Date: ' . Carbon::parse($request->closed_date)->format('d M, Y');
        }
        if ($request->received_amount) {
            $noteText .= '. Received Amount: ₹' . number_format($request->received_amount, 2);
        }
        
        Note::create([
            'lead_id' => $lead->id,
            'updated_by' => Auth::id(),
            'note' => $noteText,
            'disposition' => $request->disposition,
            'lead_assign_by' => $lead->agent_id ?? null,
        ]);

        return redirect()->route('collection.info', $lead->id)->with('success', 'Collection details updated successfully.');
    }

    public function sendFreshEAgreement(Request $request)
    {
        $request->validate([
            'lead_id' => 'required|exists:leads,id',
        ]);

        $lead = Lead::findOrFail($request->lead_id);
        
        if (!$lead->eagreement) {
            return redirect()->back()->with('error', 'No e-agreement found for this lead.');
        }

        $eagreement = $lead->eagreement;

        // Generate new acceptance token
        $eagreement->acceptance_token = bin2hex(random_bytes(32)); // 64 character token
        $eagreement->token_expires_at = now()->addDays(30); // Token expires in 30 days
        $eagreement->is_accepted = false; // Reset acceptance status
        $eagreement->signature = null;
        $eagreement->acceptance_place = null;
        $eagreement->acceptance_ip = null;
        $eagreement->acceptance_date = null;
        $eagreement->signed_application = null;
        $eagreement->save();

        // Generate acceptance link
        $acceptanceLink = route('acceptance.verify', $eagreement->acceptance_token);

        // Create note
        Note::create([
            'lead_id' => $lead->id,
            'updated_by' => Auth::id(),
            'note' => 'Fresh E-Agreement sent. Acceptance Link: ' . $acceptanceLink,
            'disposition' => $lead->disposition,
            'lead_assign_by' => $lead->agent_id ?? null,
        ]);

        // TODO: Send email with acceptance link to client
        // Mail::to($lead->email)->send(new EAgreementMail($lead, $acceptanceLink));

        return redirect()->route('collection.info', $lead->id)->with('success', 'Fresh e-agreement link generated successfully. Link: ' . $acceptanceLink);
    }

    protected function applyLeadFilters(Request $request, Builder $query): Builder
    {
        if ($request->filled('disposition')) {
            $query->where('disposition', $request->input('disposition'));
        }

        if ($request->filled('loan_type')) {
            $query->where('loan_type', $request->input('loan_type'));
        }

        // Search functionality: Name, Mobile No., PAN No.
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function (Builder $q) use ($searchTerm) {
                $q->where('first_name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('last_name', 'like', '%' . $searchTerm . '%')
                  ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%' . $searchTerm . '%'])
                  ->orWhere('mobile', 'like', '%' . $searchTerm . '%')
                  ->orWhere('pancard_number', 'like', '%' . strtoupper($searchTerm) . '%');
            });
        }

        $dateFilter = $request->get('date_filter');
        $startDate = null;
        $endDate = null;

        if ($dateFilter) {
            switch ($dateFilter) {
                case 'today':
                    $startDate = Carbon::today();
                    $endDate = Carbon::today()->endOfDay();
                    break;
                case 'yesterday':
                    $startDate = Carbon::yesterday()->startOfDay();
                    $endDate = Carbon::yesterday()->endOfDay();
                    break;
                case 'last_7_days':
                    $startDate = Carbon::now()->subDays(6)->startOfDay();
                    $endDate = Carbon::now()->endOfDay();
                    break;
                case 'last_30_days':
                    $startDate = Carbon::now()->subDays(29)->startOfDay();
                    $endDate = Carbon::now()->endOfDay();
                    break;
                case 'this_month':
                    $startDate = Carbon::now()->startOfMonth();
                    $endDate = Carbon::now()->endOfMonth();
                    break;
                case 'last_month':
                    $startDate = Carbon::now()->subMonth()->startOfMonth();
                    $endDate = Carbon::now()->subMonth()->endOfMonth();
                    break;
                case 'custom':
                    if ($request->filled('start_date') && $request->filled('end_date')) {
                        try {
                            $startDate = Carbon::parse($request->get('start_date'))->startOfDay();
                            $endDate = Carbon::parse($request->get('end_date'))->endOfDay();
                        } catch (\Throwable $e) {
                            $startDate = null;
                            $endDate = null;
                        }
                    }
                    break;
                default:
                    break;
            }
        } elseif ($request->filled('start_date') && $request->filled('end_date')) {
            try {
                $startDate = Carbon::parse($request->get('start_date'))->startOfDay();
                $endDate = Carbon::parse($request->get('end_date'))->endOfDay();
            } catch (\Throwable $e) {
                $startDate = null;
                $endDate = null;
            }
        }

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        return $query;
    }

    protected function restrictToAssignedLeads(Builder $query): Builder
    {
        $user = Auth::user();

        if (!$user || in_array($user->role, ['Admin', 'Manager', 'Underwriter', 'Collection'])) {
            return $query;
        }

        if ($user->role === 'Agent') {
            return $query->where('agent_id', $user->id);
        }

        return $query->where(function (Builder $assigned) use ($user) {
            $assigned->where('assign_to', $user->id)
                ->orWhere('agent_id', $user->id)
                ->orWhereHas('eagreement', function ($sub) use ($user) {
                    $sub->where('updated_by', $user->id);
                });
        });
    }

    public function agreementPdf(int $leadId)
    {
        $lead = Lead::with(['eagreement'])->findOrFail($leadId);

        if (!$lead->eagreement) {
            return redirect()->back()->with('error', 'Agreement not available for this lead.');
        }

        $storedPath = $lead->eagreement->signed_application ?? null;
        if ($storedPath) {
            $relativePath = ltrim(str_replace('/storage/', '', $storedPath), '/');
            if (Storage::disk('public')->exists($relativePath)) {
                $absolutePath = Storage::disk('public')->path($relativePath);
                return response()->download(
                    $absolutePath,
                    'Loan-Agreement-' . ($lead->eagreement->application_number ?? $lead->id) . '.pdf'
                );
            }
        }

        $pdf = Pdf::loadView('agreements.pdf', [
            'lead' => $lead,
            'eagreement' => $lead->eagreement,
        ])->setPaper('a4');

        return $pdf->download('Loan-Agreement-' . ($lead->eagreement->application_number ?? $lead->id) . '.pdf');
    }

    public function agreementPdfByToken(string $token)
    {
        $eagreement = Eagreement::where('acceptance_token', $token)
            ->with('lead')
            ->first();

        if (!$eagreement) {
            return view('acceptance-expired');
        }

        $pdf = Pdf::loadView('agreements.pdf', [
            'lead' => $eagreement->lead,
            'eagreement' => $eagreement,
        ])->setPaper('a4');

        return $pdf->download('Loan-Agreement-' . ($eagreement->application_number ?? $eagreement->lead->id) . '.pdf');
    }

    public function agreementPdfByApplication(string $encodedNumber)
    {
        $applicationNumber = base64_decode($encodedNumber);
        $eagreement = Eagreement::where('application_number', $applicationNumber)
            ->where('is_accepted', true)
            ->with('lead')
            ->firstOrFail();

        $storedPath = $eagreement->signed_application ?? null;
        if ($storedPath) {
            $relativePath = ltrim(str_replace('/storage/', '', $storedPath), '/');
            if (Storage::disk('public')->exists($relativePath)) {
                $absolutePath = Storage::disk('public')->path($relativePath);
                return response()->download(
                    $absolutePath,
                    'Loan-Agreement-' . $eagreement->application_number . '.pdf'
                );
            }
        }

        $pdf = Pdf::loadView('agreements.pdf', [
            'lead' => $eagreement->lead,
            'eagreement' => $eagreement,
        ])->setPaper('a4');

        return $pdf->download('Loan-Agreement-' . ($eagreement->application_number ?? $eagreement->lead->id) . '.pdf');
    }

    public function verifyAcceptance($token)
    {
        $eagreement = Eagreement::where('acceptance_token', $token)
            ->where('is_accepted', false)
            ->with('lead')
            ->first();

        if (!$eagreement) {
            return view('acceptance-expired');
        }

        if ($eagreement->token_expires_at && $eagreement->token_expires_at < now()) {
            return view('acceptance-expired');
        }

        $lead = $eagreement->lead;
        
        return view('acceptance-verification', compact('eagreement', 'lead'));
    }

    public function processAcceptance(Request $request, $token)
    {
        $request->validate([
            'signature' => 'required|string|max:255',
            'place' => 'required|string|max:255',
        ]);

        $eagreement = Eagreement::where('acceptance_token', $token)
            ->where('is_accepted', false)
            ->first();

        if (!$eagreement) {
            return redirect()->route('acceptance.expired');
        }

        if ($eagreement->token_expires_at && $eagreement->token_expires_at < now()) {
            return redirect()->route('acceptance.expired');
        }

        // Get client IP address
        $ipAddress = $request->ip();
        if ($request->header('X-Forwarded-For')) {
            $ipAddress = $request->header('X-Forwarded-For');
        }

        // Update eagreement with acceptance details
        $eagreement->signature = $request->signature;
        $eagreement->acceptance_place = $request->place;
        $eagreement->acceptance_ip = $ipAddress;
        $eagreement->acceptance_date = now();
        $eagreement->is_accepted = true;
        $eagreement->customer_application_status = 'Approved';
        $eagreement->acceptance_token = null; // Clear token after acceptance
        $eagreement->save();

        // Create note for client acceptance
        $lead = $eagreement->lead;
        
        // Update lead disposition to "Disbursed" after client acceptance
        $lead->disposition = 'Disbursed';
        $lead->save();
        
        Note::create([
            'lead_id' => $lead->id,
            'updated_by' => null, // Client acceptance, no user ID
            'note' => 'Client Accepted E-Agreement. Signature: ' . $request->signature . ', Place: ' . $request->place . ', IP: ' . $ipAddress . ', Date: ' . now()->format('d M, Y h:i A'),
            'disposition' => 'Disbursed',
            'lead_assign_by' => $lead->agent_id ?? null,
        ]);

        // Generate and persist customer agreement PDF
        $lead->refresh();
        $eagreement->refresh();

        $pdf = Pdf::loadView('agreements.pdf', [
            'lead' => $lead,
            'eagreement' => $eagreement,
        ])->setPaper('a4');

        $fileName = ($eagreement->application_number ?? 'agreement-' . $lead->id) . '.pdf';
        $storagePath = 'agreements/' . $fileName;
        Storage::disk('public')->put($storagePath, $pdf->output());

        $eagreement->signed_application = '/storage/' . $storagePath;
        $eagreement->save();

        // Encode application number for success page
        $encodedNumber = base64_encode($eagreement->application_number);

        return redirect()->route('acceptance.success', ['success' => $encodedNumber]);
    }

    public function acceptanceSuccess($encodedNumber)
    {
        $applicationNumber = base64_decode($encodedNumber);
        $eagreement = Eagreement::where('application_number', $applicationNumber)
            ->where('is_accepted', true)
            ->first();

        if (!$eagreement) {
            return redirect()->route('acceptance.expired');
        }

        return view('acceptance-success', [
            'eagreement' => $eagreement,
            'encoded' => $encodedNumber,
        ]);
    }
}
