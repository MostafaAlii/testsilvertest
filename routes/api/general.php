<?php

use App\Http\Controllers\Api\complaint\ComplaintController;

use App\Http\Controllers\Api\Orders\OrdersTricycleController;
use App\Http\Controllers\Api\Orders\OrderDayController;
use App\Http\Controllers\Api\Orders\OrderHourController;
use App\Http\Controllers\Api\Orders\OrdersController;
use App\Http\Controllers\Api\Orders\OrdersScooterController;
use App\Http\Controllers\Api\Wallet\WalletController;
use Illuminate\Support\Facades\Route;

//Route::post('rest', [OrdersController::class, 'rest']);
Route::group(['prefix' => 'order', 'middleware' => 'auth:users-api,captain-api'], function () {
    Route::post('getOrder', [OrdersController::class, 'index']);
    Route::post('createOrder', [OrdersController::class, 'store']);
    Route::post('updateStatus', [OrdersController::class, 'update']);
    Route::post('takingOrder', [OrdersController::class, 'takingOrder']);
    Route::post('takingCompleted', [OrdersController::class, 'takingCompleted']);
    Route::post('canselOrder', [OrdersController::class, 'cancelOrder']);
    // Deleted Orders
//    Route::post('deletedOrder', [OrdersController::class, 'deletedOrder']);
    Route::post('checkOrder', [OrdersController::class, 'checkOrder']);
    Route::get('sendNotationsCalculator', [OrdersController::class, 'sendNotationsCalculator']);
    Route::post('OrderExiting', [OrdersController::class, 'OrderExiting']);

    Route::get('getSavedOrders', [OrdersController::class, 'getSavedOrders']);

    ################# Create Orders Hours #########################
    Route::prefix('hours')->as('hours')->group(function () {
//        Route::post('getOrder',[OrderHourController::class,'index']);
        Route::post('saveHours', [OrderHourController::class, 'saveHours']);
        Route::post('canselHours', [OrderHourController::class, 'canselHours']);
        Route::post('createOrder', [OrderHourController::class, 'store']);
//        Route::post('updateStatus', [OrderHourController::class, 'update']);
//        Route::post('canselOrder', [OrderHourController::class, 'canselOrder']);
        Route::post('UserDuration', [OrderHourController::class, 'UserDuration']);
    });

    ################# Create Orders Day #########################
    Route::prefix('day')->as('day')->group(function () {
//        Route::post('getOrder',[OrderDayController::class,'index']);
        Route::post('createOrder', [OrderDayController::class, 'store']);
        Route::post('saveDay', [OrderDayController::class, 'saveDay']);
//        Route::post('updateStatus', [OrderDayController::class, 'update']);
//        Route::post('canselOrder', [OrderDayController::class, 'canselOrder']);
        Route::post('canselDay', [OrderDayController::class, 'canselDay']);
        Route::post('UserDuration', [OrderDayController::class, 'UserDuration']);
    });


    Route::prefix('scooters')->as('scooters')->group(function () {
        Route::post('getOrder', [OrdersScooterController::class, 'index']);
        Route::post('createOrder', [OrdersScooterController::class, 'store']);
        Route::post('updateStatus', [OrdersScooterController::class, 'update']);
        Route::post('canselOrder', [OrdersScooterController::class, 'cancelOrder']);
        Route::post('checkOrder', [OrdersScooterController::class, 'checkOrder']);
        Route::post('takingOrder', [OrdersScooterController::class, 'takingOrder']);
        Route::post('takingCompleted', [OrdersScooterController::class, 'takingCompleted']);
        Route::post('OrderExiting', [OrdersScooterController::class, 'OrderExiting']);

    });



    Route::prefix('tricycle')->as('tricycle')->group(function () {
        Route::post('getOrder', [OrdersTricycleController::class, 'index']);
        Route::post('createOrder', [OrdersTricycleController::class, 'store']);
        Route::post('updateStatus', [OrdersTricycleController::class, 'update']);
        Route::post('canselOrder', [OrdersTricycleController::class, 'cancelOrder']);
        Route::post('checkOrder', [OrdersTricycleController::class, 'checkOrder']);
        Route::post('takingOrder', [OrdersTricycleController::class, 'takingOrder']);
        Route::post('takingCompleted', [OrdersTricycleController::class, 'takingCompleted']);
        Route::post('OrderExiting', [OrdersTricycleController::class, 'OrderExiting']);
    });



});


Route::group(['prefix' => 'wallet', 'middleware' => 'auth:users-api,captain-api'], function () {
    Route::post('getAmounts', [WalletController::class, 'index']);
    Route::post('createAmounts', [WalletController::class, 'store']);
});


Route::group(['prefix' => 'complaint', 'middleware' => 'auth:users-api,captain-api'], function () {
    Route::post('complaint', [ComplaintController::class, 'store']);
});
