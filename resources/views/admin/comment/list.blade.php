@extends('admin.layouts.layout')
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">用户评论列表</h3>
        </div>
        <form class="form-inline" method="get" >
            <div class="box-body">
                <div class="form-group">
                    时间：
                    <input type="text" class="form-control date-picker start" id='start_time' name="start_time" placeholder="" value="{{$start_time}}">－
                    <input type="text" class="form-control date-picker end" id="end_time" name="end_time" placeholder="" value="{{$end_time}}">&nbsp;&nbsp;&nbsp;&nbsp;
                   {{-- 关键词：
                    <input type="text" class="form-control" name="keywords" placeholder="请输入关键词" value="{{$keywords}}">&nbsp;&nbsp;&nbsp;&nbsp;--}}
                    <button type="submit" class="btn btn-primary">搜索</button>
                    <button type="button" class="btn btn-success" onclick="location.reload()">刷新</button>
                </div>
            </div>
        </form>
        <!-- /.box-header -->
        <div class="box-body">
            <table class="table table-bordered">
                <tr>
                    <th>用户</th>
                    <th>评论产品</th>
                    <th>评分</th>
                    <th style="width: 50%">评论内容</th>
                    <th>评论时间</th>
                    <th style="width: 5%" colspan="2">操作</th>

                </tr>
                @foreach($data as $key=>$value)
                <tr>
                    <td>{{$value->mobile}}</td>
                    <td>{{$value->pro_name}}</td>
                    <td>{{$value->score}}</td>
                    <td>{{str_limit($value->comment,70,'...')}}</td>
                    <td>{{$value->created_at}}</td>
                    <td><a href="{{url('admin/comment/detail')}}?id={{$value->id}}"><button type="button" class="btn btn-block btn-success btn-sm">查看</button></a></td>
                    <td>
                        @if($value->is_hide==0)
                            <button type="button" class="btn btn-block btn-danger btn-sm" onclick="is_hide({{$value->id}},{{$value->is_hide}})">隐藏</button>
                        @elseif($value->is_hide==1)
                            <button type="button" class="btn btn-block btn-success btn-sm" onclick="is_hide({{$value->id}},{{$value->is_hide}})">显示</button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
            {!! $data->appends(['start_time'=>$start_time,'end_time'=>$end_time])->links() !!}
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
            $('.date-picker').datepicker({
                format:'yyyy-mm-dd',
                language: 'zh-CN',
                autoclose: true,
                todayBtn : true,
            });
        });

        function is_hide(id,is_hide){
            $.ajax({
                data:{
                    id:id,
                    is_hide:is_hide,
                    _token:"{{csrf_token()}}"
                },
                dataType:'json',
                type:'post',
                url:"{{url('admin/comment/hide')}}",
                success:function(data){
                    alert(data.msg);
                    location.reload();
                }
            });
        }
    </script>





@endsection