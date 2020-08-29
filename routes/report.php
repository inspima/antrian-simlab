<?php

Route::group(['prefix' => 'yearly'], function () {
    Route::get('', 'YearlyController@index')->name('report.yearly.index');
    Route::get('data', 'YearlyController@data')->name('report.yearly.data');
    Route::get('header', 'YearlyController@header')->name('report.yearly.header');
    Route::get('excel', 'YearlyController@excel')->name('report.yearly.excel');
});

Route::group(['prefix' => 'daily'], function () {
    Route::get('/', 'DailyController@index')->name('report.daily.index');
    Route::get('/datatable', 'DailyController@datatable')->name('report.daily.datatable');
    Route::get('/excel', 'DailyController@excel')->name('report.daily.excel');
});


Route::group(['prefix' => 'date-range'], function () {
    Route::get('/', 'DateRangeController@index')->name('report.date-range.index');
    Route::get('/datatable', 'DateRangeController@datatable')->name('report.date-range.datatable');
    Route::get('/excel', 'DateRangeController@excel')->name('report.date-range.excel');
});
