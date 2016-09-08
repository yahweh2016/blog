<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ArticleController extends CommonController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $art = Article::paginate(3);
        $cate = (new Category())->tree();
        return view('admin.article.index',['cate'=>$cate,'art'=>$art]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cate = (new Category())->tree();
//        echo "<pre>";
//        var_dump($cate);die;
        return view('admin.article.add')->with('cate',$cate);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $input = Input::except('_token');
        $input['art_time'] = time();
//        dd($input);
        $rules = [
            'art_title'=>'required',
            'art_content'=>'required',
        ];
        $message = [
            'art_title.required'=>'文章标题必须填写',
            'art_content。required'=>'文章内容必须填写',
        ];
        $validate = Validator::make($input,$rules,$message);
        if($validate->passes()) {
            $res = Article::create($input);
            if ($res) {
                return redirect('admin/article');
            }else{
                return back()->with('errors','文章添加失败，请重新添加');
            }
        }else{
         return back()->withErrors($validate);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id  show是展示详情的
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $art = Article::find($id);
        $cate_list = (new Category())->tree();
//        $data = Category::where('cate_pid',0)->get();
        return view('admin.article.edit',compact('art','cate_list'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = Input::except('_method','_token');
        $res = Category::where('cate_id',$id)->update($input);
        if($res){
            return redirect('admin/article');
        }else{
            return back()->with('errors','文章更新失败，请重新修改');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id 删除
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $art_id = Input::get('art_id');
        $res = Article::where('art_id',$art_id)->delete();
        if( $res ){
            $ajaxReturn = [
                'error' => 0,
                'msg' => '分类删除成功',
            ];
        } else{
            $ajaxReturn = [
                'error' => 1,
                'msg' => '分类删除失败',
            ];
        }

        return $ajaxReturn;
    }

}
