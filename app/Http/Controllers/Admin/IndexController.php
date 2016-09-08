<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;

class IndexController extends CommonController
{
    //
    public function index(){
        return view('admin.index');
    }

    public function info(){
        return view('admin.info');
    }
    public function pass(){
        if($input = Input::all()){
                $rules = [
                    'password_o' => 'required',
                    'password' => 'required|between:6,20|confirmed',
                ];
                $messages = [
                    'password_o.required' => '原密码不能为空',
                    'password.required' => '新密码不能为空',
                    'password.between' => '密码必须为8到16',
                    'password.confirmed' => '两次输入的密码必须相同',
                ];
                $validate = Validator::make($input,$rules,$messages);
                if($validate->passes()){
                    $user = User::first();
                    $_password = Crypt::decrypt($user->user_password);
                    if($_password == $input['password_o']){
                        $user->user_password = Crypt::encrypt($input['password']);
                        $user->update();
                        return back()->with('errors','密码修改成功');
                    }else{
                        return back()->with('errors','原密码错误');
                    }
                }else{
                    return back()->withErrors($validate);
                }
        }else {
            return view('admin/pass');
        }
    }
}

