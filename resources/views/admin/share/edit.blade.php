@extends('admin.layouts.layout')
@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">编辑分享内容</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" method="post" onsubmit="return check()" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="box-body">
                <div class="form-group lv-1" >
                    <label for="" class="col-sm-2 control-label">分享标题：</label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="share_title" placeholder="请输入分享标题" name="share_title" value="{{$data->share_title}}">
                    </div>
                </div>
                <div class="form-group lv-1" >
                    <label for="" class="col-sm-2 control-label">分享内容：</label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="share_content" placeholder="请输入分享内容" name="share_content" value="{{$data->share_content}}">
                    </div>
                </div>
                <div class="form-group lv-2" >
                    <label for="" class="col-sm-2 control-label">分享链接：</label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="share_url" placeholder="请输入链接" name="share_url" value="{{$data->share_url}}">
                    </div>
                </div>


                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">上传分享页背景图：</label>
                    <img src="{{asset('/upload/'.$data->bg_img)}}" class="iconimg" alt="" style="width: 100px;height: 100px;">
                    <div class="upload-div" style="margin-top:-16px;margin-left:40%;">
                        <button type="button" class="btn btn-primary" id="changeImg">点击上传</button>
                    </div>
                    {{--<input type="file" id="exampleInputFile" name="image">--}}
                    <div style="display:none">
                        <input id="fileToUpload" type="file" size="20" name="fileToUpload" class="input">
                        <button id="buttonUpload">上传</button>
                    </div>
                </div>
            </div>
            <input type="hidden" name="img_path" id="file_url" value="{{$data->bg_img}}">
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">提交</button>
                <a href="javascript:history.go(-1);"><button type="button" class="btn btn-default">取消</button></a>

            </div>
            <!-- /.box-footer -->
        </form>
    </div>


    @if(isset($msg))
        <script type="text/javascript">
            $(function(){
                msg('{{$msg}}');
            });

        </script>
    @endif

    <script>
        //字段验证
        function check(){
            //分享标题
            if($('#share_title').val()==''){
                msg('请输入分享标题');
                return false;
            }
            //分享内容
            if($('#share_content').val()==''){
                msg('请输入分享内容');
                return false;
            }
            //分享链接
            if($('#share_url').val()==''){
                msg('请输入分享链接');
                return false;
            }

            //图片
            if($('.iconimg').attr('src')==''){
                msg('请上传图片');
                return false;
            }
        }


        //上传图片
        $(function() {
            $('#changeImg').click(function () {
                $('#fileToUpload').click();
            });
            $('#fileToUpload').bind('change',function () {
                ajaxFileUpload();
            });
        });
        function ajaxFileUpload(){
            //上传文件
            $.ajaxFileUpload({
                data:{
                    _token:'{{csrf_token()}}'
                },
                url:'{{url('/admin/bank/img')}}',//处理图片脚本
                secureuri :false,
                fileElementId :'fileToUpload',//file控件id
                dataType : 'json',
                success : function (data){
                    if(data.msg==1){
                        $(".iconimg").attr("src","{{asset('/upload/')}}"+data.path);
                        $('#file_url').val(data.path);
                        $('#fileToUpload').bind('change',function () {
                            ajaxFileUpload();
                        });
                        msg('上传成功');
                    }else{
                        msg('上传失败');
                    }

                }
            })
            return false;
        }

    </script>

@endsection