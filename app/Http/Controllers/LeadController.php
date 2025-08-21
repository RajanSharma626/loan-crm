<?php

namespace App\Http\Controllers;

use App\Models\Documents;
use App\Models\Eagreement;
use App\Models\Lead;
use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeadController extends Controller
{
    public function index()
    {

        if (Auth::user()->role == 'Admin') {
            $leads = Lead::with('agent')->whereNull('deleted_at')->orderBy('created_at', 'desc')->paginate(10);
        } else {
            $leads = Lead::with('agent')->where('agent_id', Auth::user()->id)->whereNull('deleted_at')->orderBy('created_at', 'desc')->paginate(10);
        }

        $agents = User::where('role', 'Agent')->where('status', 'Active')->whereNull('deleted_at')->get();

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
        $eagreement->lead_id             = $lead->id;
        $eagreement->disposition         = $request->disposition;
        $eagreement->applied_amount      = $request->applied_amount;
        $eagreement->approved_amount     = $request->approved_amount;
        $eagreement->duration            = $request->duration;
        $eagreement->interest_rate       = $request->interest_rate;
        $eagreement->processing_fees     = $request->processing_fees;
        $eagreement->repayment_amount    = $request->repayment_amount;
        $eagreement->disbursed_amount    = $request->disbursed_amount;
        $eagreement->application_number  = $request->application_number;
        $eagreement->customer_application_status = 'Pending';
        if ($request->hasFile('signed_application')) {
            if ($eagreement && file_exists(public_path($eagreement->signed_application))) {
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

        return redirect()->route('lead.info', $lead->id)->with('success', 'Lead Agreement updated successfully.');
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
                    $path = 'uploads/documents/' . $field . '/';
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    $file->move($path, $fileName);
                    $filePaths[] = '/' . trim($path, '/') . '/' . trim($fileName, '/');
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

        return redirect()->route('lead.info', $lead->id)->with('success', 'Documents uploaded successfully.');
    }

    public function delete($id)
    {
        $lead = Lead::findOrFail($id);
        $lead->deleted_at = now();
        $lead->save();

        return redirect()->route('leads')->with('success', 'Lead deleted successfully.');
    }
}
