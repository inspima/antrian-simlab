<?php

Route::group(['prefix' => 'general'], function () {
    Route::get('/', 'GeneralController@index')->name('setting.general.index');
    Route::get('/{id}/edit', 'GeneralController@edit')->name('setting.general.edit');
    Route::put('/{id}/update', 'GeneralController@update')->name('setting.general.update');
    Route::get('/datatable', 'GeneralController@datatable')->name('setting.general.datatable');
});
