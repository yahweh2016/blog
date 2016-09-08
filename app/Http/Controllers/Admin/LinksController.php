<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *url admin/category  get/head
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cate = (new Category)->tree();
//        dd($cate);die;
        return view('admin.category.index')->with('data',$cate);
    }

    /**
     * Show the form for creating a new resource.
     *url admin/category/create get/head //添加分类
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Category::where('cate_pid',0)->get();
//        dd($data);die;
        return view('admin.category.add',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *url admin/category post
     * @param  \Illuminate\Http\Request  $request //添加分类
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = Input::except('_token');
//        dd($input);
        if($input){
            $rules = [
                'cate_name' => 'required',
            ];

            $messages = [
                'cate_name.required' => '分类名称不能为空'
            ];

            $validate = Validator::make($input,$rules,$messages);

            if($validate->passes()){
                $cate = Category::create($input);
                if($cate){
                    return redirect('admin/category');
                }else{
                    return back()->with('errors','分类添加失败');
                }
            }else{
                return back()->withErrors($validate);
            }
        }
    }

    /**
     * Display the specified resource.
     *url admin/category/{category} get/head
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *url admin/category/{category}/edit get/head
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cate = Category::find($id);
//        dd($cate);die;
        $data = Category::where('cate_pid',0)->get();
        return view('admin.category.edit',compact('data','cate'));
    }

    /**
     * Update the specified resource in storage.
     *url admin/category/{category} put/patch
    //     * @param  \Illuminate\Http\Request  $request
     * @param  int  cate_id
     * @return \Illuminate\Http\Response
     */
    public function update($cate_id)
    {
        //
        $input = Input::except('_method','_token');
//        dd($input);
        $res = Category::where('cate_id',$cate_id)->update($input);

        if($res){
            return redirect('admin/category');
        }else{
            return back()->with('errors','分类更新失败,请稍后重试');
        }
    }

    /**
     * Remove the specified resource from storage.
     *url admin/category/{category} delete
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $cate_id = Input::get('cate_id');
        $res = Category::where('cate_id',$cate_id)->delete();
        Category::where('cate_pid',$cate_id)->update(['cate_pid'=>0]);
        if($res){
            $ajaxReturn= [
                'error'=> 0,
                'msg'=>'分类删除成功'
            ];
        }else{
            $ajaxReturn= [
                'error'=> 1,
                'msg'=>'分类删除失败'
            ];
        }

        return $ajaxReturn;

    }


    public function changeOrder(){
        if($input=Input::all()){
            $cate = Category::find($input['cate_id']);
            $cate->cate_order = $input['cate_order'];
            $id = $cate->update();
            if($id){
                $data = ['status'=>0,'msg'=>'分类排序更新成功'];
            }else{
                $data = ['status'=>1,'msg'=>'分类排序更新失败'];
            }
            return $data;
        }
    }
}
