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

Route::group(['namespace'=>'Api','prefix'=>'v1'],function(){

    Route::group(['namespace'=>'Admin','prefix'=>'admin','middleware'=>'api.admin'],function(){

        Route::get('/members','MembersController@index');


    });


});


