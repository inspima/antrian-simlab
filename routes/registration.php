<?php

Route::group(['prefix' => 'sample'], function () {
    Route::get('', 'RegistrationSampleController@index')->name('registration.sample.index'); 
    Route::get('/create', 'RegistrationSampleController@create')->name('registration.sample.create');
    Route::get('/{id}/edit', 'RegistrationSampleController@edit')->name('registration.sample.edit');
    Route::get('/{id}/print', 'RegistrationSampleController@print')->name('registration.sample.print');
    Route::get('/{id}/detail', 'RegistrationSampleController@detail')->name('registration.sample.detail');
    Route::post('/{id}/send', 'RegistrationSampleController@send')->name('registration.sample.send');
    Route::put('/{id}/update', 'RegistrationSampleController@update')->name('registration.sample.update');
    Route::delete('/{id}/delete', 'RegistrationSampleController@delete')->name('registration.sample.delete');
    Route::post('/store', 'RegistrationSampleController@store')->name('registration.sample.store');
    Route::get('/datatable', 'RegistrationSampleController@datatable')->name('registration.sample.datatable');
    Route::get('select2', 'RegistrationSampleController@select2')->name('registration.sample.select2');
});

