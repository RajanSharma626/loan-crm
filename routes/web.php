<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\usersController;
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


    //assign Agent
    Route::post('/leads/assign-agent', [LeadController::class, 'assignAgent'])->name('lead.assign.agent');


    //upload docs
    Route::get('/upload-docs', [LeadController::class, 'uploadDocs'])->name('upload.docs');
    Route::get('/document-info/{id}', [LeadController::class, 'documentInfo'])->name('document.info');
    Route::post('/lead/upload-document/store', [LeadController::class, 'storeDocument'])->name('lead.update.upload');

    //underwriting
    Route::get('/underwriting', [LeadController::class, 'underwriting'])->name('underwriting');


    // users routes restricted to admin
    Route::middleware('admin')->group(function () {
        Route::get('/users', [usersController::class, 'index'])->name('emp');
        Route::post('/user/store', [usersController::class, 'store'])->name('userss.store');
        Route::get('/user/edit/{id}', [usersController::class, 'edit'])->name('users.edit');
        Route::post('/user/update', [usersController::class, 'update'])->name('users.update');
        Route::get('/user/delete/{id}', [usersController::class, 'destroy'])->name('users.delete');

        Route::get('/lead/detele/{id}', [LeadController::class, 'delete'])->name('lead.delete');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// form submit api
// Route::post('/apply/submit', [ApiController::class, 'applySubmit'])->name('apply.submit');
