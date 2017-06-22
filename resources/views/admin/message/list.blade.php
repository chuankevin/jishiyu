@extends('admin.layouts.layout')
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">提醒列表</h3>
        </div>
        <form class="form-inline" method="get" >
            <div class="box-body">
                <div class="form-group">
                    关键词：
                    <input type="text" class="form-control" name="keywords" placeholder="请输入关键词" value="{{$keywords}}">&nbsp;&nbsp;&nbsp;&nbsp;
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
                    <th>姓名</th>
                    <th>提醒类型</th>
                    <th>金额</th>
                    <th>还款日期</th>
                    <th>重复方式</th>
                    <th>提醒周期</th>
                    <th>推送时间</th>
                    <th>备注</th>
                    <th>创建时间</th>
                </tr>
                @foreach($data as $key=>$value)
                <tr>
                    <td>{{$value->msg_id}}</td>
                    <td>{{$value->name}}</td>
                    <td>{{$value->type_name}}</td>
                    <td>{{$value->amount}}</td>
                    <td>{{$value->repayment_date}}</td>
                    <td>{{$value->rep_name}}</td>
                    <td>{{$value->rem_name}}</td>
                    <td>{{$value->push_time}}</td>
                    <td>{{$value->remark}}</td>
                    <td>{{$value->created_at}}</td>
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

    <script>

        function _delete(id){
            $.ajax({
                data:{
                    id:id,
                    _token:"{{csrf_token()}}"
                },
                dataType:'json',
                type:'post',
                url:"{{url('admin/role/delete')}}",
                success:function(data){
                    alert(data.msg);
                    location.reload();
                }
            });
        }
    </script>





@endsection