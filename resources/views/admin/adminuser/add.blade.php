@extends('admin.layouts.layout')
@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">新增管理员</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" method="post" onsubmit="return check()">
            {{csrf_field()}}
            <div class="box-body">

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">管理员用户名：</label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="name" placeholder="只能输入数字字母下划线" name="name">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">用户角色：</label>

                        <div class="checkbox col-sm-4">
                            <select class="form-control selectpicker2" id="role_id" name="role_id">
                                <option value="">请选择</option>
                                @foreach($roles as $role)
                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                @endforeach
                            </select>
                        </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">密码：</label>

                    <div class="col-sm-4">
                        <input type="password" class="form-control" id="pwd" placeholder="请输入6位数字密码" name="pwd">
                    </div>
                </div>

            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">提交</button>
                <a href="javascript:history.go(-1);"><button type="button" class="btn btn-default">取消</button></a>

            </div>
            <!-- /.box-footer -->
                </div>
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
            if($('#name').val()==''){
                msg('请输入用户名');
                return false;
            }
            var reg=/^\w+$/;
            //alert(reg.test($('#name').val()));
            if(!reg.test($('#name').val())){
                msg('用户名格式不正确');
                return false;
            }
            //角色
            if($('#role_id').val()=='') {
                msg('请选择相应角色');
                return false;
            }
            //密码
            if($('#pwd').val()=='') {
                msg('请输入6位数字密码');
                return false;
            }

            if($('#pwd').val().length!=6){
                msg('请输入6位数字密码');
                return false;
            }

        }


    </script>

@endsection