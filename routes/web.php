<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\SalesReportController;
use App\Http\Controllers\SalesProcessorController;
use App\Http\Controllers\RevenueAssistantController;
use App\Http\Controllers\SalesProcessorSupervisorController;

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
Route::post('/api/ra/{id}/comments', [RevenueAssistantController::class, 'postComment']);
Route::post('/api/ra/verify/{id}', [RevenueAssistantController::class, 'verifyInsuranceDetail']);

Route::get('/sps/index', [SalesProcessorSupervisorController::class, 'SalesProcessorSupervisorIndex'])->name('sps.index');
Route::get('/api/sps-index', [SalesProcessorSupervisorController::class, 'spsIndexData']);



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


    // SOURCES
    Route::get('/sourcesIndex', [DropdownController::class, 'sourcesIndex'])->name('sources.index');
    Route::post('/sourcesStore', [DropdownController::class, 'sourcesStore'])->name('sources.store');
    Route::put('/sourcesUpdate', [DropdownController::class, 'sourcesUpdate'])->name('sources.update');
    Route::patch('/sourcesChangeStatus/{id}', [DropdownController::class, 'sourcesChangeStatus'])->name('sources.changeStatus');


    // SOURCE BRANCHES
    Route::get('/sourceBranchesIndex', [DropdownController::class, 'sourceBranchesIndex'])->name('source_branches.index');
    Route::post('/sourceBranchesStore', [DropdownController::class, 'sourceBranchesStore'])->name('source_branches.store');
    Route::put('/sourceBranchesUpdate', [DropdownController::class, 'sourceBranchesUpdate'])->name('source_branches.update');
    Route::patch('/sourceBranchesChangeStatus/{id}', [DropdownController::class, 'sourceBranchesChangeStatus'])->name('source_branches.changeStatus');




    // MODE OF PAYMENTS
    Route::get('/modeOfPaymentsIndex', [DropdownController::class, 'modeOfPaymentsIndex'])->name('mode_of_payments.index');
    Route::post('/modeOfPaymentsStore', [DropdownController::class, 'modeOfPaymentsStore'])->name('mode_of_payments.store');
    Route::put('/modeOfPaymentsUpdate', [DropdownController::class, 'modeOfPaymentsUpdate'])->name('mode_of_payments.update');
    Route::patch('/modeOfPaymentsChangeStatus/{id}', [DropdownController::class, 'modeOfPaymentsChangeStatus'])->name('mode_of_payments.changeStatus');


    // SUBPRODUCTS
    Route::get('/subproductsIndex', [DropdownController::class, 'subproductsIndex'])->name('subproducts.index');
    Route::post('/subproductsStore', [DropdownController::class, 'subproductsStore'])->name('subproducts.store');
    Route::put('/subproductsUpdate', [DropdownController::class, 'subproductsUpdate'])->name('subproducts.update');
    Route::patch('/subproductsChangeStatus/{id}', [DropdownController::class, 'subproductsChangeStatus'])->name('subproducts.changeStatus');


    // IF GDFI
    Route::get('/ifGdfis', [DropdownController::class, 'ifGdfiIndex'])->name('gdfis.index');
    Route::post('/ifGdfiStore', [DropdownController::class, 'ifGdfiStore'])->name('gdfis.store');
    Route::put('/ifGdfiUpdate', [DropdownController::class, 'ifGdfiUpdate'])->name('gdfis.update');
    Route::patch('/ifGdfiChangeStatus/{id}', [DropdownController::class, 'ifGdfiChangeStatus'])->name('gdfis.changeStatus');









    // COMMISIONERS
    // TELES
});


