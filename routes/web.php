<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeadController;
use Illuminate\Support\Facades\Route;


Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.auth');
Route::get('/', function () {
    return redirect()->route('login');
});




Route::get('/apply', function () {
    return view('apply');
})->name('apply');


// Protected Routes (Authenticated Users Only)
Route::middleware(['auth', 'check.active'])->group(function () {
    Route::get('/leads', [LeadController::class, 'index'])->name('leads');

    Route::get('/lead-form/{id}', [LeadController::class, 'create'])->name('lead.info');

    Route::post('/lead/update-info', [LeadController::class, 'updateInfo'])->name('lead.update.info');
    Route::post('/lead/update-agreement', [LeadController::class, 'updateAgreement'])->name('lead.update.agreement');

    //upload document
    Route::post('/lead/upload-document/store', [LeadController::class, 'storeDocument'])->name('lead.update.upload');

    //assign Agent
   Route::post('/lead/assign-agent', [LeadController::class, 'assignAgent'])->name('lead.assign.agent');


    // Employee routes restricted to admin
    Route::middleware('admin')->group(function () {
        Route::get('/employee', [EmployeeController::class, 'index'])->name('emp');
        Route::post('/employees/store', [EmployeeController::class, 'store'])->name('employees.store');
        Route::get('/employee/edit/{id}', [EmployeeController::class, 'edit'])->name('employee.edit');
        Route::post('/employee/update', [EmployeeController::class, 'update'])->name('employee.update');
        Route::get('/employee/delete/{id}', [EmployeeController::class, 'destroy'])->name('employee.delete');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
