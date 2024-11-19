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

Route::get('/home', function () {
    $allTeachers = \App\Models\Teacher::all();
    return view('home', compact('allTeachers'));
})->name('home');

//create teacher
Route::post('/teachers/create', [CertificateController::class, 'createTeacher'])->name('teachers.create');

//home
Route::get('/profile', [CertificateController::class, 'showCertificates'])->name('profile');

//upload
Route::get('/upload', [CertificateController::class, 'showUploadForm'])->name('certificate.upload');

//extract
Route::post('/extract', [CertificateController::class, 'extractCertificateData'])->name('extractCertificateData');

//edit and delete
Route::post('/certificate/update/{id}', [CertificateController::class, 'updateCertificate'])->name('certificate.update');
Route::delete('/certificate/delete/{id}', [CertificateController::class, 'deleteCertificate'])->name('certificate.delete');

//summary
Route::get('/summary/{teacherId?}', [CertificateController::class, 'showSummary'])->name('summary');