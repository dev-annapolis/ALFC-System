<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\SalesReportController;
use App\Http\Controllers\SalesProcessorController;

Route::get('/', function () {
    return view('landing-page');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');



// Sale Processor
Route::get('/forms', [SalesProcessorController::class, 'showForm'])->name('form.show');












use App\Http\Controllers\UniversalTableController;
Route::get('/universal-table', [UniversalTableController::class, 'showRecords'])->name('universal.table');

use App\Http\Controllers\RolePermissionController;
Route::get('/permissions/edit', [RolePermissionController::class, 'edit'])->name('permissions.edit');
Route::post('/permissions/update', [RolePermissionController::class, 'update'])->name('permissions.update');


Route::get('/testusers', [TestController::class, 'userIndex'])->name('users.index');
Route::get('/users/{id}', action: [TestController::class, 'show'])->name('users.show');

Route::get('/salesreport/index', action: [SalesReportController::class, 'salesReportIndex'])->name('salesreport.index');
Route::get('/api/sales-report', [SalesReportController::class, 'salesReportData']);
// Route::get('/api/insurance-detail/{id}', [SalesReportController::class, 'fetchInsuranceDetail']);
Route::get('/api/insurance/details/{id}', [SalesReportController::class, 'showInsuranceDetails']);
Route::post('/api/insurance/details/update', [SalesReportController::class, 'updateInsuranceDetail']);




use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\DropdownController;

Route::middleware([RoleMiddleware::class . ':1,2'])->group(function () {
    Route::get('/teamsIndex', [DropdownController::class, 'teamsIndex'])->name('teams.index');
    Route::post('/teamsStore', [DropdownController::class, 'teamsStore'])->name('teams.store');
    Route::put('/teamsUpdate', [DropdownController::class, 'teamsUpdate'])->name('teams.update');
    Route::patch('/teamsChangeStatus/{id}', [DropdownController::class, 'teamsChangeStatus'])->name('teams.changeStatus');
});
