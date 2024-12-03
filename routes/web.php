<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\SalesReportController;
use App\Http\Controllers\SalesProcessorController;
use App\Http\Controllers\RevenueAssistantController;
Route::get('/', function () {
    return view('landing-page');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');



// Sale Processor
Route::get('/forms', [SalesProcessorController::class, 'showForm'])->name('form.show');
Route::get('/clients/search', [SalesProcessorController::class, 'searchClients'])->name('clients.search');
Route::post('/forms/submitForm', [SalesProcessorController::class, 'submitForm'])->name('form.submit');






use App\Http\Controllers\UniversalTableController;
Route::get('/universal-table', [UniversalTableController::class, 'showRecords'])->name('universal.table');

use App\Http\Controllers\RolePermissionController;
Route::get('/permissions/edit', [RolePermissionController::class, 'edit'])->name('permissions.edit');
Route::post('/permissions/update', [RolePermissionController::class, 'update'])->name('permissions.update');


Route::get('/testusers', [TestController::class, 'userIndex'])->name('users.index');
Route::get('/users/{id}', [TestController::class, 'show'])->name('users.show');

Route::get('/salesreport/index', [SalesReportController::class, 'salesReportIndex'])->name('salesreport.index');
Route::get('/api/sales-report', [SalesReportController::class, 'salesReportData']);
// Route::get('/api/insurance-detail/{id}', [SalesReportController::class, 'fetchInsuranceDetail']);
Route::get('/api/insurance/details/{id}', [SalesReportController::class, 'showInsuranceDetails']);
Route::post('/api/insurance/details/update', [SalesReportController::class, 'updateInsuranceDetail']);

Route::get('/ra/index', [RevenueAssistantController::class, 'RevenueAssistantIndex'])->name('ra.index');
Route::get('/api/ra-index', [RevenueAssistantController::class, 'raIndexData']);
Route::get('/api/view-commission/{insurance_details_id}', [RevenueAssistantController::class, 'viewCommission']);
Route::post('/api/update-commission/{insurance_details_id}', [RevenueAssistantController::class, 'updateCommission']);


use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\DropdownController;

Route::middleware([RoleMiddleware::class . ':1,2'])->group(function () {
    // ROLES
    // TEAMS
    Route::get('/teamsIndex', [DropdownController::class, 'teamsIndex'])->name('teams.index');
    Route::post('/teamsStore', [DropdownController::class, 'teamsStore'])->name('teams.store');
    Route::put('/teamsUpdate', [DropdownController::class, 'teamsUpdate'])->name('teams.update');
    Route::patch('/teamsChangeStatus/{id}', [DropdownController::class, 'teamsChangeStatus'])->name('teams.changeStatus');

    // PROVIDERS
    Route::get('/providersIndex', [DropdownController::class, 'providersIndex'])->name('providers.index');
    Route::post('/providersStore', [DropdownController::class, 'providersStore'])->name('providers.store');
    Route::put('/providersUpdate', [DropdownController::class, 'providersUpdate'])->name('providers.update');
    Route::patch('/providersChangeStatus/{id}', [DropdownController::class, 'providersChangeStatus'])->name('providers.changeStatus');

    // ALFC BRANCHES
    Route::get('/alfcBranchesIndex', [DropdownController::class, 'alfcBranchesIndex'])->name('alfcBranches.index');
    Route::post('/alfcBranchesStore', [DropdownController::class, 'alfcBranchesStore'])->name('alfcBranches.store');
    Route::put('/alfcBranchesUpdate', [DropdownController::class, 'alfcBranchesUpdate'])->name('alfcBranches.update');
    Route::patch('/alfcBranchesChangeStatus/{id}', [DropdownController::class, 'alfcBranchesChangeStatus'])->name('alfcBranches.changeStatus');

    // PRODUCTS
    Route::get('/productsIndex', [DropdownController::class, 'productsIndex'])->name('products.index');
    Route::post('/productsStore', [DropdownController::class, 'productsStore'])->name('products.store');
    Route::put('/productsUpdate', [DropdownController::class, 'productsUpdate'])->name('products.update');
    Route::patch('/productsChangeStatus/{id}', [DropdownController::class, 'productsChangeStatus'])->name('products.changeStatus');


    // AREAS
    Route::get('/areasIndex', [DropdownController::class, 'areasIndex'])->name('areas.index');
    Route::post('/areasStore', [DropdownController::class, 'areasStore'])->name('areas.store');
    Route::put('/areasUpdate', [DropdownController::class, 'areasUpdate'])->name('areas.update');
    Route::patch('/areasChangeStatus/{id}', [DropdownController::class, 'areasChangeStatus'])->name('areas.changeStatus');






    // SUBPRODUCTS
    // SOURCES
    // SOURCE BRANCHES
    // IF GDFI
    // ALFC BRANCHES
    // MODE OF PAYMENTS
    // COMMISIONERS
    // TELES
});


