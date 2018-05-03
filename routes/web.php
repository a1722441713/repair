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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::any('/wechat', 'WeChatController@serve');

Route::middleware('wechat.oauth')->get('/user', 'WeiXinUsersController@GetWeiXinUser')->name('index');
//Route::group(['middleware' => 'wechat.oauth'], function () {
//    Route::get('/user', function () {
//        dd(1);
//        $user = session('wechat.oauth_user'); // 拿到授权用户资料
//        dd($user);
//    })->name('index');
//});

Route::get('/haha','WeiXinUsersController@loginJwc');

Route::get('/image_code','WeiXinUsersController@GetImageCode');
Route::get('/phone','WeiXinUsersController@phone');