<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\TicketController;

Route::get('/', function () {
    return view('admin.dashboard');
})->name('dashboard');

// Gestión de roles
Route::resource('roles', RoleController::class)->names('roles');
Route::resource('users', UserController::class)->names('users');
Route::resource('patients', PatientController::class)->names('patients');
Route::resource('doctors', DoctorController::class)->names('doctors');

// Soporte: tickets de reporte de problemas (solo listar y crear; sin editar/eliminar por defecto)
Route::get('tickets', [TicketController::class, 'index'])->name('tickets.index');
Route::get('tickets/create', [TicketController::class, 'create'])->name('tickets.create');
Route::post('tickets', [TicketController::class, 'store'])->name('tickets.store');
