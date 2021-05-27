<?php

use App\Events\UsersEvents;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\Users\OfficeController;
use App\Http\Controllers\Users\AdminController;
use App\Http\Controllers\Documents\DocumentController;
use App\Http\Controllers\Offices\DivSecClusController;
use App\Http\Controllers\Notifications\NotificationsController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Documents\DocumentExportImportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::get('getOfficesDivision', [DivSecClusController::class, 'getOfficesDivision']);
Route::get('getOfficesCluster', [DivSecClusController::class, 'getOfficesCluster']);
Route::get('getOffices', [DivSecClusController::class, 'getOffices']);

// Exports
Route::get('exportAllDocuments', [DocumentExportImportController::class, 'exportAllDocuments'])->name('exportAllDocuments');

Route::get('getSpecificUser', [OfficeController::class, 'getSpecificUser']);
Route::group(['middleware' => ['auth:sanctum', 'verified']], function(){
    // Needs to be auth when accessing notifications
    Route::get('getUserNotifications', [NotificationsController::class, 'getUserNotifications']);
    Route::get('readNotifications', [NotificationsController::class, 'readNotifications']);

    // Needs to be auth when accessing dashboard
    Route::get('getMostReceivedDocs', [DashboardController::class, 'getMostReceivedDocs']);
    Route::get('getUtilitiesCounts', [DashboardController::class, 'getUtilitiesCounts']);
    Route::get('getAPTAllReceivedDocs', [DashboardController::class, 'getAPTAllReceivedDocs']);
    
    // Route::get('getPRAppOverRec', [DashboardController::class, 'getPRAppOverRec']);
    // Route::get('getPOAppOverRec', [DashboardController::class, 'getPOAppOverRec']);
    // Route::get('getAPTperDocs', [DashboardController::class, 'getAPTperDocs']);

	// Office index
	Route::group(['prefix' => 'office', 'as' => 'office.', 'middleware' => ['role:office'] ], function(){

        // Custom function Returning Vue/Views
        Route::get('/mydocs', [DocumentController::class, 'mydocs'])->name('mydocs');
        Route::get('/logged', [DocumentController::class, 'logged'])->name('logged');
        Route::get('/outgoing', [DocumentController::class, 'outgoing'])->name('outgoing');
        Route::get('/docsHistory', [DocumentController::class, 'docsHistory'])->name('docsHistory');
        
        // Custom function Processing Data
        Route::get('/getMutatedDocument', [DocumentController::class, 'getMutatedDocument'])->name('getMutatedDocument');
        Route::get('/searchDocuments', [DocumentController::class, 'searchDocuments'])->name('searchDocuments');
        Route::get('/getFilteredDocumentsHistory', [DocumentController::class, 'getFilteredDocumentsHistory'])->name('getFilteredDocumentsHistory');
        Route::post('/routedoc', [DocumentController::class, 'routedoc'])->name('routedoc');
        Route::post('/logdoc', [DocumentController::class, 'logdoc'])->name('logdoc');
        Route::post('/createdoc', [DocumentController::class, 'create'])->name('createdoc');
		Route::resource('index', OfficeController::class)->names('dashboard');
	});

    // Admin index
    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['role:admin'] ], function(){
        Route::resource('index', AdminController::class)->names('dashboard');
    });

});

