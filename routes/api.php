<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ClientApiController;
use App\Http\Controllers\Api\KycApiController;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\TradeApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register-email',[ClientApiController::class,'registerEmail']);
Route::post('verify-otp',[ClientApiController::class,'verifyOTP']);
Route::post('set-password',[ClientApiController::class,'setPassword']);
Route::post('set-forgot-password',[ClientApiController::class,'setForgotPassword']);
Route::post('request-otp',[ClientApiController::class,'requestOTP']);
Route::post('login',[ClientApiController::class,'login']);


Route::group(['middleware'=>'auth:sanctum'],function() {
//client
    Route::post('logout', [ClientApiController::class, 'logout']);
    Route::post('upload-profile', [ClientApiController::class, 'profileUpload']);
    Route::post('client-info', [ClientApiController::class, 'clientInformation']);

//kyc
    Route::post('kyc-type', [KycApiController::class, 'kycType']);
    Route::post('countries', [KycApiController::class, 'countries']);
    Route::post('kyc-client', [KycApiController::class, 'kycClient']);

//order
    Route::post('currency', [OrderApiController::class, 'currency']);
    Route::post('order', [OrderApiController::class, 'order']);
    Route::post('your-order', [OrderApiController::class, 'yourOrder']);
//wallet
    Route::post('wallet',[OrderApiController::class,'wallet']);
//withdrawal
    Route::post('withdrawal',[OrderApiController::class,'withdrawal']);
    Route::post('your-withdrawal',[OrderApiController::class,'yourWithdrawal']);


// Trade
   Route::post('trade-type',[TradeApiController::class,'typeTrade']);
   Route::post('trade',[TradeApiController::class,'trade']);
    Route::post('trade-list',[TradeApiController::class,'tradeList']);
    Route::post('usdt-trade',[TradeApiController::class,'usdtTrade']);
    Route::post('line-id',[TradeApiController::class,'lineId']);
});
