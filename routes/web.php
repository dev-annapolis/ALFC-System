<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing-page');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/form', [App\Http\Controllers\HomeController::class, 'showForm'])->name('form.show');
