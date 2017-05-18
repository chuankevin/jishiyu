@extends('admin.layouts.layout')
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">管理员列表</h3>
        </div>
        {{--<form class="form-inline" method="get" >
            <div class="box-body">
                <div class="form-group">
                    分类：
                    <select class="form-control selectpicker2" name="cid">
                        <option value="">请选择</option>
                        @foreach($cats as $value)
                            <option value="{{$value->cid}}"
                                    @if($value->cid==$cid)
                                    selected
                                    @endif
                            >{{$value->cat_name}}</option>
                        @endforeach
                    </select>&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="submit" class="btn btn-primary">搜索</button>
                </div>
            </div>
        </form>--}}
        <!-- /.box-header -->
        <div class="box-body">
            <table class="table table-bordered">
                <tr>
                    <th style="width: 10px">ID</th>
                    <th>管理员名称</th>
                    <th>角色</th>
                    <th style="width: 40px" colspan="2">操作</th>
                </tr>
                @foreach($data as $key=>$value)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$value->name}}</td>
                    <td>{{$value->role_name}}</td>
                    <td style="width: 40px">
                        <a href="{{url('admin/adminuser/edit')}}?id={{$value->id}}"><button type="button" class="btn btn-block btn-danger btn-sm" >编辑</button></a>
                    </td>
                    <td style="width: 40px">
                            <button type="button" class="btn btn-block btn-success btn-sm" onclick="if(confirm('确定要删除吗？')){_delete({{$value->id}})}">删除</button>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
            {!! $data->links() !!}
            {{--<ul class="pagination pagination-sm no-margin pull-left">
                <li><a href="#">&laquo;</a></li>
                <li><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">&raquo;</a></li>
            </ul>--}}
        </div>
    </div>

    <script>

        function _delete(id){
            $.ajax({
                data:{
                    id:id,
                    _token:"{{csrf_token()}}"
                },
                dataType:'json',
                type:'post',
                url:"{{url('admin/adminuser/delete')}}",
                success:function(data){
                    alert(data.msg);
                    location.reload();
                }
            });
        }
    </script>





@endsection