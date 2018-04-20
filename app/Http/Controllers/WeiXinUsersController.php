<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WeiXinUsersController extends Controller
{
    public function GetWeiXinUser(){
        dd(1);
        $user = session('wechat.oauth_user'); // 拿到授权用户资料
        dd($user);
    }
}
