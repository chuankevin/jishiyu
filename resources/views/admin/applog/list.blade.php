@extends('admin.layouts.layout')
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">App访问列表</h3>
        </div>
        <form class="form-inline" method="get">
            <div class="box-body">
                <div class="form-group">
                    时间：
                    <input type="text" class="form-control date-picker start" name="start_time" placeholder="" value="{{$start_time}}">－
                    <input type="text" class="form-control date-picker end" name="end_time" placeholder="" value="{{$end_time}}">&nbsp;&nbsp;&nbsp;&nbsp;
                    渠道编号：
                    <input type="text" class="form-control" name="channel" placeholder="渠道编号" value="{{$channel}}">&nbsp;&nbsp;&nbsp;&nbsp;
                    手机号：
                    <input type="text" class="form-control" name="mobile" placeholder="手机号" value="{{$mobile}}">&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="submit" class="btn btn-primary">搜索</button>
                </div>
            </div>
        </form>
        <!-- /.box-header -->
        <div class="box-body">
            <table class="table table-bordered">
                <tr>
                    <th style="width: 10px">ID</th>
                    <th>用户ID</th>
                    <th>渠道编号</th>
                    <th>手机号</th>
                    <th>APP访问量</th>
                    <th>APP点击量</th>

                </tr>
                @foreach($data as $key=>$value)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$value->user_id}}</td>
                    <td>{{$value->channel}}</td>
                    <td>{{$value->mobile}}</td>
                    <td>{{$value->open}}</td>
                    <td>{{$value->hits}}</td>

                </tr>
                @endforeach
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
            {!! $data->appends(['start_time'=>$start_time,'end_time'=>$end_time,'channel'=>$channel,'mobile'=>$mobile])->links() !!}
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
            $('.date-picker').datetimepicker({
                format:'yyyy-mm-dd hh:ii',
                autoclose: true,
                todayBtn : true,
                language: 'zh-CN',
            });
        });

    </script>





@endsection