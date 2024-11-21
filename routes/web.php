<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PatientsController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PharmaciesController;
use App\Http\Controllers\EmergenciesController;
use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\RecentActivityController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PharmacistController;


// // Public Routes
// Route::get('/', function () {
//     return view('welcome');
// });



// Authenticated Routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');

    // Doctor Routes
    Route::prefix('doctors')->group(function () {
        Route::get('/', [DoctorController::class, 'index'])->name('doctors.index');
        Route::get('/create', [DoctorController::class, 'create'])->name('doctors.create');
        Route::post('/', [DoctorController::class, 'store'])->name('doctors.store');
        Route::get('/{doctor}/edit', [DoctorController::class, 'edit'])->name('doctors.edit');
        Route::put('/{doctor}', [DoctorController::class, 'update'])->name('doctors.update');
        Route::delete('/{doctor}', [DoctorController::class, 'destroy'])->name('doctors.destroy');
    });

    // Other authenticated routes...
    // Example: Appointments and Pharmacies
    Route::prefix('appointments')->group(function () {
        Route::get('/', [AppointmentsController::class, 'index'])->name('appointments.index');
        Route::get('/create', [AppointmentsController::class, 'create'])->name('appointments.create');
        Route::post('/', [AppointmentsController::class, 'store'])->name('appointments.store');
        Route::get('/{appointment}/edit', [AppointmentsController::class, 'edit'])->name('appointments.edit');
        Route::put('/{appointment}', [AppointmentsController::class, 'update'])->name('appointments.update');
        Route::delete('/{appointment}', [AppointmentsController::class, 'destroy'])->name('appointments.destroy');
        Route::post('/appointments/{id}/confirm', [AppointmentsController::class, 'confirm'])->name('appointments.confirm');
        Route::post('/appointments/{appointment}/confirm', [AppointmentsController::class, 'confirm'])->name('appointments.confirm');

    });

    Route::prefix('pharmacies')->group(function () {
        Route::get('/', [PharmaciesController::class, 'index'])->name('pharmacies.index');
        Route::get('/create', [PharmaciesController::class, 'create'])->name('pharmacies.create');
        Route::post('/', [PharmaciesController::class, 'store'])->name('pharmacies.store');
        Route::get('/{pharmacy}/edit', [PharmaciesController::class, 'edit'])->name('pharmacies.edit');
        Route::put('/{pharmacy}', [PharmaciesController::class, 'update'])->name('pharmacies.update');
        Route::delete('/{pharmacy}', [PharmaciesController::class, 'destroy'])->name('pharmacies.destroy');
    });

    Route::prefix('patients')->group(function () {
        Route::get('/', [PatientsController::class, 'index'])->name('patients.index');
        Route::get('/create', [PatientsController::class, 'create'])->name('patients.create');
        Route::post('/', [PatientsController::class, 'store'])->name('patients.store');
        Route::get('/{patient}/edit', [PatientsController::class, 'edit'])->name('patients.edit');
        Route::put('/{patient}', [PatientsController::class, 'update'])->name('patients.update');
        Route::get('/patients/{patient}', 'PatientsController@show')->name('patients.show');
        Route::delete('/{patient}', [PatientsController::class, 'destroy'])->name('patients.destroy');

    });
    Route::resource('roles', RoleController::class);

    Route::get('/reports/appointments', [ReportController::class, 'appointmentReport'])->name('reports.appointments');
    Route::get('/reports/pharmacy', [ReportController::class, 'pharmacyReport'])->name('reports.pharmacy');
    Route::get('/report/doctors', [ReportController::class, 'doctorReport'])->name('reports.doctors');
    Route::get('/report/patients', [ReportController::class, 'patientReport'])->name('reports.patients');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
   
   Route::prefix('pharmacists')->group(function () {
    Route::get('/', [PharmacistController::class, 'index'])->name('pharmacists.index');
    Route::get('/create', [PharmacistController::class, 'create'])->name('pharmacists.create');
    Route::post('/', [PharmacistController::class, 'store'])->name('pharmacists.store');
    Route::get('/{pharmacist}/edit', [PharmacistController::class, 'edit'])->name('pharmacists.edit');
    Route::put('/{pharmacist}', [PharmacistController::class, 'update'])->name('pharmacists.update');
    Route::delete('/{pharmacist}', [PharmacistController::class, 'destroy'])->name('pharmacists.destroy');
});
  

});



