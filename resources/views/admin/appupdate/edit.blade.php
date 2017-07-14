@extends('admin.layouts.layout')
@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">安卓APP更新</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" method="post" onsubmit="return check()" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="box-body">
                <div class="form-group lv-1" >
                    <label for="" class="col-sm-2 control-label">本地版本号：</label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="version" placeholder="请输入分享标题" name="version" value="{{$data->version}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">更新类型：</label>

                    <div class="form-group col-sm-6">
                        <div class="radio">
                            <label>
                                <input type="radio" name="type" value="1" @if($data->type==1) checked @endif>强制更新
                            </label>
                            <label>
                                <input type="radio" name="type" value="2" @if($data->type==2) checked @endif>建议更新
                            </label>
                        </div>

                    </div>
                </div>
                <div class="form-group lv-2" >
                    <label for="" class="col-sm-2 control-label">更新链接：</label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="update_url" placeholder="请输入链接" name="update_url" value="{{$data->update_url}}">
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
            //版本号
            if($('#version').val()==''){
                msg('请输入版本号');
                return false;
            }

            //更新链接
            if($('#update_url').val()==''){
                msg('请输入更新链接');
                return false;
            }
        }

    </script>

@endsection