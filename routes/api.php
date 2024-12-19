<?php

use App\Http\Controllers\MarkerController;
use App\Http\Controllers\PolygonController;
use Illuminate\Support\Facades\Route;

// Marker routes
Route::get('markers', [MarkerController::class, 'index']);
Route::post('markers', [MarkerController::class, 'store']);
Route::delete('markers/{id}', [MarkerController::class, 'destroy']);

// Polygon routes
Route::get('polygons', [PolygonController::class, 'index']);
Route::post('polygons', [PolygonController::class, 'store']);
Route::delete('polygons/{id}', [PolygonController::class, 'destroy']);