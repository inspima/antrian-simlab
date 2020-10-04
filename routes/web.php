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

// Default Route
Route::get('/', 'DashboardController@index');

// Dashboard
Route::group(['prefix' => 'dashboard'], function () {
    Route::get('/datatable/monitoring-quota', 'DashboardController@datatableMonitoringQuota')->name('dashboard.datatable-monitoring-quota');
    Route::get('/grafik', 'DashboardController@grafik')->name('dashboard.grafik');
});


// Route Master
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

// Route Master
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

// Route Master
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

