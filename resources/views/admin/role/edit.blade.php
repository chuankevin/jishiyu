@extends('admin.layouts.layout')
@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">编辑角色</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" method="post" onsubmit="return check()">
            {{csrf_field()}}
            <div class="box-body">

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">角色名称：</label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="role_name" placeholder="" name="role_name" value="{{$data->name}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">分配权限：</label>

                    <div class="form-group">
                        <div class="checkbox col-sm-6">
                            @foreach($menus as $menu)
                                <label>
                                    <input type="checkbox" name="menu[]" value="{{$menu->id}}"
                                    @foreach($role_menu as $item)
                                        @if($item->menuId==$menu->id)
                                            checked
                                        @endif
                                    @endforeach
                                    >{{$menu->menuName}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                </label>
                            @endforeach
                        </div>

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
            if($('#role_name').val()==''){
                msg('请输入角色名称');
                return false;
            }
            //权限
            if($("input[name='menu[]']:checked").length==0) {
                msg('请选择相应权限');
                return false;
            }

        }


    </script>

@endsection