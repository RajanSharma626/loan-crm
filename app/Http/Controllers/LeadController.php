<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index()
    {
        $leads = Lead::all();
        return view('leads.index', compact('leads'));
    }

    public function create()
    {
        return view('leads.create');
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
        ]);

        Lead::create($request->all());

        return redirect()->route('leads.index')->with('success', 'Lead created successfully.');
    }
}
