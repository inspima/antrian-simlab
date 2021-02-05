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
    }
);

    Route::group(
        [
            'namespace' => 'Api',
            'prefix' => 'registrasi'
        ],
        function () {
            Route::post('verify-code', 'ApiRegistrasiController@verifyCode');
            Route::post('update-status', 'ApiRegistrasiController@updateStatus');
        }
    );

