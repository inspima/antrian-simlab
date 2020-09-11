<?php

// Organization
Route::group(['prefix' => 'organization'], function () {
    Route::get('/', 'OrganizationController@index')->name('master.organization.index');
    Route::get('/create', 'OrganizationController@create')->name('master.organization.create');
    Route::get('/{id}/edit', 'OrganizationController@edit')->name('master.organization.edit');
    Route::put('/{id}/update', 'OrganizationController@update')->name('master.organization.update');
    Route::delete('/{id}/delete', 'OrganizationController@delete')->name('master.organization.delete');
    Route::post('/store', 'OrganizationController@store')->name('master.organization.store');
    Route::get('/datatable', 'OrganizationController@datatable')->name('master.organization.datatable');    
    Route::get('/select2', 'OrganizationController@select2')->name('master.organization.select2');
});

// Organization
Route::group(['prefix' => 'holiday'], function () {
    Route::get('/', 'HolidayController@index')->name('master.holiday.index');
    Route::get('/create', 'HolidayController@create')->name('master.holiday.create');
    Route::get('/{id}/edit', 'HolidayController@edit')->name('master.holiday.edit');
    Route::put('/{id}/update', 'HolidayController@update')->name('master.holiday.update');
    Route::delete('/{id}/delete', 'HolidayController@delete')->name('master.holiday.delete');
    Route::post('/store', 'HolidayController@store')->name('master.holiday.store');
    Route::get('/datatable', 'HolidayController@datatable')->name('master.holiday.datatable');    
    Route::get('/select2', 'HolidayController@select2')->name('master.holiday.select2');
});
