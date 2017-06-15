<?php

use Illuminate\Http\Request;

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

Route::post('auth/login', 'AuthController@login');

Route::post('users', 'AuthController@reg');


Route::group(['middleware' => ['auth:api']] , function () {
    Route::post('auth/logout', 'AuthController@logout');

    Route::get('channels/popular', 'ChannelController@popular');
    Route::get('channels/{channelId}/media', 'ChannelController@getMedia');
    Route::get('channels/{channelId}', 'ChannelController@getChannel');

    Route::get('media/subscribed', 'MediaController@getLatestSubscribedMedia');
    
    Route::get('users/me', 'UserController@getMe');
});
