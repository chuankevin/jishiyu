@extends('admin.layouts.layout')
@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">编辑Banner分类</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" method="post" onsubmit="return check()">
            {{csrf_field()}}
            <div class="box-body">

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">分类名称：</label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="cat_name" placeholder="" name="cat_name" value="{{$data->cat_name}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">分类标识：</label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="cat_idname" placeholder="" name="cat_idname" value="{{$data->cat_idname}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">备注：</label>

                    <div class="col-sm-6">
                        <textarea name="cat_remark" id="cat_remark" class='form-control' cols="50" rows="5">{{$data->cat_remark}}</textarea>
                    </div>
                </div>
            </div>
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
            if($('#cat_name').val()==''){
                msg('请输入分类名称');
                return false;
            }
            if($('#cat_idname').val()==''){
                msg('请输入分类标识');
                return false;
            }
        }



    </script>

@endsection