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

Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);

Route::get('/login', ['as' => 'login', 'uses' => 'AuthController@renderLogin']);
Route::get('/register', ['as' => 'register', 'uses' => 'AuthController@renderRegister']);
Route::get('/logout', ['as' => 'logout', 'uses' => 'AuthController@logout']);
Route::get('/auth/api/{action?}', ['as' => 'auth_api', 'uses' => 'AuthController@api']);

Route::get('/account/{id}', ['as' => 'account', 'uses' => 'AccountController@renderAccount']);
Route::get('/account/api/{action?}', ['as' => 'account', 'uses' => 'AccountController@api']);

Route::get('/forum', ['as' => 'forum', 'uses' => 'ForumController@renderHome']);
Route::get('/forum/{forum_id?}', ['as' => 'forum', 'uses' => 'ForumController@renderForum']);
Route::any('/forum/api/{action?}', ['as' => 'auth_api', 'uses' => 'ForumController@api']);

Route::get('/_debugbar/assets/stylesheets', [
    'as' => 'debugbar-css',
    'uses' => '\Barryvdh\Debugbar\Controllers\AssetController@css'
]);

Route::get('/_debugbar/assets/javascript', [
    'as' => 'debugbar-js',
    'uses' => '\Barryvdh\Debugbar\Controllers\AssetController@js'
]);