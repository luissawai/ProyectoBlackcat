<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PoliticasController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;



Route::get('/', [HomeController::class, 'index'])->name('public.home.index');


// POLITICAS
Route::get('/politica-privacidad', [PoliticasController::class, 'privacidad'])->name('privacidad');
Route::get('/politica-cookies', [PoliticasController::class, 'cookies'])->name('cookies');
Route::get('/aviso-legal', [PoliticasController::class, 'aviso_legal'])->name('aviso-legal');
Route::post('/contact', [ContactController::class, 'store'])->name('public.contact.store');
Route::post('/formulario-contacto', [ContactController::class, 'store'])->name('formulario.store');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';