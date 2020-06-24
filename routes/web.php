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

Route::get('/', function () {
    return view('welcome');
});
#wwwww
//测试
Route::get("info","Test\TestController@info");
//商品
Route::get("detail","Goods\GoodsController@detail");
//前台注册
Route::get("user/reg","User\UserController@reg");
Route::post("user/regdo","User\UserController@regdo");
//登录
Route::get("user/login","User\UserController@login");
Route::post("user/logindo","User\UserController@logindo");
//个人中心
Route::prefix("/user")->middleware("islogin")->group(function(){
    Route::get("center","User\UserController@center");
});
//API接口
Route::post("api/reg","Api\ApiController@reg");    //注册
Route::post("api/logindo","Api\ApiController@logindo");   //登录
Route::get("api/center","Api\ApiController@center");   //个人中心