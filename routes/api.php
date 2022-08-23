<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Controller\AuthController;
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


Route::group(['prefix' => 'auth'],function(){
    Route::post("login", [App\Http\Controllers\AuthController::class, 'login']);
});

Route::group([
    'middleware' => 'auth:api'
], function () {
    Route::middleware(['cors'])->group(function () {
        Route::get('openboard', 'App\Http\Controllers\Api\startController@openboard');
        Route::get('getscore',  'App\Http\Controllers\Api\scoreController@score');
        Route::get('play',      'App\Http\Controllers\Api\playController@index');
        Route::post('play',     'App\Http\Controllers\Api\playController@store');
        Route::get('playcard',  'App\Http\Controllers\Api\playController@playCard');
        Route::get('getcard',   'App\Http\Controllers\Api\playController@getCard');
        Route::get('getstate',  'App\Http\Controllers\Api\playController@getGameState');

        Route::get('deletehistory', 'App\Http\Controllers\Api\deleteHistoryController@delete');
    });
});
// Route::group([
//     'prefix' => 'auth',
//     'middleware' => 'auth:api'
// ], function () {
//     Route::post('logout', 'App\Http\Controllers\AuthController@logout');
//     Route::post('refresh', 'App\Http\Controllers\AuthController@refresh');
// });
