@extends('admin.layouts.layout')
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">恶意用户列表</h3>
        </div>
        <form class="form-inline" method="get" >
            <div class="box-body">
                <div class="form-group">
                    时间：
                    <input type="text" class="form-control datetime-picker start" id='start_time' name="start_time" placeholder="" value="{{$start_time}}">－
                    <input type="text" class="form-control datetime-picker end" id="end_time" name="end_time" placeholder="" value="{{$end_time}}">&nbsp;&nbsp;&nbsp;&nbsp;
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
                    <th style="width: 60px">ID</th>
                    <th>手机号</th>
                    <th>注册时间</th>
                    <th>记录时间</th>

                </tr>
                @foreach($data as $key=>$value)
                <tr>
                    <td>{{$value->id}}</td>
                    <td>{{$value->mobile}}</td>
                    <td>{{$value->create_time}}</td>
                    <td>{{$value->created_at}}</td>

                </tr>
                @endforeach
              {{--  <tr>
                    <th>总计</th>
                    <th>{{count($data)}}</th>
                </tr>--}}
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
            {!! $data->appends(['start_time'=>$start_time,'end_time'=>$end_time,'mobile'=>$mobile])->links() !!}
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
            $('.datetime-picker').datetimepicker({
                format:'yyyy-mm-dd hh:ii',
                language: 'zh-CN',
                autoclose: true,
                todayBtn : true,
            });
        });



        function exportExcel(){
            var start_time=$('#start_time').val();
            var end_time=$('#end_time').val();
            var mobile=$('#mobile').val();
                $.ajax({
                    data:{
                        start_time:start_time,
                        end_time:end_time,
                        mobile:mobile,
                        _token:"{{csrf_token()}}"
                    },
                    dataType:'json',
                    type:'post',
                    url:"{{url('/admin/sendcode/export')}}",
                    success:function(data){
                        location.href=data.url;
                    }
                });
        }
    </script>





@endsection