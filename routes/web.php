<?php

use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\ItinerancyController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [ ItinerancyController::class, 'index' ]);

Auth::routes();

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);

    Route::get('/evaluations/create/{itinerancy_id}', [ EvaluationController::class, 'create', 'itinerancy_id' ]);
    Route::get('/students/create/{evaluation_id}', [ StudentController::class, 'create', 'evaluation_id' ]);
    Route::get('/students/itinerant_view/{evaluation_id}', [ StudentController::class, 'itinerantView', 'evaluation_id' ])->name('itinerant_view');
    Route::get('/itinerancy/export/{itinerancy_id}', [ItinerancyController::class, 'export', 'itinerancy_id'])->name('itinerancies.export');

    Route::post('/students/itinerant_view/update', [ StudentController::class, 'itinerantUpdate' ])->name('itinerant_view_update');
    Route::post('/students/update_order', [ StudentController::class, 'updateOrder' ]);

    Route::resource('itinerancies', ItinerancyController::class);
    Route::resource('evaluations', EvaluationController::class);
    Route::resource('students', StudentController::class);
});
