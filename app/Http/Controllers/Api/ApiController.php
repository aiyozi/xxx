<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use App\Model\UsersModel;
use App\Model\Token;
class ApiController extends Controller
{
    //    注册添加
    public function reg(Request $request){
        $data=request()->input();
        $data['reg_time']=time();
//        dd($data['reg_time']);die;
//      判断用户没是否为空
        if(empty($data['user_name'])){
            $reston=[
              "error"=>5002,
                "msg"=>"用户名称不能为空"
            ];
            return $reston;
        }


        //      判断邮箱是否为空
        if(empty($data['user_email'])){
            $reston=[
                "error"=>5003,
                "msg"=>"邮箱不能为空"
            ];
            return $reston;
        }


        //      判断密码是否为空
        if(empty($data['password'])){
            $reston=[
                "error"=>5004,
                "msg"=>"密码不能为空"
            ];
            return $reston;
        }


        //      判断邮箱是否为空
        if(empty($data['user_password'])){
            $reston=[
                "error"=>5005,
                "msg"=>"确认密码不能为空"
            ];
            return $reston;
        }


//        邮箱验证格式
        $email="/^\w+@[0-9a-z]{2,}\.com$/";
        if(!preg_match($email,$data['user_email'])){
            $reston=[
                "error"=>5006,
                "msg"=>"邮箱格式错误"
            ];
            return $reston;
        }


        //验证密码格式
        $pass="/^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9]{6,20})$/";
        if(!preg_match($pass,$data['password'])){
            $reston=[
                "error"=>5008,
                "msg"=>"密码必须是6到20位字符必须包含字母和数字"
            ];
            return $reston;
        }

        if($data['user_password']!=$data['password']){
            $reston=[
                "error"=>5009,
                "msg"=>"确认密码与密码不一致"
            ];
            return $reston;
        }

        // 用户唯一性
        $name=UsersModel::where("user_name",$data['user_name'])->first();
        if($name){
            $reston=[
                "error"=>5010,
                "msg"=>"用户已有"
            ];
            return $reston;
        }

//        邮箱唯一性
        $email=UsersModel::where("user_email",$data['user_email'])->first();
        if($email){
            $reston=[
                "error"=>5011,
                "msg"=>"邮箱已有"
            ];
            return $reston;
        }



        $options = [
            'cost' => 12,
        ];
//        哈希加密
        $data['password']=password_hash($data['password'],PASSWORD_BCRYPT,$options);
//        dd($data['password']);exit;
        $res1=UsersModel::insert($data);
        if($res1){
            $reston=[
                "error"=>0,
                "msg"=>"注册成功"
            ];
        }else{
            $reston=[
                "error"=>300,
                "msg"=>"注册失败"
            ];
        }
        return $reston;
    }

    //    登录验证
    public function logindo(Request $request){
        $user_name=request()->user_name;
        $password=request()->password;
//        dd($password);
        $data=UsersModel::where('user_name',$user_name)->first();
        $res=password_verify($password,$data['password']);
        if(!$res){
           $resmon=[
             'error'=>2000,
               "msg"=>"用户名或密码错误"
           ];
        }
        if($data){
//            生成TOKEN
            $store=$data['user_name'].$data['user_id'].time();
            $store=substr(md5($store),5,16);
            //讲TOKEN入库
            $data=[
                'user_id'=>$data['user_id'],
                'token'=>$store
            ];
            Token::insert($data);
            $resmon=[
                'error'=>0,
                "msg"=>"登录成功"
            ];
        }else{
            $resmon=[
                'error'=>2000,
                "msg"=>"用户名或密码错误"
            ];
        }
        return  $resmon;
    }

    //    个人中心
    public  function center(){
        $token=$_GET['token'];
        $token=Token::where("token",$token)->first();
        if($token){
            $resmon=[
                'error'=>0,
                "msg"=>$token['user_id']."欢迎登录",
            ];
        }else{
            $resmon=[
                'error'=>2000,
                "msg"=>"登录有误"
            ];
        }
        return $resmon;
    }
}
