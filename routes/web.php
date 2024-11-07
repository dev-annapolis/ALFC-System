<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TestController;
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


Route::get('/testusers', [TestController::class, 'userIndex'])->name('users.index');
Route::get('/users/{id}', [TestController::class, 'show'])->name('users.show');
