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
Route::post('posts/find', 'AdsController@find');

Route::group(['middleware' => 'auth:api'], function() {
    Route::post('user/update', 'UserController@update');
    Route::get('user/me', 'UserController@me');

    Route::post('posts/store', 'AdsController@store');
    Route::get('posts/me', 'AdsController@me');
    Route::post('posts/publish', 'AdsController@publish');
    Route::post('posts/update', 'AdsController@update');

    Route::post('vk/save', 'VkController@vkSave');
    Route::get('vk/groups', 'VkController@vkGroups');
    Route::post('vk/groups/store', 'VkController@vkStore');
});