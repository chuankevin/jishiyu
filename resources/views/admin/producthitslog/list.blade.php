@extends('admin.layouts.layout')
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">产品点击量查询</h3>
        </div>
        <form class="form-inline" method="get">
            <div class="box-body">
                <div class="form-group">
                    时间：
                    <input type="text" class="form-control date-picker start" name="start_time" placeholder="" value="{{$start_time}}">－
                    <input type="text" class="form-control date-picker end" name="end_time" placeholder="" value="{{$end_time}}">&nbsp;&nbsp;&nbsp;&nbsp;
                   {{-- 渠道编号：
                    <input type="text" class="form-control" name="keywords" placeholder="渠道编号" value="{{$keywords}}">&nbsp;&nbsp;&nbsp;&nbsp;--}}
                    产品名称：
                    <input type="text" class="form-control" name="keywords" placeholder="请输入关键词" value="{{$keywords}}">&nbsp;&nbsp;&nbsp;&nbsp;
                    发布状态：
                    <select class="form-control selectpicker2" id="channel" name="status">
                        <option value="1" @if($status==1) selected @endif >已上架</option>
                        <option value="0" @if($status==0) selected @endif>已下架</option>
                    </select>&nbsp;&nbsp;
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
                    <th>产品名称</th>
                    <th>app点击</th>
                </tr>
                @foreach($data as $key=>$value)
                    <tr>
                        <td>{{$value->id}}</td>
                        <td style="width: 25%;">{{$value->pro_name}}</td>
                        <td style="width: 25%;">{{$value->count}}</td>
                        <td></td>
                    </tr>
                @endforeach
                <tr>
                    <th></th>
                    <th>总计</th>
                    <th>{{$app_sum}}</th>
                </tr>
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
            {!! $data->appends(['start_time'=>$start_time,'end_time'=>$end_time])->links() !!}
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