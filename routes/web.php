<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas web (públicas y autenticadas)
|--------------------------------------------------------------------------
| La ruta raíz redirige a login o al panel admin. Las rutas del panel
| (Dashboard, Roles, Usuarios, Pacientes, Doctores, Soporte/Tickets)
| están en routes/admin.php con prefijo /admin y middleware auth.
|--------------------------------------------------------------------------
*/

// Raíz: si no está logueado va a login; si está logueado va al panel admin
Route::get('/', function () {
    return auth()->check() ? redirect('/admin') : redirect()->route('login');
})->name('home');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
