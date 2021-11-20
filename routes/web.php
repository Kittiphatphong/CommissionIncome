<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\OrderController;
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

Route::group(['middleware' => 'auth'], function() {
    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');

    Route::resource('users',UserController::class);

    Route::resource('clients',ClientController::class);

    Route::resource('countries',CountryController::class);

    Route::resource('currencies',CurrencyController::class);
    Route::post('rate{id}',[CurrencyController::class,'updateRate'])->name('rate.update');

    Route::resource('order',OrderController::class);
});



require __DIR__.'/auth.php';
