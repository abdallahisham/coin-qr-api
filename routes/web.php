<?php

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('admin')->group(function () {
    Route::get('dashboard', 'Admin\DashboardController@index');
    Route::get('transfers', 'Admin\TransfersController@index')->name('transfers');
    Route::post('transfers/{transfer}/confirm', 'Admin\TransfersController@confirm')->name('transfers.confirm');
});

Route::get('command/migrate', function () {
    Artisan::call('migrate:fresh', [
        '--seed' => true
    ]);
    return Artisan::output();
});
