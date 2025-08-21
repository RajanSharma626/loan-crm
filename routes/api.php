<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

Route::post('/apply/submit', [ApiController::class, 'applySubmit']);
