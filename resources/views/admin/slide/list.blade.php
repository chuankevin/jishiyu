@extends('admin.layouts.layout')
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Banner列表</h3>
        </div>
        <form class="form-inline" method="get" >
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
        </form>
        <!-- /.box-header -->
        <div class="box-body">
            <table class="table table-bordered">
                <tr>
                    <th style="width: 10px">ID</th>
                    <th>标题</th>
                    <th>描述</th>
                    <th>链接</th>
                    <th>图片</th>
                    <th>状态</th>
                    <th style="width: 40px" colspan="2">操作</th>
                </tr>
                @foreach($data as $key=>$value)
                <tr>
                    <td>{{$value->slide_id}}</td>
                    <td>{{$value->slide_name}}</td>
                    <td>{{$value->slide_des}}</td>
                    <td>{{$value->slide_url}}</td>
                    <td><a href="{{$value->slide_pic}}" target="_blank">查看</a></td>
                    <td>
                        @if($value->slide_status==1)
                            显示
                        @endif
                    </td>
                    <td style="width: 40px">
                        <a href="{{url('admin/slide/edit')}}?id={{$value->slide_id}}"><button type="button" class="btn btn-block btn-danger btn-sm" >编辑</button></a>
                    </td>
                    <td style="width: 40px">
                            <button type="button" class="btn btn-block btn-success btn-sm" onclick="if(confirm('确定要删除吗？')){_delete({{$value->slide_id}})}">删除</button>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
            {!! $data->appends(['cid'=>$cid])->links() !!}
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

        $(function() {
            $('.selectpicker2').select2();
        });

        function _delete(id){
            $.ajax({
                data:{
                    id:id,
                    _token:"{{csrf_token()}}"
                },
                dataType:'json',
                type:'post',
                url:"{{url('admin/slide/delete')}}",
                success:function(data){
                    alert(data.msg);
                    location.reload();
                }
            });
        }
    </script>





@endsection