<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\Request;
use Psy\Exception\RuntimeException;

class WeiXinUsersController extends Controller
{

    private $client;
    private $currentStudentNum = '';

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'http://211.70.176.123/',
            'timeout' => 3,
            RequestOptions::COOKIES => true
        ]);
    }

    public function GetWeiXinUser(){
        $user = session('wechat.oauth_user'); // 拿到授权用户资料
        dd($user);
    }

    public function loginJwc(Request $request){

        $code = $this->GetImageCode();
        $reponse = $this->client->get('/');
        $m = [];
        $res = preg_match('/<input type="hidden" name="__VIEWSTATE" value="(.*)" \/>/', (string)$reponse->getBody(), $m);
        if(!$res){
            // todo: 抛异常
        }
        $reponse = $this->client->request('POST','default2.aspx',[
            'form_params' => [
               // 'txtUserName' => $request->get('jwc_name'),
               // 'Textbox1' => $request->get('jwc_password'),
                '__VIEWSTATE' => $m[1],
                'txtUserName' => '1608210221',
                'TextBox2' => 'PENGyihai1124.',
                'txtSecretCode' => $code,
                'Button1' => ''
            ]
        ]);
        $body = mb_convert_encoding((string)$reponse->getBody(), 'UTF-8', 'gbk');

        // view-source:http://211.70.176.123/xsgrxx.aspx?xh=1608210221&xm=%C5%ED%D2%E6%BA%A3&gnmkdm=N121501
        print_r($body);
    }

    public function GetImageCode()
    {



        $savePath = storage_path('app/public/jwc_code.jpg');
        $this->client->get('http://211.70.176.123/CheckCode.aspx',[
            RequestOptions::SINK => $savePath, // 资源保存路径
            RequestOptions::HTTP_ERRORS => false, // 服务器返回500错误
        ]);


        $client = new Client([
            'base_uri' => 'http://www.mq1314.cn:5000/',
            'timeout' => 3 ,
        ]);

        $response = $client->request('POST','image_to_label',[
            'multipart' => [
                [
                    'name' => 'captcha',
                    'contents' => fopen($savePath,'r')
                ],
            ]
        ]);

        $code = json_decode($response->getBody());
        return $code->captcha_label;



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
