<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
Route::get('/', function () {
    return view('landing-page');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/form', [HomeController::class, 'showForm'])->name('form.show');






use App\Http\Controllers\UniversalTableController;
Route::get('/universal-table', [UniversalTableController::class, 'showRecords'])->middleware('auth');

use App\Http\Controllers\RolePermissionController;
Route::get('/permissions/edit', [RolePermissionController::class, 'edit'])->name('permissions.edit');
Route::post('/permissions/update', [RolePermissionController::class, 'update'])->name('permissions.update');
