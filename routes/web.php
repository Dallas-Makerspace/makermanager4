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
    Route::get('/', 'UserController@getHome');

    Route::any('users/data', 'UserController@anyData');
    Route::resource('users', 'UserController');

    Route::get('/waiver', 'UserController@getWaiver');
    Route::post('/waiver', 'UserController@postWaiver');

    Route::resource('/family', 'FamilyController');

    Route::group(['prefix' => 'badges'], function() {
        Route::get('/', 'BadgeController@index');
        Route::post('/enable', 'BadgeController@postEnable');
        Route::post('/disable', 'BadgeController@postDisable');
    });


    Route::group(['prefix' => 'voting'], function() {
        Route::get('/', 'VotingController@getIndex');
        Route::post('/enable', 'VotingController@postEnable');
        Route::post('/disable', 'VotingController@postDisable');
    });

    Route::group(['prefix' => 'logistics'], function() {
        Route::get('/bin-audit', 'LogisticsController@getBinAudit');
        Route::post('/bin-audit', 'LogisticsController@postBinAudit');
    });
});

Route::group(['middleware' => ['auth', 'admin'], 'prefix' => 'admin', 'namespace' => 'Admin'], function() {

    Route::any('users/data', 'UserController@anyData');
//    Route::resource('users', 'UserController');
//    Route::get('users/{id}/badge', 'UserController@getBadge');
//    Route::post('users/{id}/badge', 'UserController@postBadge');

    Route::any('badges/data', 'BadgeController@anyData');
    Route::resource('badges', 'BadgeController');

});
