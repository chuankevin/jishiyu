<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminUser;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function anyIndex(Request $request){
        if($request->isMethod('post')){
            $username=$request->username;
            $password=$request->password;

            //验证用户是否存在
            $user=AdminUser::where('name',$username)->first();
            if(!$user){
                return view('admin.login.login')->with('error','用户不存在！');
            }
            //验证用户密码是否匹配
            if(Crypt::decrypt($user->password)==$password){
                Session::put('admin_user',$user);
                return Redirect::to('admin/index');  //登录成功
            }else{
                return view('admin.login.login')->with('error','登录失败，用户名密码不正确！');
            }



        }else{
            return view('admin.login.login');
        }
    }

    public function getLoginout(Request $request){

        //清空session并跳转登录页
        $request->session()->pull('admin_user');

        return Redirect::to('admin/login');  //登录成功
    }
}
