@extends('admin.layouts.layout')
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">用户点击统计</h3>
        </div>
        <form class="form-inline" method="get" >
            <div class="box-body">
                <div class="form-group">
                   {{-- 时间：
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
                            >{{$value->name}}</option>
                        @endforeach
                    </select>&nbsp;&nbsp;&nbsp;&nbsp;--}}
                    手机号：
                    <input type="text" class="form-control" id="keywords" name="mobile" placeholder="请输入手机号" value="{{$keywords}}">&nbsp;&nbsp;&nbsp;&nbsp;
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
                    <th>用户手机</th>
                    <th>今日点击</th>
                    <th>昨日点击</th>
                    <th>一周点击</th>
                    <th>当月点击</th>
                </tr>
                @foreach($data as $key=>$value)
                <tr>
                    <td>{{$value->id}}</td>
                    <td>{{$value->mobile}}</td>
                    <td>{{$value->today}}</td>
                    <td>{{$value->yesterday}}</td>
                    <td>{{$value->week}}</td>
                    <td>{{$value->month}}</td>
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




@endsection