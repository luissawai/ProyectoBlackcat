<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\CookieAuditController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PoliticasController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;



Route::get('/', [HomeController::class, 'index'])->name('public.home.index');

// COOKIES
Route::post('/cookies/consent', [CookieAuditController::class, 'storeConsent']);
Route::get('/cookies/consent/{uuid}', [CookieAuditController::class, 'getConsent']);

// POLITICAS
Route::get('/politica-privacidad', [PoliticasController::class, 'privacidad'])->name('privacidad');
Route::get('/politica-cookies', [PoliticasController::class, 'cookies'])->name('cookies');
Route::get('/aviso-legal', [PoliticasController::class, 'aviso_legal'])->name('aviso-legal');
Route::post('/api/contact-form', [ContactController::class, 'store']);


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
