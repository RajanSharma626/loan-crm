<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeadController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});


Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/apply', function () {
    return view('apply');
})->name('apply');



Route::get('/leads', [LeadController::class, 'index'])->name('leads');

Route::get('/lead-form/{id}', [LeadController::class, 'create'])->name('lead.info');

Route::post('/lead/store', [LeadController::class, 'store'])->name('lead.store');



Route::get('/employee', [EmployeeController::class, 'index'])->name('emp');
Route::post('/employees/store', [EmployeeController::class, 'store'])->name('employees.store');
