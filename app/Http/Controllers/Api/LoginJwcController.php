<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\Request;

class LoginJwcController extends Controller
{

    private $client;
    private $xm;
    private $jwc_mess;
    private $user;

    //构造方法
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'http://211.70.176.123/',
            'timeout' => 5,
            RequestOptions::COOKIES => true
        ]);
    }


    //登陆教务系统
    public function loginJwc(Request $request){
        $this->jwc_mess['student_number'] = e($request->get('student_number'));
        $this->jwc_mess['jwc_password'] = e($request->get('jwc_password'));
        $this->user = User::find(e($request->get('id')));
        $code = $this->GetImageCode();
        $reponse = $this->client->get('/');
        $m = [];
        $res = preg_match('/<input type="hidden" name="__VIEWSTATE" value="(.*)" \/>/', (string)$reponse->getBody(), $m);
        if(!$res){
            // todo: 抛异常
        }
        $reponse = $this->client->request('POST','default2.aspx',[
            'form_params' => [
                '__VIEWSTATE' => $m[1],
                'txtUserName' => $this->jwc_mess['student_number'],
                'TextBox2' => $this->jwc_mess['jwc_password'],
                'txtSecretCode' => $code,
                'Button1' => ''
            ]
        ]);

        $body = mb_convert_encoding((string)$reponse->getBody(), 'UTF-8', 'gbk');

        if(preg_match('/<span id="Label3">欢迎您：<\/span>/', $body)){
            if(preg_match('/<span id="xhxm">(.+)同学<\/span><\/em>/',$body,$jwc)){
                $this->jwc_mess['name'] = $jwc[1];
                $this->xm = urlencode(mb_convert_encoding($jwc[1],'gb2312','UTF-8'));
            }
        }else{
            if(preg_match('/验证码不正确/',$body)){
                $this->loginJwc($request);
            }
            if(preg_match('/密码不能为空/',$body)){
                dd("密码不能为空");
            }
            if(preg_match('/密码错误/',$body)){
                dd("密码错误");
            }
        }
        //dd($this->jwc_mess);
        // view-source:http://211.70.176.123/xsgrxx.aspx?xh=1608210221&xm=%C5%ED%D2%E6%BA%A3&gnmkdm=N121501
        // print_r($body);
        $this->GetJwcMess();
    }








    //验证码识别
    public function GetImageCode()
    {
        $savePath = storage_path('app/public/jwc_code.jpg');
        $this->client->get('http://211.70.176.123/CheckCode.aspx',[
            RequestOptions::SINK => $savePath, // 资源保存路径
            RequestOptions::HTTP_ERRORS => false, // 服务器返回500错误
        ]);


        $client = new Client([
            'base_uri' => 'http://www.mq1314.cn:5000/',
            'timeout' => 5 ,
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


    //获取教务处信息
    public function GetJwcMess(){
        $reponse = $this->client->get('/xsgrxx.aspx?xh='.$this->jwc_mess['student_number'].'&xm='.$this->xm.'&gnmkdm=N121501',[
            'allow_redirects'=> [
                'max'             => 50,
                'strict'          => false,
                'referer'         => true,
                'protocols'       => ['http', 'https'],
                'track_redirects' => false
            ]
        ]);

        $body = mb_convert_encoding((string)$reponse->getBody(), 'UTF-8', 'gbk');
        //匹配性别，学院，专业班级
        if(preg_match('/<TD><span id="lbl_xb">(.+)<\/span><\/TD>[\s\S]+?<TD><span id="lbl_xy">(.+)<\/span><\/TD>[\s\S]+?<TD><span id="lbl_xzb">(.+)<\/span><\/TD>/',$body,$mess)){
            $this->jwc_mess['sex'] = $mess[1];
            $this->jwc_mess['college'] = $mess[2];
            $this->jwc_mess['major_grade'] = $mess[3];
        }
        $this->createJwcUser();
    }

    //把获取得教务处信息生成到表中
    public function createJwcUser(){
        $this->user->update($this->jwc_mess);
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

    }
}
