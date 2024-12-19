<?php

use App\Http\Controllers\HandsOnController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MarkerController;
use App\Http\Controllers\PolygonController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::get('/tugas-handson-1', [HandsOnController::class, 'tugas1'])->name('tugas-handson-1');
Route::get('/tugas-handson-2', [HandsOnController::class, 'tugas2'])->name('tugas-handson-2');

>>>>>>> Stashed changes
// Marker routes
Route::get('/api/markers', [MarkerController::class, 'index']);
Route::post('/api/markers', [MarkerController::class, 'store']);
Route::delete('/api/markers/{id}', [MarkerController::class, 'destroy']);

// Polygon routes
Route::get('/api/polygons', [PolygonController::class, 'index']);
Route::post('/api/polygons', [PolygonController::class, 'store']);
Route::delete('/api/polygons/{id}', [PolygonController::class, 'destroy']);

Route::get('/home', [DashboardController::class, 'index'])->name('home');