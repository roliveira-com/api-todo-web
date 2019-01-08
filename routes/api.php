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

Route::post('/user', [
    'uses' => 'UserController@signup'
]);

Route::post('/signin', [
    'uses' => 'UserController@signin'
]);

Route::group([ 'middleware' => 'auth.jwt'], function () {
    Route::get('/item', [
        'uses' => 'ItemController@getItem'
    ]);

    Route::post('/item', [
        'uses' => 'ItemController@postItem',
    ]);

    Route::put('/item/{id}', [
        'uses' => 'ItemController@editItem'
    ]);
    
    Route::delete('/item/{id}', [
        'uses' => 'ItemController@deleteItem'
    ]);
});
