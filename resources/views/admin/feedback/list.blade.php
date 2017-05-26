@extends('admin.layouts.layout')
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">意见反馈列表</h3>
        </div>
        <form class="form-inline" method="get" >
            <div class="box-body">
                <div class="form-group">
                    关键词：
                    <input type="text" class="form-control" name="keywords" placeholder="请输入关键词" value="{{$keywords}}">&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="submit" class="btn btn-primary">搜索</button>
                    <button type="button" class="btn btn-success" onclick="location.reload()">刷新</button>
                </div>
            </div>
        </form>
        <!-- /.box-header -->
        <div class="box-body">
            <table class="table table-bordered">
                <tr>
                    <th style="width: 10px">ID</th>
                    <th>反馈问题</th>
                    <th>图片</th>
                    <th>手机号</th>
                    <th>邮箱</th>
                    <th>反馈时间</th>
                </tr>
                @foreach($data as $key=>$value)
                <tr>
                    <td>{{$value->id}}</td>
                    <td>{{$value->problem}}</td>
                    <td>{{$value->img}}</td>
                    <td>{{$value->mobile}}</td>
                    <td>{{$value->email}}</td>
                    <td>{{$value->created_at}}</td>

                </tr>
                @endforeach
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
            {!! $data->appends(['keywords'=>$keywords])->links() !!}
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
                url:"{{url('admin/role/delete')}}",
                success:function(data){
                    alert(data.msg);
                    location.reload();
                }
            });
        }
    </script>





@endsection