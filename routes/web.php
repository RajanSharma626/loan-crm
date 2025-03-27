<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeadController;
use Illuminate\Support\Facades\Route;


// Public Routes (Guest Access)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::get('/', function () {
        return view('login');
    });
    Route::post('/login', [AuthController::class, 'login'])->name('login.auth');

    Route::get('/apply', function () {
        return view('apply');
    })->name('apply');
});

// Protected Routes (Authenticated Users Only)
Route::middleware('auth')->group(function () {
    Route::get('/leads', [LeadController::class, 'index'])->name('leads');

    Route::get('/lead-form/{id}', [LeadController::class, 'create'])->name('lead.info');

    Route::post('/lead/update-info', [LeadController::class, 'updateInfo'])->name('lead.update.info');
    Route::post('/lead/update-agreement', [LeadController::class, 'updateAgreement'])->name('lead.update.agreement');



    Route::get('/employee', [EmployeeController::class, 'index'])->name('emp');
    Route::post('/employees/store', [EmployeeController::class, 'store'])->name('employees.store');
});
