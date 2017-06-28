@extends('admin.layouts.layout')
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">银行列表</h3>
        </div>
       {{-- <form class="form-inline" method="get" >
            <div class="box-body">
                <div class="form-group">
                    关键词：
                    <input type="text" class="form-control" name="keywords" placeholder="请输入关键词" value="{{$keywords}}">&nbsp;&nbsp;&nbsp;&nbsp;
                    发布状态：
                    <select class="form-control selectpicker2" id="channel" name="post_status">
                        <option value="1" @if($post_status==1) selected @endif >已上架</option>
                        <option value="0" @if($post_status==0) selected @endif>已下架</option>
                    </select>&nbsp;&nbsp;&nbsp;
                    <button type="submit" class="btn btn-primary">搜索</button>
                    <button type="button" class="btn btn-success" onclick="location.reload()">刷新</button>
                </div>
            </div>
        </form>--}}
        <!-- /.box-header -->
        <div class="box-body">
            <table class="table table-bordered">
                <tr>
                    <th style="width: 10px">ID</th>
                    <th>银行名称</th>
                    <th>描述</th>
                    <th>图片</th>
                    <th>链接</th>
                    <th>发布时间</th>
                    <th style="width: 40px" colspan="2">操作</th>
                </tr>
                @foreach($data as $key=>$value)
                <tr>
                    <td>{{$value->id}}</td>
                    <td>{{$value->name}}</td>
                    <td>{{$value->describe}}</td>
                    <td><img  src="{{asset('/upload/'.$value->icon)}}" width="50" /></td>
                    <td><a href="{{$value->link}}">{{$value->link}}</a></td>
                    <td>{{$value->created_at}}</td>
                    <td style="width: 40px">
                        <a href="{{url('admin/bank/edit')}}?id={{$value->id}}"><button type="button" class="btn btn-block btn-success btn-sm">编辑</button></a>
                    </td>
                    <td style="width: 40px">
                        <button type="button" class="btn btn-block btn-danger btn-sm" onclick="if(confirm('确定要删除吗？')){_delete({{$value->id}})}">删除</button>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">

           {!! $data->links() !!}

        </div>
    </div>

    <script>
        $(function() {
            //$('.selectpicker2').select2();
        });

        function _delete(id){
            $.ajax({
                data:{
                    id:id
                },
                dataType:'json',
                type:'get',
                url:"{{url('admin/bank/delete')}}",
                success:function(data){
                    alert(data.msg);
                    location.reload();
                }
            });
        }

    </script>


@endsection