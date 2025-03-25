<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;

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
        $lead = Lead::where('id', $id)->whereNull('deleted_at')->first();
        return view('lead-form', compact('emp', 'lead'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile' => 'required|unique:leads',
            'email' => 'required|email|unique:leads',
            'loan_type' => 'required',
            'city' => 'required',
            'monthly_salary' => 'required|numeric',
            'loan_amount' => 'required|numeric',
            'duration' => 'required|numeric',
            'pancard_number' => 'required|unique:leads',
            'gender' => 'required',
            'dob' => 'required|date',
            'disposition' => 'required',
            'agent_id' => 'required',
        ]);

        Lead::create($request->all());

        return redirect()->route('leads')->with('success', 'Lead created successfully.');
    }
}
