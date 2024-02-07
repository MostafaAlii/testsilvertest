<?php

use App\Http\Controllers\Dashboard\Admin;
use App\Http\Controllers\Dashboard\Admin\Order;
use App\Http\Controllers\Dashboard\General;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ], function () {

    Route::group(['prefix'=>auth('admin')->check() ? 'admin' : 'callCenter','middleware'=>'auth:admin,call-center'],function (){
        // Call-Center ::
        Route::resource('callCenters', Admin\CallCenterController::class);
        Route::post('callCenters/{callCenterId}/update-password', [Admin\CallCenterController::class, 'updatePassword'])->name('callCenters.update-password');
        Route::post('callCenters/update-status/{id}', [Admin\CallCenterController::class, 'updateStatus'])->name('callCenters.updateStatus');
        Route::post('callCenters/{callCenterId}/update-status', [Admin\CallCenterController::class, 'updateStatus'])->name('callCenters.update-status');
        Route::post('callCenters/{callCenterId}/update-type', [Admin\CallCenterController::class, 'updateType'])->name('callCenters.update-type');
        Route::get('activity', [Admin\CallCenterActivityController::class, 'getActivity'])->name('callCenters.activity');
        Route::resource('captains', Admin\CaptainController::class);

    });

    Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function () {
        Route::get('dashboard', [Admin\DashboardController::class, 'index'])->name('admin.dashboard');
        // Admins ::
        Route::resource('admins', Admin\AdminController::class);
        Route::post('admins/{adminId}/update-password', [Admin\AdminController::class, 'updatePassword'])->name('admins.update-password');


        // Attendances ::
        Route::resource('attendances', Admin\AttendaceController::class);

        // users ::
        Route::resource('users', Admin\UserController::class);
        Route::get('users/Orders/get', [Admin\UserController::class, 'getOrders'])->name('users.getOrders');
        Route::post('users/{adminId}/update-password', [Admin\UserController::class, 'updatePassword'])->name('users.update-password');
        Route::post('users/sendNotification/all', [Admin\UserController::class, 'sendNotificationAll'])->name('users.sendNotificationAll');
        Route::post('users/sendNotification', [Admin\UserController::class, 'sendNotification'])->name('users.sendNotification');
        // Agents ::
        Route::resource('agents', Admin\AgentController::class);
        Route::post('agents/{agentId}/update-password', [Admin\AgentController::class, 'updatePassword'])->name('agents.update-password');
        // Companies ::
        Route::resource('companies', Admin\CompanyController::class);
        Route::post('companies/{companyId}/update-password', [Admin\CompanyController::class, 'updatePassword'])->name('companies.update-password');
        // Employees ::
        Route::resource('employees', Admin\EmployeeController::class);
        Route::post('employees/{employeeId}/update-password', [Admin\EmployeeController::class, 'updatePassword'])->name('employees.update-password');
        // Captains ::
        Route::get('captains/Orders/get', [Admin\CaptainController::class, 'getOrders'])->name('captains.getOrders');
        Route::post('captains/{captainId}/update-password', [Admin\CaptainController::class, 'updatePassword'])->name('captains.update-password');
        Route::put('/captains/{id}/updateStatus', [Admin\CaptainController::class, 'updateActivityStatus'])->name('captain.updateActivityStatus');
        Route::get('captains/{captainId}/notifications', [Admin\CaptainController::class, 'notifications'])->name('captains.notifications');
        Route::post('captains/{captainId}/sendNotifications', [Admin\CaptainController::class, 'sendNotifications'])->name('captains.sendNotifications');
        Route::get('captains/{captainId}/getCaptainActivity', [Admin\CaptainController::class, 'getCaptainActivity'])->name('captains.activity');
        Route::post('/captains/upload-media', [Admin\CaptainController::class, 'uploadPersonalMedia'])->name('captains.uploadMedia');
        Route::post('/captains/update-media-status/{id}', [Admin\CaptainController::class, 'updatePersonalMediaStatus'])->name('captains.updateMediaStatus');
        Route::post('captains/update-status/{id}', [Admin\CaptainController::class, 'updateStatus'])->name('captains.updateStatus');
        Route::post('captains/update-car-status/{id}', [Admin\CaptainController::class, 'updateCarStatus'])->name('captains.updateCarStatus');
        Route::post('captains/sendNotification', [Admin\CaptainController::class, 'sendNotification'])->name('captains.sendNotification');

        Route::post('/captains/upload-scooter-media', [Admin\CaptainController::class, 'uploadScooterMedia'])->name('captains.uploadScooterMedia');

        // Trashed ::
        Route::get('trashed/captains', [Admin\CaptainController::class, 'captain_trashed'])->name('captains.trashed');
        Route::put('/captains/{id}/restore', [Admin\CaptainController::class, 'restore'])->name('captains.restore');

        // Captains Bounes::
        Route::resource('captain-bouns', Admin\Captains\BounesController::class);

        // Country ::
        Route::resource('countries', General\CountryController::class);
        Route::post('countries/{countryId}/change-status', [General\CountryController::class, 'changeStatusCountry'])->name('country.changeStatusCountry');
        // State ::
        Route::resource('states', General\StateController::class);
        Route::post('states/{stateId}/change-status', [General\StateController::class, 'changeStatusState'])->name('state.changeStatusState');
        // Cities ::
        Route::resource('cities', General\CityController::class);
        Route::post('cities/{cityId}/change-status', [General\CityController::class, 'changeStatusCity'])->name('city.changeStatusCity');
        // Sections ::
        Route::resource('sections', General\SectionController::class);
        Route::post('sections/{sectionId}/update-status', [General\SectionController::class, 'updateStatus'])->name('sections.update-status');
        // Sos ::
        Route::resource('sos', Admin\SosController::class);
        Route::post('sos/{sosId}/update-status', [Admin\SosController::class, 'updateStatus'])->name('sos.update-status');
        // Trips-Type ::
        Route::resource('tripType', Admin\TripTypeController::class);
        Route::post('tripType/{tripId}/update-status', [Admin\TripTypeController::class, 'updateStatus'])->name('tripType.update-status');
        // Car-Type ::
        Route::resource('carType', Admin\Cars\CarTypeController::class);
        Route::post('carType/{carTypeId}/update-status', [Admin\Cars\CarTypeController::class, 'updateStatus'])->name('carType.update-status');
        // Car-Make ::
        Route::resource('carMake', Admin\Cars\CarMakeController::class);
        Route::post('carMake/{carCategoryId}/updateStatus', [Admin\Cars\CarMakeController::class, 'updateStatus'])->name('carMake.update-status');
        // Car-Categories ::
        Route::resource('carCategories', Admin\Cars\CarCategoryController::class);
        Route::post('carCategories/{carCategoryId}/update-status', [Admin\Cars\CarCategoryController::class, 'updateStatus'])->name('carCategories.update-status');
        // Car-Model ::
        Route::resource('carModel', Admin\Cars\CarModelController::class);
        Route::post('carModel/{carCategoryId}/update-status', [Admin\Cars\CarModelController::class, 'updateStatus'])->name('carModel.update-status');
        // Main Settings ::
        Route::controller(Admin\SettingsController::class)->prefix('mainSettings')->as('mainSettings.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('update', 'update')->name('update');
        });
        // Orders ::
        Route::controller(Order\OrderController::class)->prefix('orders')->as('orders.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/waiting', 'index')->name('waiting');
            Route::get('/pending', 'index')->name('pending');
            Route::get('/cancel', 'cancel')->name('cancel');
            Route::get('/accepted', 'accepted')->name('accepted');
            Route::get('/done', 'done')->name('done');
            Route::get('/{order_code}', 'show')->name('show');
        });
        // Order Hour ::
        Route::controller(Order\OrderHourController::class)->prefix('order-hour')->as('orderHour.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{order_code}', 'show')->name('show');
        });
        // Order Day ::
        Route::controller(Order\OrderDayController::class)->prefix('order-day')->as('orderDay.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{order_code}', 'show')->name('show');
        });
        // Upcaming Order Day ::
        Route::controller(Order\UpcamingOrderDayController::class)->prefix('upcaming-order-day')->as('upcamingOrderDay.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{order_code}', 'show')->name('show');
            Route::post('{orderId}/update-date', [Order\UpcamingOrderDayController::class, 'updateDate'])->name('update-date');
            Route::post('{orderId}/update-time', [Order\UpcamingOrderDayController::class, 'updateTime'])->name('update-time');
        });
        // Upcaming Order Hour ::
        Route::controller(Order\UpcamingOrderHourController::class)->prefix('upcaming-order-hour')->as('upcamingOrderHour.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{order_code}', 'show')->name('show');
            Route::post('{orderId}/update-date', [Order\UpcamingOrderHourController::class, 'updateHour'])->name('update-hour');
        });
        // Discount ::
        Route::resource('discounts', General\DiscountController::class);
        Route::post('discounts/{discountId}/update-status', [General\DiscountController::class, 'updateStatus'])->name('discounts.update-status');
        // Packages ::
        Route::resource('packages', General\PackageController::class);
        Route::post('packages/{packageId}/update-status', [General\PackageController::class, 'updateStatus'])->name('packages.update-status');
        // Hours ::
        Route::resource('hours', General\HourController::class);
        // Subscriptions ::
        Route::resource('subscriptions', Admin\SubscriptionController::class);

        // Scooter-Make ::
        Route::resource('scooterMake', Admin\Scooter\ScooterMakeController::class);
        Route::post('carMake/{carCategoryId}/update-status', [Admin\Scooter\ScooterMakeController::class, 'updateStatus'])->name('scooterMake.update-status');
        // Scooter-Model ::
        Route::resource('scooterModel', Admin\Scooter\ScooterModelController::class);
        Route::post('scooterModel/{carCategoryId}/update-status', [Admin\Scooter\ScooterModelController::class, 'updateStatus'])->name('scooterModel.update-status');
        // Tricycle-Make
        Route::resource('tricycleMake', Admin\Tricycle\TricycleMakeController::class);
        Route::post('tricycleMake/{Id}/update-status', [Admin\Tricycle\TricycleMakeController::class, 'updateStatus'])->name('tricycleMake.update-status');
        // Tricycle-Model ::
        Route::resource('tricycleModel', Admin\Tricycle\TricycleModelController::class);
        Route::post('tricycleModel/{Id}/update-status', [Admin\Tricycle\TricycleModelController::class, 'updateStatus'])->name('tricycleModel.update-status');
        // Trunk-Make::
        Route::resource('trunkMake', Admin\Trunk\TrunkMakeController::class);
        Route::post('trunkMake/{Id}/update-status', [Admin\Trunk\TrunkMakeController::class, 'updateStatus'])->name('trunkMake.update-status');
        // Trunk-Model::
        Route::resource('trunkModel', Admin\Trunk\TrunkModelController::class);
        Route::post('trunkModel/{Id}/update-status', [Admin\Trunk\TrunkModelController::class, 'updateStatus'])->name('trunkModel.update-status');
        // CMS ::
        Route::resource('service', Admin\CMS\ServiceController::class);
        Route::resource('offer', Admin\CMS\OfferController::class);
    });
});