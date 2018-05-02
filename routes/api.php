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
    $api->post('question','QuestionController@question')->name('api.user.question');
    $api->post('answer/{id}','QuestionController@answer')->name('api.administrator.answer');
    $api->get('user/show/{id}','UserController@show')->name('api.user.show');
});

