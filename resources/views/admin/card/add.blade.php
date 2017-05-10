@extends('admin.layouts.layout')
@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">添加信用卡</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" method="post" onsubmit="return check()" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="box-body">
                <div class="form-group lv-1" >
                    <label for="" class="col-sm-2 control-label">信用卡名称：</label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="post_title" placeholder="请输入信用卡名称" name="post_title">
                    </div>
                </div>
                <div class="form-group lv-2" >
                    <label for="" class="col-sm-2 control-label">额度范围：</label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="edufanwei" placeholder="请输入额度范围" name="edufanwei">
                    </div>
                </div>
                <div class="form-group lv-3" >
                    <label for="" class="col-sm-2 control-label">费率：</label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="feilv" placeholder="请输入费率" name="feilv">
                    </div>
                </div>
                <div class="form-group lv-4" >
                    <label for="" class="col-sm-2 control-label">期限范围：</label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="qixianfanwei" placeholder="请输入期限范围" name="qixianfanwei">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">最快放款：</label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="zuikuaifangkuan" placeholder="请输入最快放款时间" name="zuikuaifangkuan">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">申请条件：</label>

                    <div class="col-sm-6">
                        <textarea name="shenqingtiaojian" id="shenqingtiaojian" class='form-control' cols="50" rows="5" placeholder="请输入申请条件"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">申请地址：</label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="link" placeholder="请输入网址" name="link">
                    </div>
                </div>


                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">上传图片：</label>
                    <img src="" class="iconimg" alt="" style="width: 100px;height: 100px;">
                    <div class="upload-div" style="margin-top:-35px;margin-left:40%;">
                        <button type="button" class="btn btn-primary" id="changeImg">点击上传</button>
                    </div>
                    {{--<input type="file" id="exampleInputFile" name="image">--}}
                    <div style="display:none">
                        <input id="fileToUpload" type="file" size="20" name="fileToUpload" class="input">
                        <button id="buttonUpload">上传</button>
                    </div>

                </div>
            </div>
            <input type="hidden" name="img_path" id="file_url" value="">
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
            //名称
            if($('#post_title').val()==''){
                msg('请输入业务名称');
                return false;
            }
            //额度范围
            if($('#edufanwei').val()==''){
                msg('请输入额度范围');
                return false;
            }
            //费率
            if($('#feilv').val()==''){
                msg('请输入费率');
                return false;
            }
            //期限范围
            if($('#qixianfanwei').val()==''){
                msg('请输入期限范围');
                return false;
            }
            //最快放款
            if($('#zuikuaifangkuan').val()==''){
                msg('请输入最快放款时间');
                return false;
            }
            //申请条件
            if($('#shenqingtiaojian').val()==''){
                msg('请输入申请条件');
                return false;
            }
            //申请地址
            if($('#link').val()==''){
                msg('请输入申请地址');
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
                url:'{{url('/admin/business/img')}}',//处理图片脚本
                secureuri :false,
                fileElementId :'fileToUpload',//file控件id
                dataType : 'json',
                success : function (data){
                    if(data.msg==1){
                        $(".iconimg").attr("src",data.file_url);
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