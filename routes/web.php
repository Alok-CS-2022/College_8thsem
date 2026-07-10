<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\TestResultController;
use App\Http\Controllers\CertificateController;
use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('role:Super Admin,Clinic Admin')->group(function () {
        Route::resource('patients', PatientController::class);
        Route::resource('appointments', AppointmentController::class);
    });

    Route::middleware('role:Super Admin,Lab Technician,X-Ray Technician')->group(function () {
        Route::get('/test-results', [TestResultController::class, 'index'])->name('test-results.index');
        Route::get('/test-results/{appointment}/create', [TestResultController::class, 'create'])->name('test-results.create');
        Route::post('/test-results/{appointment}', [TestResultController::class, 'store'])->name('test-results.store');
    });

    Route::middleware('role:Super Admin,Doctor')->group(function () {
        Route::get('/certificates', [CertificateController::class, 'index'])->name('certificates.index');
        Route::post('/certificates/{testResult}', [CertificateController::class, 'store'])->name('certificates.store');
    });
});
require __DIR__.'/auth.php';
