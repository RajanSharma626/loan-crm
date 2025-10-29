<?php

namespace App\Http\Controllers;

use App\Models\Documents;
use App\Models\Eagreement;
use App\Models\Lead;
use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $query = Lead::with('agent', 'eagreement')->whereNull('deleted_at');

        // Exclude leads where client has accepted the agreement (move to disbursal)
        $query->where(function($q) {
            $q->doesntHave('eagreement')
              ->orWhereHas('eagreement', function($subQ) {
                  $subQ->where('is_accepted', false)
                       ->orWhereNull('is_accepted');
              });
        });

        // Admin vs Agent leads
        if (Auth::user()->role != 'Admin') {
            $query->where('agent_id', Auth::user()->id);
        }

        // Apply disposition filter if present
        if ($request->has('disposition') && $request->disposition != '') {
            $query->where('disposition', $request->disposition);
        }

        // Apply date filter if present
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
                        } catch (\Exception $e) {
                            // Ignore parsing errors and skip date filter
                        }
                    }
                    break;
                default:
                    // 'all' or unknown -> no date filter
                    break;
            }
        }

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

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
        $lead = Lead::findOrFail($request->lead_id);
        $lead->agent_id = $request->agent_id;
        $lead->assign_by = Auth::id();
        $lead->save();

        return redirect()->route('leads', $lead->id)->with('success', 'Lead assigned successfully.');
    }

    public function updateInfo(Request $request)
    {
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
        $lead->pancard_number  = $request->pancard_number;
        $lead->gender          = $request->gender;
        $lead->dob             = $request->dob;
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
            // Get the last application number
            $lastAgreement = Eagreement::whereNotNull('application_number')
                ->where('application_number', 'like', 'RSHLP2025%')
                ->orderBy('application_number', 'desc')
                ->first();
            
            if ($lastAgreement && preg_match('/RSHLP2025(\d+)/', $lastAgreement->application_number, $matches)) {
                $nextNumber = intval($matches[1]) + 1;
            } else {
                $nextNumber = 1;
            }
            
            $eagreement->application_number = 'RSHLP2025' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
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

        Documents::updateOrCreate(
            ['lead_id' => $lead->id],
            $serializedDocumentsData
        );

        return redirect()->route('document.info', $lead->id)->with('success', 'Documents uploaded successfully.');
    }

    public function delete($id)
    {
        $lead = Lead::findOrFail($id);
        $lead->deleted_at = now();
        $lead->save();

        return redirect()->route('leads')->with('success', 'Lead deleted successfully.');
    }

    public function uploadDocs()
    {
        $query = Lead::with(['agent', 'document', 'eagreement'])->whereNull('deleted_at');

        // Exclude leads where client has accepted the agreement (move to disbursal)
        $query->where(function($q) {
            $q->doesntHave('eagreement')
              ->orWhereHas('eagreement', function($subQ) {
                  $subQ->where('is_accepted', false)
                       ->orWhereNull('is_accepted');
              });
        });

        $leads = $query->paginate(10);
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

    public function underwriting()
    {
        $query = Lead::with(['agent', 'document', 'eagreement'])->whereNull('deleted_at');

        // Exclude leads where client has accepted the agreement (move to disbursal)
        $query->where(function($q) {
            $q->doesntHave('eagreement')
              ->orWhereHas('eagreement', function($subQ) {
                  $subQ->where('is_accepted', false)
                       ->orWhereNull('is_accepted');
              });
        });

        $leads = $query->paginate(10);
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

    public function disbursal()
    {
        $query = Lead::with(['agent', 'document', 'eagreement'])->whereNull('deleted_at');

        // Only show leads where client has accepted the agreement
        $query->whereHas('eagreement', function($q) {
            $q->where('is_accepted', true);
        });

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
        Note::create([
            'lead_id' => $lead->id,
            'updated_by' => null, // Client acceptance, no user ID
            'note' => 'Client Accepted E-Agreement. Signature: ' . $request->signature . ', Place: ' . $request->place . ', IP: ' . $ipAddress . ', Date: ' . now()->format('d M, Y h:i A'),
            'disposition' => 'Approved',
            'lead_assign_by' => $lead->agent_id ?? null,
        ]);

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

        return view('acceptance-success', compact('eagreement'));
    }
}
