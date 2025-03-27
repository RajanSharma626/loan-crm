<?php

namespace App\Http\Controllers;

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
        $leads = Lead::whereNull('deleted_at')->get();
        return view('leads', compact('leads'));
    }

    public function create($id)
    {
        $emp = User::whereNull('deleted_at')->where('status', 'Active')->get();
        $lead = Lead::with(['notesRelation', 'notesRelation.user', 'notesRelation.assignBy', 'eagreement'])
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();
        return view('lead-form', compact('emp', 'lead'));
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
        $lead = Lead::findOrFail($request->id);
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
        if ($request->notes) {
            Note::create([
                'lead_id' => $lead->id,
                'updated_by' => Auth::id(),
                'note' => 'E-Agreement: ' . $request->notes,
                'disposition' => null,
                'lead_assign_by' => Auth::id(),
            ]);
        }
        if ($request->hasFile('signed_application')) {
            Note::create([
                'lead_id' => $lead->id,
                'updated_by' => Auth::id(),
                'note' => 'E-Agreement: Signed
                Application uploaded',
                'disposition' => null,
                'lead_assign_by' => Auth::id(),
            ]);
        }
    }
}
