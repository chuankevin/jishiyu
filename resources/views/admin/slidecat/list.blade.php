@extends('admin.layouts.layout')
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Banner分类列表</h3>
        </div>
       {{-- <form class="form-inline" method="get" >
            <div class="box-body">
                <div class="form-group">
                    渠道名称：
                    <input type="text" class="form-control" name="keywords" placeholder="渠道名称" value="{{$keywords}}">&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="submit" class="btn btn-primary">搜索</button>
                </div>
            </div>
        </form>--}}
        <!-- /.box-header -->
        <div class="box-body">
            <table class="table table-bordered">
                <tr>
                    <th style="width: 10px">ID</th>
                    <th>分类名称</th>
                    <th>分类标识</th>
                    <th>描述</th>
                    <th style="width: 40px" colspan="2">操作</th>
                </tr>
                @foreach($data as $key=>$value)
                <tr>
                    <td>{{$value->cid}}</td>
                    <td>{{$value->cat_name}}</td>
                    <td>{{$value->cat_idname}}</td>
                    <td>{{$value->cat_remark}}</td>
                    <td style="width: 40px">
                        <a href=""></a>
                    </td>
                    <td style="width: 40px">
                            <button type="button" class="btn btn-block btn-success btn-sm" onclick="if(confirm('确定要删除吗？')){_delete({{$value->cid}})}">删除</button>
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
                url:"{{url('admin/slidecat/delete')}}",
                success:function(data){
                    alert(data.msg);
                    location.reload();
                }
            });
        }
    </script>





@endsection