<?php

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


    // Auth
    Auth::routes();
    Route::post('login', [\App\Http\Controllers\Auth\LoginController::class, 'authenticate']);

    // Default Route
    Route::get('/', 'DashboardController@index');
    Route::get('/validation-result/{key}', 'FrontendController@validationResult')->name('validation-result');
    Route::any('/forget-password', 'AccountController@forgetPassword')->name('forget-password');
    // Dashboard
    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/datatable/monitoring-quota', 'DashboardController@datatableMonitoringQuota')->name('dashboard.datatable-monitoring-quota');
        Route::get('/grafik', 'DashboardController@grafik')->name('dashboard.grafik');
    });

    // Notification
    Route::group(
        [
            'prefix' => 'notification',
        ],
        function () {
            Route::post('/send', 'NotificationController@send');
        }
    );

    // Account
    Route::group(['prefix' => 'account', 'middleware' => 'auth'], function () {
        Route::get('/profile', 'AccountController@profile')->name('account.profile');
        Route::post('/profile/update', 'AccountController@updateProfile')->name('account.profile-update');
        Route::post('/profile/update-password', 'AccountController@updatePassword')->name('account.profile-update-password');
    });


    // Route Registration
    Route::group(
        [
            'prefix' => 'registration',
            'namespace' => 'Registration',
            'middleware' => 'auth'
        ],
        function () {
            require base_path('routes/registration.php');
        }
    );


    // Route Master
    Route::group(
        [
            'prefix' => 'master',
            'namespace' => 'Master',
            'middleware' => 'auth'
        ],
        function () {
            require base_path('routes/master.php');
        }
    );

    // Route Setting
    Route::group(
        [
            'prefix' => 'setting',
            'namespace' => 'Setting',
            'middleware' => 'auth'
        ],
        function () {
            require base_path('routes/setting.php');
        }
    );

    // Route Report
    Route::group(
        [
            'prefix' => 'report',
            'namespace' => 'Report',
            'middleware' => 'auth'
        ],
        function () {
            require base_path('routes/report.php');
        }
    );

