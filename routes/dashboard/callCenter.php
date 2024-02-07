<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\CallCenter;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Dashboard\Admin\Order;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ], function () {
    Route::group(['prefix' => 'callCenter', 'middleware' => 'auth:call-center'], function () {
        Route::get('dashboard', [CallCenter\CallCenterDashboardController::class, 'index'])->name('callCenter.dashboard');
        // Captains ::
        Route::resource('CallCenterCaptains', CallCenter\CaptainController::class)->parameters(['CallCenterCaptains' => 'id']);
        Route::put('/captains/{id}/updateStatus', [CallCenter\CaptainController::class, 'updateActivityStatus'])->name('CallCenterCaptains.updateActivityStatus');
        // Car ::
        Route::post('CallCenterCaptains/upload-media', [CallCenter\CaptainController::class, 'uploadPersonalMedia'])->name('CallCenterCaptains.uploadMedia');
        Route::post('CallCenterCaptains/upload-car-media', [CallCenter\CaptainController::class, 'uploadCarMedia'])->name('CallCenterCaptains.uploadCarMedia');
        Route::post('CallCenterCaptains/update-media-status/{id}', [CallCenter\CaptainController::class, 'updatePersonalMediaStatus'])->name('CallCenterCaptains.updateMediaStatus');
        Route::post('CallCenterCaptains/update-car-status/{id}', [CallCenter\CaptainController::class, 'updateCarStatus'])->name('CallCenterCaptains.updateCarStatus');
        // Scooter ::
        Route::post('CallCenterCaptains/upload-scooter-personal-media', [CallCenter\CaptainController::class, 'uploadScooterPersonalMedia'])->name('CallCenterCaptains.uploadScooterPersonalMedia');
        Route::post('CallCenterCaptains/upload-scooter-media', [CallCenter\CaptainController::class, 'uploadScooterMedia'])->name('CallCenterCaptains.uploadScooterMedia');
        Route::post('CallCenterCaptains/update-scooter-media-status/{id}', [CallCenter\CaptainController::class, 'updateScooterMediaStatus'])->name('CallCenterCaptains.updateScooterMediaStatus');
        Route::post('CallCenterCaptains/upload-scooter-rejected-image', [CallCenter\CaptainController::class, 'uploadScooterRejectedImage'])->name('CallCenterCaptains.uploadScoterRejectedImage');
        // Tricycle ::
        Route::post('CallCenterCaptains/update-tricycle-media-status/{id}', [CallCenter\CaptainController::class, 'updateTricycleMediaStatus'])->name('CallCenterCaptains.updateTricycleMediaStatus');
        Route::post('CallCenterCaptains/upload-tricycle-rejected-image', [CallCenter\CaptainController::class, 'uploadTricycleRejectedImage'])->name('CallCenterCaptains.uploadTricycleRejectedImage');

        Route::get('CallCenterCaptains/trips/{id}', [CallCenter\CaptainController::class, 'trips'])->name('CallCenterCaptains.trips');
        Route::put('CallCenterCaptains/profile/{id}', [CallCenter\CaptainController::class, 'updateProfile'])->name('CallCenterCaptains.updateProfile');

        Route::post('captains/sendNotification/All/callCenter', [CallCenter\CaptainController::class, 'sendNotificationAll'])->name('captains.sendNotification_callCenter');
        Route::get('captains_searchNumber', [CallCenter\CaptainController::class, 'captains_searchNumber'])->name('captains.searchNumber');

        Route::post('/captains/switch-type/{id}', [CallCenter\CaptainController::class, 'switchType'])->name('captains.switchType');
        Route::controller(CallCenter\CaptainController::class)->prefix('orders')->as('callCenterOrders.')->group(function () {
            Route::get('/{order_code}', 'showOrder')->name('show');
        });
        // Order Hour ::
        Route::controller(CallCenter\CaptainController::class)->prefix('order-hour')->as('callCenterOrderHour.')->group(function () {
            Route::get('/{order_code}', 'showOrderHour')->name('show');
        });
        // Order Day ::
        Route::controller(CallCenter\CaptainController::class)->prefix('order-day')->as('callCenterOrderDay.')->group(function () {
            Route::get('/{order_code}', 'showOrderDay')->name('show');
        });
        Route::put('/call-center-captains/block/{captain}', [CallCenter\CaptainController::class, 'blockCaptain'])->name('CallCenterCaptains.block');
        // Tickets ::
        Route::resource('CallCenterTickets', CallCenter\TicketController::class);
        Route::post('CallCenterTickets/{id}/addReply', [CallCenter\TicketController::class, 'addReply'])->name('CallCenterTickets.addReply');
        Route::post('/update-ticket-status/{ticketId}', [CallCenter\TicketController::class, 'updateTicketStatus'])->name('update-ticket-status');
    
        // Car Model ::
        Route::get('/get-car-models/{carMakeId}', [CallCenter\CaptainController::class, 'getCarModelsByMakeId']);
        Route::post('createNewCar', [CallCenter\CaptainController::class, 'createNewCar'])->name('createNewCar');
        Route::get('{captain}/new-car', [CallCenter\CaptainController::class, 'newCar'])->name('CallCenterCaptains.captainNewCar');
        Route::get('captains/{id}/my-car', [CallCenter\CaptainController::class, 'myCar'])->name('CallCenterCaptains.myCar');
        Route::post('captains/{id}/update-my-car', [CallCenter\CaptainController::class, 'updateMyCar'])->name('CallCenterCaptains.updateMyCar');

        Route::get('/get-scooter-models/{carMakeId}', [CallCenter\CaptainController::class, 'getScooterModelsByMakeId']);
        Route::post('createNewScooter', [CallCenter\CaptainController::class, 'createNewScooter'])->name('createNewScooter');
        Route::get('{captain}/new-scooter', [CallCenter\CaptainController::class, 'newScooter'])->name('CallCenterCaptains.captainNewScooter');
        Route::get('captains/{id}/my-scooter', [CallCenter\CaptainController::class, 'myScooter'])->name('CallCenterCaptains.myScooter');
        Route::post('captains/{id}/update-my-scooter', [CallCenter\CaptainController::class, 'updateMyScooter'])->name('CallCenterCaptains.updateMyScooter');
        // Users ::
        Route::resource('CallCenterUsers', CallCenter\UserController::class);
        Route::post('users/sendNotification/All/callCenter', [CallCenter\UserController::class, 'sendNotificationAll'])->name('users.sendNotification_callCenter');
    
        // Colors ::
        Route::resource('Colors', CallCenter\ColorController::class);
    });
});