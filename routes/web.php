<?php

use App\Http\Controllers\MovementController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
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
});

// Products — protegido con atributos #[Middleware] en el controlador
Route::resource('products', ProductController::class);

// Movements
Route::get('/movements', [MovementController::class, 'index'])->name('movements.index');
Route::get('/movements/create', [MovementController::class, 'create'])->name('movements.create');
Route::post('/movements', [MovementController::class, 'store'])->name('movements.store');
Route::patch('/movements/{movement}/approve', [MovementController::class, 'approve'])->name('movements.approve');

// Roles — CRUD dinámico (solo para 'gestionar roles')
Route::resource('roles', RoleController::class);

require __DIR__.'/auth.php';
