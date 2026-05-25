<?php

use App\Http\Controllers\Api\DeliveryController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

// Rutas API protegidas con Sanctum + permisos del guard api
Route::get('products', [ProductController::class, 'index']);
Route::post('deliveries/{delivery}/confirm', [DeliveryController::class, 'confirm']);
