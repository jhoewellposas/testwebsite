<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CertificateController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/upload-certificate-form', function () {
    return view('upload'); // This view contains your HTML form
});

Route::get('/test-image', function () {
    $imageManager = new ImageManager(['driver' => 'gd']);
    $img = $imageManager->canvas(800, 600, '#ccc');
    return $img->response('jpg');
});

// Route to handle form submission (POST request only)
Route::post('/extract', [CertificateController::class, 'extractCertificateData']);