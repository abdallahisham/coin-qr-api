<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

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
