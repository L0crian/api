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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:api']], function () {

    /* Favorite */
    Route::post('users/{user}/favorites', 'FavoritesController@store');
    Route::delete('users/{user}/favorites', 'FavoritesController@destroy');

    /* Photo */
    Route::post('profiles/{profile}/photos', 'PhotosController@store');

});

/* Profile & User */
Route::resource('profiles', 'ProfilesController');
Route::resource('users', 'UsersController');
Route::post('login', 'UsersController@login');
Route::post('register', 'UsersController@register');

