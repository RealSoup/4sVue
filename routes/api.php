<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});




Route::group(['prefix' => 'board/{bo_cd}'], function(){

    // Route::get('', [BoardController::class, 'index'])->name('board.index');
    Route::get('', 'BoardController@index')->name('board.index')->where('bo_cd', '[a-zA-Z0-9_]+');
    Route::get('show/{bo_id}', 'BoardController@show')->name('board.show')->where('bo_cd', '[a-zA-Z0-9_]+');
    Route::get('create/{bo_papa_id?}', 'BoardController@create')->name('board.create')->where('bo_cd', '[a-zA-Z0-9_]+');
    Route::post('store', 'BoardController@store')->name('board.store')->where('bo_cd', '[a-zA-Z0-9_]+');
    Route::GET('edit/{bo_id}', 'BoardController@edit')->name('board.edit')->where('bo_cd', '[a-zA-Z0-9_]+');
    Route::PATCH('update/{bo_id}', 'BoardController@update')->name('board.update')->where('bo_cd', '[a-zA-Z0-9_]+');
    Route::delete('destroy/{bo_id}', 'BoardController@destroy')->name('board.destroy')->where('bo_cd', '[a-zA-Z0-9_]+');

    Route::GET('goodBad/{bo_id}/{type}', 'BoardController@goodBad')->name('board.goodBad')->where('bo_cd', '[a-zA-Z0-9_]+');

});

Route::post('upload', 'CommonController@upload')->name('upload');
Route::get('download/{fi_id}', 'CommonController@download')->name('download');
Route::get('deleteFiles/{fi_id?}', 'CommonController@deleteFiles')->name('deleteFiles');
