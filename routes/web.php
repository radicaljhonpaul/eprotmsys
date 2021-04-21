<?php

use App\Events\UsersEvents;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\Users\OfficeController;
use App\Http\Controllers\Users\AdminController;
use App\Http\Controllers\Documents\DocumentController;
use App\Http\Controllers\Offices\DivSecClusController;

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

Route::get('/animal', function () {
    broadcast(new UsersEvents("Yaawa"));
});


Route::get('getDivision', [DivSecClusController::class, 'getDivision']);
Route::get('getSection', [DivSecClusController::class, 'getSection']);
Route::get('getCluster', [DivSecClusController::class, 'getCluster']);

Route::group(['middleware' => ['auth:sanctum', 'verified']], function(){

	// Office index
	Route::group(['prefix' => 'office', 'as' => 'office.', 'middleware' => ['role:office'] ], function(){

        // Custom function Returning Vue/Views
        Route::get('/mydocs', [DocumentController::class, 'index'])->name('mydocs');
        Route::get('/incoming', [DocumentController::class, 'incoming'])->name('incoming');
        Route::get('/outgoing', [DocumentController::class, 'outgoing'])->name('outgoing');
        Route::get('/docshistory', [DocumentController::class, 'docshistory'])->name('docshistory');
        
        // Custom function Processing Data
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

