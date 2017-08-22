@extends('admin.layouts.layout')
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">渠道点击量查询</h3>
        </div>
        <form class="form-inline" method="get">
            <div class="box-body">
                <div class="form-group">
                    时间：
                    <input type="text" class="form-control date-picker start" name="start_time" placeholder="" value="{{$start_time}}">－
                    <input type="text" class="form-control date-picker end" name="end_time" placeholder="" value="{{$end_time}}">&nbsp;&nbsp;&nbsp;&nbsp;
                    渠道编号：
                    <input type="text" class="form-control" name="keywords" placeholder="渠道编号" value="{{$keywords}}">&nbsp;&nbsp;&nbsp;&nbsp;
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
                    <th>渠道名称</th>
                    <th>渠道注册量</th>
                    <th>点击品类量</th>
                    <th>总点击次数</th>
                    <th>点击人数</th>
                    <th>点击人数（当日注册点击）</th>
                    <th>留存</th>
                </tr>
                @foreach($data as $key=>$value)
                    <tr>
                        <td>{{$value->channel}}</td>
                        <td>{{$value->name}}</td>
                        <td>{{$value->reg_num}}</td>
                        <td>{{$value->pro_num}}</td>
                        <td>{{$value->hits_num}}</td>
                        <td>{{$value->user_num}}</td>
                        <td>{{$value->today_num}}</td>
                        <td>
                            @if($value->yes_reg==0)
                                0%
                            @else
                                {{round(($value->user_num-$value->today_num)/($value->yes_reg),2)}} %
                            @endif
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <th>总计</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>{{$total[0]['hits_total']}}</th>
                    <th></th>
                    <th></th>
                </tr>
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
            {!! $data->appends(['start_time'=>$start_time,'end_time'=>$end_time,'keywords'=>$keywords])->links() !!}
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
       /* function checkForm(){
            if($('.start').val()>$('.end').val()){
                alert('开始时间不能大于结束时间');
                return false;
            }
        }*/

        $(function() {
            $('.date-picker').datepicker({
                format:'yyyy-mm-dd',
                language: 'zh-CN',
                autoclose: true,
                todayBtn : true,
            });
        });

        function _delete(id){
            $.ajax({
                data:{
                    id:id,
                },
                dataType:'json',
                type:'get',
                url:"{{url('admin/channel/delete')}}",
                success:function(data){
                    alert(data.msg);
                    location.reload();
                }
            });
        }
    </script>




@endsection