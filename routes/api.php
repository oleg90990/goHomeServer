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
Route::post('dictionaries/city', 'DictionariesController@city');
Route::post('ads/find', 'AdsController@find');

Route::group(['middleware' => 'auth:api'], function() {
    Route::post('user/update', 'UserController@update');
    Route::get('user/me', 'UserController@me');

    Route::post('ads/store', 'AdsController@store');
    Route::get('ads/me', 'AdsController@me');
    Route::post('ads/publish', 'AdsController@publish');
    Route::post('ads/update', 'AdsController@update');

    Route::post('vk/save', 'VkController@vkSave');
    Route::get('vk/groups', 'VkController@vkGroups');
    Route::post('vk/groups/store', 'VkController@vkStore');
});