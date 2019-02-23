<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->post('/user', function (Request $request) {
    return $request->user();
});

Route::post('generate-card', 'CardsController@store');

Route::middleware('auth:api')->post('recharge', 'CardsController@recharge');

Route::middleware('auth:api')->post('users', 'UsersController@index');

Route::middleware('auth:api')->post('transfer', 'TransfersController@transfer');
Route::middleware('auth:api')->post('transactions', 'TransfersController@transactions');

Route::post('register', 'UsersController@register');
Route::post('login', 'UsersController@login');
Route::post('check-otp', 'UsersController@checkOtp');
