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

Route::post('auth/reg', 'AuthController@reg');


Route::group(['middleware' => ['auth:api']] , function () {
    Route::post('auth/logout', 'AuthController@logout');

    Route::get('channels/popular', 'ChannelController@popular');
    Route::get('channels/{channelId}/media', 'ChannelController@getMedia');
    Route::get('channels/{channelId}', 'ChannelController@getChannel');
    Route::post('channels/{channelId}/like', 'ChannelController@like');
    Route::post('channels/{channelId}/dislike', 'ChannelController@dislike');
    Route::post('channels/{channelId}/comments/create', 'ChannelController@createComment');
    Route::get('channels/{channelId}/comments', 'ChannelController@getComments');

    Route::get('media/subscribed', 'MediaController@getLatestSubscribedMedia');
    Route::post('media/{mediaId}/like', 'MediaController@like');
    Route::post('media/{mediaId}/dislike', 'MediaController@dislike');
    Route::post('media/{mediaId}/comments/create', 'MediaController@createComments');
    Route::get('channels/{channelId}/comments', 'MediaController@getComments');
    
    Route::get('users/me', 'UserController@getMe');
});
