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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('itinerancies', ItinerancyController::class);
    Route::resource('evaluations', EvaluationController::class);
    Route::resource('students', StudentController::class);
    Route::get('/evaluations/create/{itinerancy_id}', [ EvaluationController::class, 'create', 'itinerancy_id' ]);

});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
