<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CertificateController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/upload-certificate-form', function () {
    return view('upload'); // This view contains your HTML form
});

// Route to handle form submission (POST request only)
Route::post('/extract', [CertificateController::class, 'extractCertificateData']);