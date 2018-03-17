<?php

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

Auth::routes();


Route::get('/', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function() {
    Route::get('/', function() {
        return redirect()->to('/voting');
    })->name('home');

    Route::group(['prefix' => 'badges'], function() {
        Route::get('/', 'BadgeController@index');
    });

    Route::group(['prefix' => 'voting'], function() {
        Route::get('/', 'VotingController@getIndex');
        Route::post('/enable', 'VotingController@postEnable');
        Route::post('/disable', 'VotingController@postDisable');
    });

});
