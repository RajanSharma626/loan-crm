<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->name('home');


Route::get('/employee', [EmployeeController::class, 'index'])->name('emp');

Route::post('/employees/store', [EmployeeController::class, 'store'])->name('employees.store');
