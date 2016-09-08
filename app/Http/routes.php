<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/welcome', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::any('admin/login','Admin\LoginController@login');
    Route::get('admin/code','Admin\LoginController@code');
    //测试
//    Route::get('admin/crypt','Admin\LoginController@crypt');
});
Route::group(['middleware' => ['web','admin.login'],'prefix'=>'admin','namespace'=>'Admin'],function () {
    Route::any('index','IndexController@index');
    Route::any('info','IndexController@info');
    Route::get('quit','LoginController@quit');
    Route::any('pass','IndexController@pass');
//    Route::get('')
//    Route::get('admin/crypt','Admin\LoginController@crypt');
    Route::post('cate/changeOrder','CategoryController@changeOrder');
    Route::resource('category','CategoryController');
    Route::resource('article','ArticleController');
    Route::resource('link','LinksController');
    Route::any('upload','ArticleController@upload');
});

