<?php

namespace App\Http\Controllers;

use App\Models\User;

class WeiXinUsersController extends Controller
{


    /**
     * 获取微信信息
     * 判断数据库存在该用户
     * 1：不存在->创建并调到教务处登陆
     * 2：存在->直接进入维修登记界面
     */
    public function GetWeiXinUser(){
        $user = session('wechat.oauth_user.default'); // 拿到授权用户资料
        //判断是否存在
        if(User::where('wx_id',$user->getId())->first()) {
            $repair_user = User::where('wx_id', $user->getId())->first();
        }else{
            $repair_user = false;
        }

        if($repair_user){
            //判断是否有教务处记录
            if($repair_user->name == null) {
                // todo:教务处登记界面
                dd("教务处登记界面1");
            }else{
                // todo:维修登记界面
                dd("维修登记界面");
            }
        }
        //将获取的数据放到数组中
        $data = [
            'wx_id' => $user->getId(),
            'wx_nickname' =>$user->nickname,
            'wx_name' => $user->getName(),
            'wx_email' => $user->email,
            'wx_avatar' => $user->avatar
        ];
        if(User::create($data)){
            // todo:教务处登陆界面，传递id
        }
    }


}
