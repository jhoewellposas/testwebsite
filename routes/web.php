<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RankDistributionController;
use App\Http\Controllers\CertificateController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/home', function () {
        $allTeachers = \App\Models\Teacher::all();
        return view('home', compact('allTeachers'));
    })->name('home');
    
    //user profile
    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::post('/user', [UserController::class, 'update'])->name('user.update');
    Route::post('/user/delete', [UserController::class, 'destroy'])->name('user.delete');

    //create teacher
    Route::post('/teachers/create', [CertificateController::class, 'createTeacher'])->name('teachers.create');

    //profile
    Route::get('/profile', [CertificateController::class, 'showCertificates'])->name('profile');

    //upload
    Route::get('/upload', [CertificateController::class, 'showUploadForm'])->name('certificate.upload');

    //extract
    Route::post('/extract', [CertificateController::class, 'extractCertificateData'])->name('extractCertificateData');

    //update certificate
    Route::post('/certificate/update/{id}', [CertificateController::class, 'updateCertificate'])->name('certificate.update');

    //delete certificate
    Route::delete('/certificate/delete/{id}', [CertificateController::class, 'deleteCertificate'])->name('certificate.delete');

    //update teacher
    Route::post('/teacher/update/{id}', [CertificateController::class, 'updateTeacher'])->name('teachers.update');

    //rank distribution
    Route::get('/rank-distributions', [RankDistributionController::class, 'index'])->name('rankDistributions.index');
    Route::post('/rank-distributions', [RankDistributionController::class, 'update'])->name('rankDistributions.update');

    //summary
    Route::get('/summary/{teacherId?}', [CertificateController::class, 'showSummary'])->name('summary');
});


