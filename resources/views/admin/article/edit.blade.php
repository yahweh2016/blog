@extends('layout/admin')
@section('contents')
        <!--面包屑导航 开始-->

<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="#">首页</a> &raquo; <a href="#">商品管理</a> &raquo; 添加商品
</div>
<!--面包屑导航 结束-->
<style>
    .edui-default{line-height: 28px;}
    /*div.edui-combox-body,div.edui-button-body,div.edui-splitbutton-body*/
    /*{overflow: hidden; height:20px;}*/
    /*div.edui-box{overflow: hidden; height:22px;}*/
</style>

<!--结果集标题与导航组件 开始-->
<div class="result_wrap">
    <div class="result_title">
        <h3>快捷操作</h3>
    </div>
    <div class="result_content">
        <div class="short_wrap">
            <a href="#"><i class="fa fa-plus"></i>新增文章</a>
            <a href="#"><i class="fa fa-recycle"></i>批量删除</a>
            <a href="#"><i class="fa fa-refresh"></i>更新排序</a>
        </div>
    </div>
</div>
<!--结果集标题与导航组件 结束-->

<div class="result_wrap">
    @if(count($errors))
        <div class="mark">
            @if(is_object($errors))
                @foreach($errors->all() as $error)
                    <p>{{$error}}</p>
                @endforeach
            @else
                <p>{{$errors}}</p>
            @endif
        </div>
    @endif
    <form action="{{url('admin/article/'.$art['art_id'])}}" method="post">
        <input type="hidden" name="_method" value="put">
        {{csrf_field()}}
        <table class="add_tab">
            <tbody>
            <tr>
                <th width="120"><i class="require">*</i>分类：</th>
                <td>
                    <select name="cate_id">
                        @foreach($cate_list as $cate)
                            <option value="{{$cate['cate_id']}}" @if($cate['cate_id'] == $art['cate_id']) selected @endif>
                                @if($cate['deep']>0)
                                    |{{str_repeat('--',$cate['deep']+1)}}{{$cate['cate_name']}}
                                @else
                                    {{$cate['cate_name']}}
                                @endif
                            </option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>标题：</th>
                <td>
                    <input type="text" class="lg" name="art_title" value="{{$art['art_title']}}">
                </td>
            </tr>
            <tr>
                <th>作者：</th>
                <td>
                    <input type="text" name="art_editor" value="{{$art['art_editor']}}">
                </td>
            </tr>
            {{--<tr>--}}
            {{--<th><i class="require">*</i>价格：</th>--}}
            {{--<td>--}}
            {{--<input type="text" class="sm" name="">元--}}
            {{--<span><i class="fa fa-exclamation-circle yellow"></i>这里是短文本长度</span>--}}
            {{--</td>--}}
            {{--</tr>--}}
            <style>
                .uploadify{display:inline-block;}
                .uploadify-button{border:none; border-radius:5px; margin-top:8px;}
                table.add_tab tr td span.uploadify-button-text{color: #FFF; margin:0;}
            </style>
            <tr>
                <th><i class="require">*</i>缩略图：</th>
                <td><input id="file_upload" name="file" type="file" multiple="true" value=""> </td>
                <script src="{{asset('resources/org/uploadfile/jquery.uploadify.min.js')}}" type="text/javascript"></script>
                <link rel="stylesheet" type="text/css" href="{{asset('resources/org/uploadfile/uploadify.css')}}">
            </tr>

            <script type="text/javascript">
                <?php $timestamp = time();?>
                  $(function() {
                    $('#file_upload').uploadify({
                        'buttonText':'图片上传',
                        'formData'     : {
                            'timestamp' : '<?php echo $timestamp;?>',
                            '_token'     : '{{csrf_token()}}'
                        },
                        'swf'      : '{{asset('resources/org/uploadfile/uploadify.swf')}}',
                        'uploader' : '{{url('admin/upload')}}',
                        'onUploadSuccess':function(file,data,response){
                            if(response){
                                $("#file_uploads").val(data);
                                $('#art_thumb').attr('src','/uploads/'+data).show();
                            }
                        }
                    });
                });
            </script>
            <tr>
                <th></th>
                <td>
                    <input type="hidden" name="art_thumb" id="file_uploads" value="{{$art['art_thumb']}}">
                    <img src="/uploads/{{$art['art_thumb']}}" name="art_thumb" style="max-height: 100px;max-width: 100px;" id="art_thumb"/>
                </td>
            </tr>
            {{--<tr>--}}
            {{--<th>复选框：</th>--}}
            {{--<td>--}}
            {{--<label for=""><input type="checkbox" name="">复选框一</label>--}}
            {{--<label for=""><input type="checkbox" name="">复选框二</label>--}}
            {{--</td>--}}
            {{--</tr>--}}
            <tr>
                <th>关键词：</th>
                <td>
                    <input type="text" name="art_tag" value="{{$art['art_tag']}}">
                </td>
            </tr>
            <tr>
                <th>描述：</th>
                <td>
                    <textarea name="art_description">{{$art['art_description']}}</textarea>
                </td>
            </tr>
            <script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor-utf8/ueditor.config.js')}}"></script>
            <script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor-utf8/ueditor.all.min.js')}}"> </script>
            <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
            <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
            <script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor-utf8/lang/zh-cn/zh-cn.js')}}"></script>
            <tr>
                <th>详细内容：</th>
                <td>
                    <script id="editor" type="text/plain" style="width:1024px;height:500px;" name="art_content" value="">{!!$art['art_content']!!}</script>
                    <script>
                        var ue = UE.getEditor('editor');
                    </script>
                </td>
            </tr>
            <tr>
                <th></th>
                <td>
                    <input type="submit" value="提交">
                    <input type="button" class="back" onclick="history.go(-1)" value="返回">
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>

@endsection