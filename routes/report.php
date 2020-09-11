<?php



Route::group(['prefix' => 'quota'], function () {
    Route::get('/', 'ReportQuotaController@index')->name('report.quota.index');
    Route::get('/{id}/detail', 'ReportQuotaController@detail')->name('report.quota.detail');
    Route::get('/datatable', 'ReportQuotaController@datatable')->name('report.quota.datatable');
});
