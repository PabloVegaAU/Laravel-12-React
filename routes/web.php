<?php

use App\Http\Controllers\Admin\AlumnoController;
use App\Http\Controllers\Admin\DocenteController;
use App\Http\Controllers\Admin\GradoController;
use App\Http\Controllers\Admin\MateriaController;
use App\Http\Controllers\Admin\SeccionController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');

    Route::get('admin', function () {
        return Inertia::render('admin/index');
    })->name('admin');

    Route::resource('admin/users', UserController::class)->names('admin.users');
    Route::resource('admin/docentes', DocenteController::class)->names('admin.docentes');
    Route::resource('admin/alumnos', AlumnoController::class)->names('admin.alumnos');
    Route::resource('admin/grados', GradoController::class)->names('admin.grados');
    Route::resource('admin/secciones', SeccionController::class)->names('admin.secciones');
    Route::resource('admin/materias', MateriaController::class)->names('admin.materias');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
