<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\UsersModel;
class UserController extends Controller
{
//    注册页面
    public function reg(){
        return view("user.reg");
    }
//    注册添加
    public function regdo(Request $request){
        $data=request()->except(['_token']);
        $data['reg_time']=time();
//        dd($data['reg_time']);die;
        $request->validate([
            "user_name"=>"required|unique:users|max:10",
            "user_email"=>"required|unique:users|regex:/^\d{4}@\w{2,5}.com$/i",
            "user_password"=>"required",
            "password"=>"required|regex:/^[0-9A-Za-z]{8,16}$/",
        ],
            [
            "user_name.required"=>"用户名称必填",
            "user_name.unique"=>"用户已有",
                "user_email.unique"=>"邮箱已有,请你换个邮箱",
                "user_name.max"=>"用户名称最大10位",
                "user_email.regex"=>"邮箱格式错误",
                "user_email.required"=>"邮箱必填",
                "user_password.required"=>"确认密码必填",
                "password.required"=>"密码必填",
                "password.regex"=>"由数字和字母组成，并且要同时含有数字和字母，且长度要在8-16位之间。",
        ]);
        if($data['user_password']!=$data['password']){
            return redirect("/user/reg")->with("msg","确认密码与密码不一致");
        }
        $options = [
            'cost' => 12,
        ];
//        哈希加密
        $data['password']=password_hash($data['password'],PASSWORD_BCRYPT,$options);
//        dd($data['password']);exit;
        $res=UsersModel::insert($data);
        if($res){
            return redirect("user/login");
        }else{
            return redirect("user/reg");
        }
    }
//    登录
    public function login(){
        return view("user.login");
    }
//    登录验证
    public function logindo(Request $request){
        $user_name=request()->user_name;
        $password=request()->password;

//        dd($password);
        $data=UsersModel::where('user_name',$user_name)->first();
        $res=password_verify($password,$data['password']);
        if(!$res){
            return redirect("/user/login")->with("msg","用户名或密码错误");
        }
        if($data){
            return redirect("user/center");
        }else{
            return redirect("/user/login")->with("msg","用户名或密码错误");
        }
    }
}
