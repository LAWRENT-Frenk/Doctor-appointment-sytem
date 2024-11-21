<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PatientsController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PharmaciesController;
use App\Http\Controllers\PharmacistsController;
use App\Http\Controllers\EmergenciesController;
use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\RecentActivityController;

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

// Authenticated Routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Doctor Routes
    Route::prefix('doctors')->middleware('permission:view doctors')->group(function () {
        Route::get('/', [DoctorController::class, 'index'])->name('doctors.index');
        Route::get('/create', [DoctorController::class, 'create'])->name('doctors.create')->middleware('permission:create doctors');
        Route::post('/', [DoctorController::class, 'store'])->name('doctors.store');
        Route::get('/{doctor}/edit', [DoctorController::class, 'edit'])->name('doctors.edit')->middleware('permission:edit doctors');
        Route::put('/{doctor}', [DoctorController::class, 'update'])->name('doctors.update');
        Route::delete('/{doctor}', [DoctorController::class, 'destroy'])->name('doctors.destroy');
    });

    // Pharmacists Routes
    Route::prefix('pharmacists')->middleware('permission:view pharmacists')->group(function () {
        Route::get('/', [PharmacistsController::class, 'index'])->name('pharmacists.index');
        Route::get('/create', [PharmacistsController::class, 'create'])->name('pharmacists.create')->middleware('permission:create pharmacists');
        Route::post('/', [PharmacistsController::class, 'store'])->name('pharmacists.store');
        Route::get('/{pharmacist}/edit', [PharmacistsController::class, 'edit'])->name('pharmacists.edit')->middleware('permission:edit pharmacists');
        Route::put('/{pharmacist}', [PharmacistsController::class, 'update'])->name('pharmacists.update');
        Route::delete('/{pharmacist}', [PharmacistsController::class, 'destroy'])->name('pharmacists.destroy');
    });

    // Appointments Routes
    Route::prefix('appointments')->middleware('permission:view appointments')->group(function () {
        Route::get('/', [AppointmentsController::class, 'index'])->name('appointments.index');
        Route::get('/create', [AppointmentsController::class, 'create'])->name('appointments.create')->middleware('permission:create appointments');
        Route::post('/', [AppointmentsController::class, 'store'])->name('appointments.store');
        Route::get('/{appointment}/edit', [AppointmentsController::class, 'edit'])->name('appointments.edit')->middleware('permission:edit appointments');
        Route::put('/{appointment}', [AppointmentsController::class, 'update'])->name('appointments.update');
        Route::delete('/{appointment}', [AppointmentsController::class, 'destroy'])->name('appointments.destroy');
        Route::post('/appointments/{id}/confirm', [AppointmentsController::class, 'confirm'])->name('appointments.confirm')->middleware('permission:confirm appointments');
    });

    // Pharmacies Routes
    Route::prefix('pharmacies')->middleware('permission:view pharmacies')->group(function () {
        Route::get('/', [PharmaciesController::class, 'index'])->name('pharmacies.index');
        Route::get('/create', [PharmaciesController::class, 'create'])->name('pharmacies.create')->middleware('permission:create pharmacies');
        Route::post('/', [PharmaciesController::class, 'store'])->name('pharmacies.store');
        Route::get('/{pharmacy}/edit', [PharmaciesController::class, 'edit'])->name('pharmacies.edit')->middleware('permission:edit pharmacies');
        Route::put('/{pharmacy}', [PharmaciesController::class, 'update'])->name('pharmacies.update');
        Route::delete('/{pharmacy}', [PharmaciesController::class, 'destroy'])->name('pharmacies.destroy');
    });

    // Patients Routes
    Route::prefix('patients')->middleware('permission:view patients')->group(function () {
        Route::get('/', [PatientsController::class, 'index'])->name('patients.index');
        Route::get('/create', [PatientsController::class, 'create'])->name('patients.create')->middleware('permission:create patients');
        Route::post('/', [PatientsController::class, 'store'])->name('patients.store');
        Route::get('/{patient}/edit', [PatientsController::class, 'edit'])->name('patients.edit')->middleware('permission:edit patients');
        Route::put('/{patient}', [PatientsController::class, 'update'])->name('patients.update');
        Route::get('/{patient}', [PatientsController::class, 'show'])->name('patients.show');
        Route::delete('/{patient}', [PatientsController::class, 'destroy'])->name('patients.destroy');
    });

    // Report Routes
    Route::prefix('reports')->middleware('permission:view reports')->group(function () {
        Route::get('/appointments', [ReportController::class, 'appointmentReport'])->name('reports.appointments')->middleware('permission:view appointment reports');
        Route::get('/pharmacy', [ReportController::class, 'pharmacyReport'])->name('reports.pharmacy')->middleware('permission:view pharmacy reports');
        Route::get('/doctors', [ReportController::class, 'doctorReport'])->name('reports.doctors')->middleware('permission:view doctor reports');
        Route::get('/patients', [ReportController::class, 'patientReport'])->name('reports.patients')->middleware('permission:view patient reports');
    });

    // Roles Routes
    Route::resource('roles', RoleController::class)->middleware('permission:view roles');
});
