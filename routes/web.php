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
    Route::get('/percentage', 'DashboardController@percentage')->name('dashboard.percentage');
    Route::get('/grafik', 'DashboardController@grafik')->name('dashboard.grafik');
});

// Attendance
Route::group(['prefix' => 'attendance'], function () {
    Route::get('/', 'AttendanceController@index')->name('attendance.index');
    Route::post('/check', 'AttendanceController@check')->name('attendance.check');
    Route::get('/code', 'AttendanceController@getCode')->name('attendance.code');
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

