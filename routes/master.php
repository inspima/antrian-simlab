<?php
// Staff
Route::group(['prefix' => 'staff'], function () {
    Route::get('/', 'StaffController@index')->name('master.staff.index');
    Route::get('/create', 'StaffController@create')->name('master.staff.create');
    Route::get('/{id}/edit', 'StaffController@edit')->name('master.staff.edit');
    Route::put('/{id}/update', 'StaffController@update')->name('master.staff.update');
    Route::delete('/{id}/delete', 'StaffController@delete')->name('master.staff.delete');
    Route::post('/store', 'StaffController@store')->name('master.staff.store');
    Route::get('/datatable', 'StaffController@datatable')->name('master.staff.datatable');
});

// Guest
Route::group(['prefix' => 'guest'], function () {
    Route::get('/', 'GuestController@index')->name('master.guest.index');
    Route::get('/create', 'GuestController@create')->name('master.guest.create');
    Route::get('/{id}/edit', 'GuestController@edit')->name('master.guest.edit');
    Route::put('/{id}/update', 'GuestController@update')->name('master.guest.update');
    Route::delete('/{id}/delete', 'GuestController@delete')->name('master.guest.delete');
    Route::post('/store', 'GuestController@store')->name('master.guest.store');
    Route::get('/datatable', 'GuestController@datatable')->name('master.guest.datatable');
});

// Guest
Route::group(['prefix' => 'shift'], function () {
    Route::get('/', 'ShiftController@index')->name('master.shift.index');
    Route::get('/create', 'ShiftController@create')->name('master.shift.create');
    Route::get('/{id}/edit', 'ShiftController@edit')->name('master.shift.edit');
    Route::put('/{id}/update', 'ShiftController@update')->name('master.shift.update');
    Route::delete('/{id}/delete', 'ShiftController@delete')->name('master.shift.delete');
    Route::post('/store', 'ShiftController@store')->name('master.shift.store');
    Route::get('/datatable', 'ShiftController@datatable')->name('master.shift.datatable');
    Route::get('select2', 'ShiftController@select2')->name('master.shift.select2');
});

// Guest
Route::group(['prefix' => 'device'], function () {
    Route::get('/', 'DeviceController@index')->name('master.device.index');
    Route::delete('/{id}/delete', 'DeviceController@delete')->name('master.device.delete');
    Route::get('/datatable', 'DeviceController@datatable')->name('master.device.datatable');
});

// Company
Route::group(['prefix' => 'company'], function () {
    Route::get('/', 'CompanyController@index')->name('master.company.index');
    Route::get('/create', 'CompanyController@create')->name('master.company.create');
    Route::get('/{id}/edit', 'CompanyController@edit')->name('master.company.edit');
    Route::put('/{id}/update', 'CompanyController@update')->name('master.company.update');
    Route::delete('/{id}/delete', 'CompanyController@delete')->name('master.company.delete');
    Route::post('/store', 'CompanyController@store')->name('master.company.store');
    Route::get('/datatable', 'CompanyController@datatable')->name('master.company.datatable');
    Route::get('select2', 'CompanyController@select2')->name('master.company.select2');
});

Route::group(['prefix' => 'work-group'], function () {
    Route::get('/', 'WorkGroupController@index')->name('master.work-group.index');
    Route::get('/create', 'WorkGroupController@create')->name('master.work-group.create');
    Route::get('/{id}/edit', 'WorkGroupController@edit')->name('master.work-group.edit');
    Route::put('/{id}/update', 'WorkGroupController@update')->name('master.work-group.update');
    Route::delete('/{id}/delete', 'WorkGroupController@delete')->name('master.work-group.delete');
    Route::post('/store', 'WorkGroupController@store')->name('master.work-group.store');
    Route::get('/datatable', 'WorkGroupController@datatable')->name('master.work-group.datatable');
    Route::get('select2', 'WorkGroupController@select2')->name('master.work-group.select2');
});

Route::group(['prefix' => 'work-place'], function () {
    Route::get('/', 'WorkPlaceController@index')->name('master.work-place.index');
    Route::get('/create', 'WorkPlaceController@create')->name('master.work-place.create');
    Route::get('/{id}/edit', 'WorkPlaceController@edit')->name('master.work-place.edit');
    Route::put('/{id}/update', 'WorkPlaceController@update')->name('master.work-place.update');
    Route::delete('/{id}/delete', 'WorkPlaceController@delete')->name('master.work-place.delete');
    Route::post('/store', 'WorkPlaceController@store')->name('master.work-place.store');
    Route::get('/datatable', 'WorkPlaceController@datatable')->name('master.work-place.datatable');
    Route::get('select2', 'WorkPlaceController@select2')->name('master.work-place.select2');
});

Route::group(['prefix' => 'event'], function () {
    Route::get('select2', 'EventController@select2')->name('master.event.select2');
});
