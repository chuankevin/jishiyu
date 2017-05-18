@extends('admin.layouts.layout')
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">用户管理列表</h3>
        </div>
        <form class="form-inline" method="get" >
            <div class="box-body">
                <div class="form-group">
                    时间：
                    <input type="text" class="form-control date-picker start" id='start_time' name="start_time" placeholder="" value="{{$start_time}}">－
                    <input type="text" class="form-control date-picker end" id="end_time" name="end_time" placeholder="" value="{{$end_time}}">&nbsp;&nbsp;&nbsp;&nbsp;
                    渠道号：
                    <select class="form-control selectpicker2" id="channel" name="channel">
                        <option value="">请选择渠道号</option>
                        @foreach($channels as $value)
                            <option value="{{$value->id}}"
                                    @if($value->id==$channel)
                                        selected
                                    @endif
                            >{{$value->no}}</option>
                        @endforeach
                    </select>&nbsp;&nbsp;&nbsp;&nbsp;
                    手机：
                    <input type="text" class="form-control" id="mobile" name="mobile" placeholder="请输入手机号" value="{{$mobile}}">&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="submit" class="btn btn-primary">搜索</button>
                    <button type="button" class="btn btn-success" onclick="location.reload()">刷新</button>
                    <button type="button" class="btn btn-warning" onclick="exportExcel()">导出</button>
                </div>
            </div>
        </form>
        <!-- /.box-header -->
        <div class="box-body">
            <table class="table table-bordered">
                <tr>
                    <th style="width: 10px">ID</th>
                    <th>来源</th>
                    <th>渠道编号</th>
                    <th>用户名</th>
                    <th>昵称</th>
                    <th>头像</th>
                    <th>手机</th>
                    <th>注册时间</th>
                    <th>最后登录时间</th>
                    <th>最后登录IP</th>
                    <th>状态</th>
                    <th>点击</th>
                    <th style="width: 40px">操作</th>
                </tr>
                @foreach($data as $key=>$value)
                <tr>
                    <td>{{$value->id}}</td>
                    <td>{{$value->reg_from}}</td>
                    <td>{{$value->channel}}</td>
                    <td>
                        @if($value->user_login=='')
                            第三方用户
                        @endif
                    </td>
                    <td>
                        @if($value->user_nicename=='')
                            未填写
                        @endif
                    </td>
                    <td>{{$value->avatar}}</td>
                    <td>{{$value->mobile}}</td>
                    <td>{{$value->create_time}}</td>
                    <td>{{$value->last_login_time}}</td>
                    <td>{{$value->last_login_ip}}</td>
                    <td>
                        @if($value->user_status==1)
                            正常
                        @elseif($value->user_status==0)
                            禁用
                        @elseif($value->user_status==2)
                            未验证
                        @endif
                    </td>
                    <td>{{$value->hits}}</td>
                    <td>
                        @if($value->user_status==1)
                            <button type="button" class="btn btn-block btn-danger btn-sm" onclick="is_delete({{$value->id}},{{$value->user_status}})">禁用</button>
                        @elseif($value->user_status==0)
                            <button type="button" class="btn btn-block btn-success btn-sm" onclick="is_delete({{$value->id}},{{$value->user_status}})">启用</button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
            {!! $data->appends(['channel'=>$channel,'mobile'=>$mobile,'start_time'=>$start_time,'end_time'=>$end_time])->links() !!}
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


        function is_delete(id,status){
            $.ajax({
                data:{
                    id:id,
                    status:status,
                    _token:"{{csrf_token()}}"
                },
                dataType:'json',
                type:'post',
                url:"{{url('admin/user/delete')}}",
                success:function(data){
                    alert(data.msg);
                    location.reload();
                }
            });
        }

        function exportExcel(){
            var start_time=$('#start_time').val();
            var end_time=$('#end_time').val();
            var mobile=$('#mobile').val();
            var channel=$('#channel').val();
            //alert(start_time);return false;
                $.ajax({
                    data:{
                        start_time:start_time,
                        end_time:end_time,
                        mobile:mobile,
                        channel:channel,
                        _token:"{{csrf_token()}}"
                    },
                    dataType:'json',
                    type:'post',
                    url:"{{url('/admin/user/export')}}",
                    success:function(data){
                        location.href=data.url;
                    }
                });
        }
    </script>





@endsection