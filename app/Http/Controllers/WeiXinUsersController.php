<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class WeiXinUsersController extends Controller
{
    public function GetWeiXinUser(){
        $user = session('wechat.oauth_user'); // 拿到授权用户资料
        dd($user);
    }

    public function GetJwcUser(){
        $client = new Client([
            'base_uri' => 'http://211.70.176.123/',
            'timeout' =>3
        ]);
        $reponse = $client->request('POST','',[
            'form_params' => [
                'txtUserName' => 'jwc_name',
                'Textbox1' => 'jwc_password',

            ]
        ]);
    }
    public function GetImageCode()
    {
//        $client = new Client([
//            'base_uri' => 'http://www.mq1314.cn:5000/',
//            'timeout' => 3
//        ]);
//        $reponse = $client->request('POST', 'http://www.mq1314.cn:5000/image_to_label', [
//            'form_params' => [
//                'captcha' => asset('image/code1.gif')
//            ]
//        ]);
//        //dd($reponse);
//
//        $code = json_decode($reponse->getBody());
//        echo $code->captcha_label;
      //  dd(1);
        $client = new Client([
            'base_uri' => 'http://www.mq1314.cn:5000/',
            'timeout' => 3,
        ]);
        $response = $client->request('POST','image_to_label',[
            'multipart' => [
                [
                    'name' => 'captcha',
                    'contents' => fopen(asset('image/code1.gif'),'r')
//                        'contents' => fopen("http://211.70.176.123/CheckCode.aspx",'r')
                ],
            ]
        ]);
        $code = json_decode($response->getBody());
        echo  $code->captcha_label;

    }

    public function phone(){
        $client = new Client([
            'base_uri' => 'http://211.70.176.123/wap/',
            'timeout' => 3,
        ]);
        $xh = '1608210221';
        $sfzh = '342422199711242390';
        $response = $client->request('POST','index.asp',[
            'form_params' => [
                'xh' => $xh,
                'sfzh' => $sfzh
            ]
        ]);
        echo $response->getBody();
        //$code = $response->getBody();
        //echo  $code->captcha_label;
    }
}
