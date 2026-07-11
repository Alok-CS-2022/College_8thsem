<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\TestResultController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClinicController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('permission:patient.view,patient.edit')->group(function () {
        Route::resource('patients', PatientController::class)->only(['index', 'create', 'store', 'show']);
        Route::resource('appointments', AppointmentController::class)->only(['index', 'create', 'store']);
        Route::patch('/appointments/{appointment}/check-in', [AppointmentController::class, 'checkIn'])->name('appointments.check-in');
    });

    Route::middleware('permission:medical.enter')->group(function () {
        Route::get('/test-results', [TestResultController::class, 'index'])->name('test-results.index');
        Route::get('/test-results/{appointment}/create', [TestResultController::class, 'create'])->name('test-results.create');
        Route::post('/test-results/{appointment}', [TestResultController::class, 'store'])->name('test-results.store');
    });

    Route::middleware('permission:medical.review')->group(function () {
        Route::get('/certificates', [CertificateController::class, 'index'])->name('certificates.index');
        Route::post('/certificates/{testResult}', [CertificateController::class, 'store'])->name('certificates.store');
    });

    Route::middleware('permission:user.manage')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::patch('/users/{user}/status', [UserController::class, 'updateStatus'])->name('users.status');
    });

    Route::middleware('permission:clinic.approve')->group(function () {
        Route::get('/clinics', [ClinicController::class, 'index'])->name('clinics.index');
        Route::patch('/clinics/{clinic}/status', [ClinicController::class, 'updateStatus'])->name('clinics.status');
    });
});

require __DIR__.'/auth.php';
