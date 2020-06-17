<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('user/login', 'UserController@login');
Route::post('user/register', 'UserController@register');
Route::get('dictionaries', 'DictionariesController@view');


Route::group(['middleware' => 'auth:api'], function() {
    Route::post('user/update', 'UserController@update');
    Route::post('ads/store', 'AdsController@store');
});