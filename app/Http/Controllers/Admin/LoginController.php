<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;

//use App\Http\Controllers\Controller;
require_once 'resources/org/code/Code.class.php';
class LoginController extends CommonController
{
    //登陆
    public function login(){
        if($input = Input::all()){
            $code = new \Code;
            $_code = $code->get();
            if(strtoupper($input['code'])!=$_code){
                return back()->with('message','验证码错误');
            }
            $user = User::first();
            if($user->user_name != $input['user_name'] || Crypt::decrypt($user->user_password) != $input['user_password']) {
                return back()->with('message','用户名错误或者密码错误');
            }else {
                session(['user' => $user]);
                return redirect('admin/index');
            }
        }else {
//            dd($_SERVER);
            return view('admin.login');
        }
    }

    public function quit(){
        session(['user'=>null]);
        return redirect('admin/login');
    }

    //验证码
    public function code(){
        $code = new \Code;
        $code->make();
    }
}
