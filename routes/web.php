<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\Front\boardController::class,'top'])->name('top');
Route::group([
    'middleware' => 'auth:api'
], function () {
    Route::get('/board',   [App\Http\Controllers\Front\boardController::class,'index'])->name('board');
    Route::get('/score',   [App\Http\Controllers\Front\boardController::class,'score'])->name('score');
    Route::get('/history', [App\Http\Controllers\Front\historyController::class,'index'])->name('history');
    Route::get('/toukei',  [App\Http\Controllers\Front\toukeiController::class,'index'])->name('toukei');
});
Route::get('/logout2', [App\Http\Controllers\Front\boardController::class, 'logout'])->name('logout');

Auth::routes();
