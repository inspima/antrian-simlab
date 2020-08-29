<?php

use Illuminate\Http\Request;

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

Route::get('ping', function () {
    return ['status' => 'oke'];
});

Route::group(
    [
        'namespace' => 'Api',
        'prefix' => 'auth'
    ],
    function () {
        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::post('me', 'AuthController@me');
        Route::post('change_password', 'AuthController@changePassword');
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
    }
);

Route::group(
    [
        'namespace' => 'Api',
        'prefix' => 'attendance'
    ],
    function () {
        Route::any('sync/{user_id}', 'AttendanceMobileController@sync');
        Route::post('scan_qr', 'AttendanceMobileController@scanQr');
        Route::post('upload_picture', 'AttendanceMobileController@uploadPicture');
    }
);
