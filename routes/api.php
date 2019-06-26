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

/** JWT Auth */
Route::post('auth/register', 'AuthController@register');
Route::post('auth/login', 'AuthController@login');
Route::group(['middleware' => 'jwt.auth'], function() {
    Route::get('auth/user', 'AuthController@user');
    Route::post('auth/logout', 'AuthController@logout');
    /** Todo */
    Route::get('todos','TaskController@fetchAll');
    Route::post('todos','TaskController@store');
    Route::delete('todos/{id}','TaskController@delete');
});
Route::group(['middleware' => 'jwt.refresh'], function() {
    Route::get('auth/refresh', 'AuthController@refresh');
});

