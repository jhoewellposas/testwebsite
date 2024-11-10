<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CertificateController;

Route::get('/', function () {
    return view('welcome');
});

/*Route::get('/home', function () {
    return view('home');
});
*/

Route::post('/teachers/create', [CertificateController::class, 'createTeacher'])->name('teachers.create');

/*Route::get('/upload', function () {
    return view('upload'); // This view contains your HTML form
});*/

Route::get('/upload', [CertificateController::class, 'showUploadForm'])->name('certificate.upload');


// Route to handle form submission (POST request only)
//Route::post('/extract', [CertificateController::class, 'extractCertificateData']);
Route::post('/extract', [CertificateController::class, 'extractCertificateData'])->name('extractCertificateData');
//Route::post('/extract', [CertificateController::class, 'debugExtract'])->name('extractCertificateData');


//edit and delete
Route::post('/certificate/update/{id}', [CertificateController::class, 'updateCertificate'])->name('certificate.update');
Route::delete('/certificate/delete/{id}', [CertificateController::class, 'deleteCertificate'])->name('certificate.delete');

//index
Route::get('/home', [CertificateController::class, 'showCertificates'])->name('home');

//summary
Route::get('/summary', function () {
    return view('summary');
});