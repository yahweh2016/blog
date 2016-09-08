<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CommonController extends Controller
{


    public function upload(){
        $input = Input::file('Filedata');
        if($input->isValid()){
            $ext = $input->getClientOriginalExtension();
            $sub_path = date('YmdH').'/';
            if(!is_dir(base_path().'/uploads/'.$sub_path)){
                mkdir(base_path().'/uploads/'.$sub_path);
            }

            //获取名字
            $prefix = 'article_';
            $basename = uniqid($prefix,true).'.'.$ext;
            $input->move(base_path().'/uploads/'.$sub_path,$basename);
            return $sub_path.$basename;

        }
    }
}
