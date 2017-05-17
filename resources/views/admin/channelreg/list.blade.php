@extends('admin.layouts.layout')
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">注册查询</h3>
        </div>
        <form class="form-inline" method="get">
            <div class="box-body">
                <div class="form-group">
                    时间：
                    <input type="text" class="form-control date-picker start" name="start_time" placeholder="" value="{{$start_time}}">－
                    <input type="text" class="form-control date-picker end" name="end_time" placeholder="" value="{{$end_time}}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="submit" class="btn btn-primary">搜索</button>
                    <button type="button" class="btn btn-success" onclick="location.reload()">刷新</button>
                </div>
            </div>
        </form>
        <!-- /.box-header -->
        <div class="box-body">
            <table class="table table-bordered">
                <tr>
                    <th>渠道编号</th>
                    <th>注册数量</th>
                    <th>一级渠道</th>
                    <th>二级渠道</th>
                    <th>三级渠道</th>
                    <th>四级渠道</th>
                    <th>五级渠道</th>

                </tr>
                {{--@foreach($data as $key=>$value)--}}
                    <tr>
                        <td>{{$data->no}}</td>
                        <td>{{$data->count}}</td>
                        <td>{{$data->lv1}}</td>
                        <td>{{$data->lv2}}</td>
                        <td>{{$data->lv3}}</td>
                        <td>{{$data->lv4}}</td>
                        <td>{{$data->lv5}}</td>

                    </tr>
                {{--@endforeach--}}
            </table>
        </div>
        <!-- /.box-body -->
        {{--<div class="box-footer clearfix">
            {!! $data->appends(['keywords'=>$keywords,'start_time'=>$start_time,'end_time'=>$end_time])->links() !!}
            --}}{{--<ul class="pagination pagination-sm no-margin pull-left">
                <li><a href="#">&laquo;</a></li>
                <li><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">&raquo;</a></li>
            </ul>--}}{{--
        </div>--}}
    </div>

    <script>
        $(function() {
            $('.date-picker').datepicker({
                format:'yyyy-mm-dd',
                language: 'zh-CN',
                autoclose: true,
                todayBtn : true,
            });
        });
    </script>


@endsection