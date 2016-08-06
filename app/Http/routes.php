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

//////////////////
// Welcome Home //
//////////////////

Route::get('/', ['as' => 'landing', function () {

    $locale = app()->getLocale();

    $filepath = 'static'.DIRECTORY_SEPARATOR.$locale.DIRECTORY_SEPARATOR.'welcome.md';

    $markdown = Storage::exists($filepath) ? Storage::get($filepath) : '';

    return view('welcome', compact('markdown'));
}]);

//////////
// Auth //
//////////

Route::auth();

////////////////
// Authorized //
////////////////

Route::group(['middleware' => ['auth']], function () {

    Route::get('/dashboard', [
        'as'   => 'dashboard',
        'uses' => 'DashboardController@index',
        ]);

    Route::group(['prefix' => 'accounts', 'namespace' => 'Manage'], function () {

        Route::get('', [
            'as'   => 'manage.accounts.index',
            'uses' => 'AccountController@index',
        ]);
        Route::get('create', [
            'as'   => 'manage.accounts.create',
            'uses' => 'AccountController@create',
        ]);
        Route::post('', [
            'as'   => 'manage.accounts.store',
            'uses' => 'AccountController@store',
        ]);
        Route::get('{account}/edit', [
            'as'   => 'manage.accounts.edit',
            'uses' => 'AccountController@edit',
        ]);
        Route::put('{account}', [
            'as'   => 'manage.accounts.update',
            'uses' => 'AccountController@update',
        ]);
        Route::delete('{account}', [
            'as'   => 'manage.accounts.destroy',
            'uses' => 'AccountController@destroy',
        ]);
        Route::post('{account}', [
            'as'   => 'manage.accounts.allow',
            'uses' => 'AccountController@allow',
        ]);
    });

    Route::group(['prefix' => 'boards', 'namespace' => 'Manage'], function () {

        Route::get('', [
            'as'   => 'manage.boards.index',
            'uses' => 'BoardController@index',
        ]);
        Route::get('create', [
            'as'   => 'manage.boards.create',
            'uses' => 'BoardController@create',
        ]);
        Route::post('', [
            'as'   => 'manage.boards.store',
            'uses' => 'BoardController@store',
        ]);
        Route::get('{board}', [
            'as'   => 'manage.boards.show',
            'uses' => 'BoardController@show',
        ]);
        Route::get('{board}/edit', [
            'as'   => 'manage.boards.edit',
            'uses' => 'BoardController@edit',
        ]);
        Route::put('{board}', [
            'as'   => 'manage.boards.update',
            'uses' => 'BoardController@update',
        ]);
        Route::delete('{board}', [
            'as'   => 'manage.boards.destroy',
            'uses' => 'BoardController@destroy',
        ]);
        Route::get('{board}/purge', [
            'as'   => 'manage.boards.purge',
            'uses' => 'SnapshotController@purge',
        ]);
    });

    Route::group(['prefix' => 'feeds', 'namespace' => 'Manage'], function () {

        Route::get('create/board/{board}', [
            'as'   => 'manage.feeds.create',
            'uses' => 'FeedController@create',
        ]);
        Route::post('', [
            'as'   => 'manage.feeds.store',
            'uses' => 'FeedController@store',
        ]);
        Route::get('{feed}/edit/board/{board}', [
            'as'   => 'manage.feeds.edit',
            'uses' => 'FeedController@edit',
        ]);
        Route::put('{feed}', [
            'as'   => 'manage.feeds.update',
            'uses' => 'FeedController@update',
        ]);
        Route::delete('{feed}/board/{board}', [
            'as'   => 'manage.feeds.destroy',
            'uses' => 'FeedController@destroy',
        ]);
    });
});

//////////////
// Language //
//////////////

Route::get('lang/{lang}', [
    'as'         => 'lang.switch',
    'uses'       => 'LanguageController@switchLang',
]);
