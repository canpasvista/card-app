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
    Route::get('openboard', 'App\Http\Controllers\Api\startController@openboard');
    Route::get('getscore', 'App\Http\Controllers\Api\scoreController@score');
    Route::get('playcard', 'App\Http\Controllers\Api\playController@play');
    Route::get('getcard', 'App\Http\Controllers\Api\playController@getCard');
    Route::get('getstate', 'App\Http\Controllers\Api\playController@getGameState');

    Route::resource('start', 'App\Http\Controllers\Api\startController');
//    Route::resource('score', 'App\Http\Controllers\Api\scoreController');
//    Route::resource('history', 'App\Http\Controllers\Api\historyController');
    Route::middleware(['cors'])->group(function () {
        Route::resource('play', 'App\Http\Controllers\Api\playController');
    });

    Route::get('deletehistory', 'App\Http\Controllers\Api\deleteHistoryController@delete');

});
Route::group([
    'prefix' => 'auth',
    'middleware' => 'auth:api'
], function () {
    Route::post('logout', 'App\Http\Controllers\AuthController@logout');
    Route::post('refresh', 'App\Http\Controllers\AuthController@refresh');
});