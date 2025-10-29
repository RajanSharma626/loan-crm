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
    // Leads routes restricted to Admin, Manager, and Agent
    Route::middleware('leads.access')->group(function () {
        Route::get('/leads', [LeadController::class, 'index'])->name('leads');
        Route::get('/lead-form/{id}', [LeadController::class, 'create'])->name('lead.info');
        Route::post('/lead/update-info', [LeadController::class, 'updateInfo'])->name('lead.update.info');
        Route::post('/lead/update-agreement', [LeadController::class, 'updateAgreement'])->name('lead.update.agreement');

        //assign Agent
        Route::post('/leads/assign-agent', [LeadController::class, 'assignAgent'])->name('lead.assign.agent');
    });


    //upload docs - restricted to Admin, Manager, Agent, and Underwriter
    Route::middleware(['document.upload.access'])->group(function () {
        Route::get('/upload-docs', [LeadController::class, 'uploadDocs'])->name('upload.docs');
        Route::get('/document-info/{id}', [LeadController::class, 'documentInfo'])->name('document.info');
        Route::post('/lead/upload-document/store', [LeadController::class, 'storeDocument'])->name('lead.update.upload');
        Route::post('/lead/upload-document/delete', [LeadController::class, 'deleteSingleDocument'])->name('lead.delete.single');
    });

    //underwriting - restricted to Admin, Manager, and Underwriter
    Route::middleware('underwriting.access')->group(function () {
        Route::get('/underwriting', [LeadController::class, 'underwriting'])->name('underwriting');
        Route::get('/underwriting/review/{id}', [LeadController::class, 'reviewDocs'])->name('underwriting.review');
        Route::post('/underwriting/review/save', [LeadController::class, 'reviewDocsSave'])->name('underwriting.review.save');
    });

    //disbursal - restricted to Admin, Manager, and Underwriter
    Route::middleware('disbursal.access')->group(function () {
        Route::get('/disbursal', [LeadController::class, 'disbursal'])->name('disbursal');
        Route::get('/disbursal/info/{id}', [LeadController::class, 'disbursalInfo'])->name('disbursal.info');
    });

    // users routes restricted to admin only
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

// Public routes for loan acceptance (no authentication required)
Route::get('/verify/{token}', [LeadController::class, 'verifyAcceptance'])->name('acceptance.verify');
Route::post('/verify/{token}', [LeadController::class, 'processAcceptance'])->name('acceptance.process');
Route::get('/success/{success}', [LeadController::class, 'acceptanceSuccess'])->name('acceptance.success');
Route::get('/expired', function() {
    return view('acceptance-expired');
})->name('acceptance.expired');
