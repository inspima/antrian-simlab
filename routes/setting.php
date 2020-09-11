<?php

Route::group(['prefix' => 'quota'], function () {
    Route::get('/', 'QuotaController@index')->name('setting.quota.index');
    Route::get('/create', 'QuotaController@create')->name('setting.quota.create');
    Route::get('/{id}/edit', 'QuotaController@edit')->name('setting.quota.edit');
    Route::post('/store', 'QuotaController@store')->name('setting.quota.store');
    Route::put('/{id}/update', 'QuotaController@update')->name('setting.quota.update');
    Route::delete('/{id}/delete', 'QuotaController@delete')->name('setting.quota.delete');
    Route::get('/datatable', 'QuotaController@datatable')->name('setting.quota.datatable');
});
