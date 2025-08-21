<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function applySubmit(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'fname' => 'required|string|max:255',
                'lname' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:15',
                'city' => 'required|string|max:255',
                'salary' => 'required|string|max:255',
                'pan' => 'required|string|max:255'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Validation failed: ' . $e->getMessage()], 500);
        }

        //apikey check
        if ($request->header('API-Key') !== env('API_KEY')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        //store the data 
        try {
            $lead = new Lead();
            $lead->first_name = $validatedData['fname'];
            $lead->last_name = $validatedData['lname'];

            // Check if email or phone or pan already exists
            if (Lead::where('email', $validatedData['email'])->exists()) {
                return response()->json(['error' => 'Email already exists'], 409);
            }
            if (Lead::where('mobile', $validatedData['phone'])->exists()) {
                return response()->json(['error' => 'Phone already exists'], 409);
            }
            if (Lead::where('pancard_number', $validatedData['pan'])->exists()) {
                return response()->json(['error' => 'PAN already exists'], 409);
            }

            $lead->email = $validatedData['email'];
            $lead->mobile = $validatedData['phone'];
            $lead->city = $validatedData['city'];
            $lead->monthly_salary = $validatedData['salary'];
            $lead->pancard_number = $validatedData['pan'];
            $lead->save();

            return response()->json(['message' => 'Application submitted successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to submit application: ' . $e->getMessage()], 500);
        }
    }
}
