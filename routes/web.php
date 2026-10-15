<?php

use App\Http\Controllers\LibroController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'inicio')->name('inicio');

Route::get('/libros', [LibroController::class, 'index'])
    ->name('libros.index');

Route::post('/libros', [LibroController::class, 'store'])
    ->name('libros.store');

Route::put('/libros/{libro}', [LibroController::class, 'update'])
    ->name('libros.update');

Route::delete('/libros/{libro}', [LibroController::class, 'destroy'])
    ->name('libros.destroy');