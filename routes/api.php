<?php

use Illuminate\Http\Request;

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

$api = app('Dingo\Api\Routing\Router');

$api->version('v1',[
    'namespace' => 'App\Http\Controllers\Api'
], function ($api){
    //学生填写维修信息
    $api->post('question','QuestionController@question')->name('api.user.question');
    //维修员维修记录
    $api->post('answer/{id}','QuestionController@answer')->name('api.administrator.answer');
    //显示维修信息
    $api->get('user/show/{id}','UserController@show')->name('api.user.show');
    //登陆教务处
    $api->post('/loginJwc','LoginJwcController@loginJwc')->name('api.user.loginjwc');


    //获取验证码
    //$api->get('/image_code','WeiXinUsersController@GetImageCode')
    //获取教务处基本信息
    //$api->get('/JWC_mess','WeiXinUsersController@GetJwcMess');


    //登陆教务处手机版
    //$api->get('/phone','WeiXinUsersController@phone');
});

