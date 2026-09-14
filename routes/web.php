<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// 1. Ruta para la pantalla de Login
Route::get('/', function () {
    return view('login');
})->name('login');

// 2. Procesar el inicio de sesión según el rol seleccionado
Route::post('/login', function (Request $request) {
    $puesto = $request->input('puesto', 'mesero');
    if ($puesto === 'admin') {
        return redirect()->route('admin');
    }
    return redirect()->route('mesero');
})->name('login.post');

// 3. Ruta para la sección completa de Mesero
Route::get('/mesero', function () {
    return view('mesero');
})->name('mesero');

// 4. Ruta para la sección completa de Administrador
Route::get('/admin', function () {
    return view('admin');
})->name('admin');