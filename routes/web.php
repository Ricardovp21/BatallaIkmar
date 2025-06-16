<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return Inertia::render('Bienvenido');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
});

// ✅ Login manual
Route::get('/login', function () {
    return Inertia::render('Auth/Login', [
        'canResetPassword' => true, // puedes poner true directamente si no quieres depender de rutas
        'status' => session('status'),
    ]);
});

// ✅ Register manual
Route::get('/register', function () {
    return Inertia::render('Auth/Register');
});


require __DIR__.'/auth.php';
