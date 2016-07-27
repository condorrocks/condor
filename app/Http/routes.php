<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');

Route::group(['middleware' => 'web'], function () {

    Route::group(['prefix' => 'accounts', 'namespace' => 'Manage'], function () {

        Route::get('', [
            'as'   => 'manage.accounts.index',
            'uses' => 'AccountController@index',
        ]);

    });

});

///////////////////////
// LANGUAGE SWITCHER //
///////////////////////

Route::get('lang/{lang}', ['as' => 'lang.switch', 'middleware' => 'web', 'uses' => 'LanguageController@switchLang']);
