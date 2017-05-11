@extends('admin.layouts.layout')
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">基础渠道列表</h3>
        </div>
        <form class="form-inline" method="get" >
            <div class="box-body">
                <div class="form-group">
                    渠道名称：
                    <input type="text" class="form-control" name="keywords" placeholder="渠道名称" value="{{$keywords}}">&nbsp;&nbsp;&nbsp;&nbsp;
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
                    <th>渠道名称</th>
                    <th>渠道等级</th>
                    <th>创建时间</th>
                    <th>状态</th>
                    <th style="width: 40px">操作</th>
                </tr>
                @foreach($data as $key=>$value)
                <tr>
                    <td>{{$value->id}}</td>
                    <td>{{$value->name}}</td>
                    <td>{{$value->lv}}</td>
                    <td>{{$value->create_at}}</td>

                    <td>
                        @if($value->is_delete==0)
                            正常
                        @elseif($value->is_delete==1)
                            禁用
                        @endif
                    </td>
                    <td>
                        @if($value->is_delete==0)
                            <button type="button" class="btn btn-block btn-danger btn-sm" onclick="is_delete({{$value->id}},{{$value->is_delete}})">禁用</button>
                        @elseif($value->is_delete==1)
                            <button type="button" class="btn btn-block btn-success btn-sm" onclick="is_delete({{$value->id}},{{$value->is_delete}})">启用</button>
                        @endif
                    </td>
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
        function is_delete(id,is_delete){
            $.ajax({
                data:{
                    id:id,
                    is_delete:is_delete,
                    _token:"{{csrf_token()}}"
                },
                dataType:'json',
                type:'post',
                url:"{{url('admin/channel/update')}}",
                success:function(data){
                    alert(data.msg);
                    location.reload();
                }
            });
        }
    </script>





@endsection