@extends('admin.layouts.layout')
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">业务点击量查询</h3>
        </div>
        <form class="form-inline" method="get">
            <div class="box-body">
                <div class="form-group">
                    时间：
                    <input type="text" class="form-control date-picker start" name="start_time" placeholder="" value="{{$start_time}}">－
                    <input type="text" class="form-control date-picker end" name="end_time" placeholder="" value="{{$end_time}}">&nbsp;&nbsp;&nbsp;&nbsp;
                   {{-- 渠道编号：
                    <input type="text" class="form-control" name="keywords" placeholder="渠道编号" value="{{$keywords}}">&nbsp;&nbsp;&nbsp;&nbsp;--}}
                    业务名称：
                    <input type="text" class="form-control" name="keywords" placeholder="请输入关键词" value="{{$keywords}}">&nbsp;&nbsp;&nbsp;&nbsp;
                    发布状态：
                    <select class="form-control selectpicker2" id="channel" name="post_status">
                        <option value="2" @if($post_status=='2') selected @endif >全部</option>
                        <option value="1" @if($post_status==1) selected @endif >已上架</option>
                        <option value="0" @if($post_status==0) selected @endif>已下架</option>
                    </select>&nbsp;&nbsp;&nbsp;&nbsp;
                    上架位置：
                    <select class="form-control selectpicker2" id="channel" name="location">
                        <option value="1" @if($location==1) selected @endif >APP</option>
                        <option value="2" @if($location==2) selected @endif>H5</option>
                    </select>&nbsp;
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
                    <th>业务名称</th>
                    <th>app点击</th>
                    <th>h5点击</th>
                    {{--<th>点击时间</th>--}}

                </tr>
                @foreach($data as $key=>$value)
                    <tr>
                        <td>{{$value->id}}</td>
                        <td style="width: 25%;">{{$value->post_title}}</td>
                        <td style="width: 25%;">{{$value->count}}</td>
                        <td style="width: 25%;">{{$value->h5_count}}</td>
                        <td></td>
                        {{--<td>{{$value->created_at}}</td>--}}
                    </tr>
                @endforeach
                <tr>
                    <th></th>
                    <th>总计</th>
                    <th>{{$app_sum}}</th>
                    <th>{{$h5_sum}}</th>
                    {{--<td>{{$value->created_at}}</td>--}}
                </tr>
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
            {!! $data->appends(['start_time'=>$start_time,'end_time'=>$end_time,'keywords'=>$keywords,'post_status'=>$post_status,'location'=>$location])->links() !!}
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