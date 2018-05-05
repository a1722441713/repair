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

//登陆教务处
Route::post('/haha','WeiXinUsersController@loginJwc');
//获取验证码
Route::get('/image_code','WeiXinUsersController@GetImageCode');
//获取教务处基本信息
Route::get('JWC_mess','WeiXinUsersController@GetJwcMess');
//登陆教务处手机版
Route::get('/phone','WeiXinUsersController@phone');