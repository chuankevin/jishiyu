@extends('admin.layouts.layout')
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">兑换记录</h3>
        </div>
        <form class="form-inline" method="get" >
            <div class="box-body">
                <div class="form-group">
                    时间：
                    <input type="text" class="form-control date-picker start" name="start_time" placeholder="" value="{{$start_time}}">－
                    <input type="text" class="form-control date-picker end" name="end_time" placeholder="" value="{{$end_time}}">&nbsp;&nbsp;&nbsp;&nbsp;
                    订单号：
                    <input type="text" class="form-control" name="order_code" placeholder="" value="{{$order_code}}">&nbsp;&nbsp;&nbsp;&nbsp;
                    手机号：
                    <input type="text" class="form-control" name="mobile" placeholder="" value="{{$mobile}}">&nbsp;&nbsp;&nbsp;&nbsp;
                    状态：
                    <select class="form-control selectpicker2" name="status">
                        <option value="" @if($status=='') selected @endif >全部</option>
                        <option value="1" @if($status==1) selected @endif >处理中</option>
                        <option value="2" @if($status==2) selected @endif >已发放</option>
                    </select>&nbsp;&nbsp;&nbsp;

                    <button type="submit" class="btn btn-primary">搜索</button>
                </div>
            </div>
        </form>
        <!-- /.box-header -->
        <div class="box-body">
            <table class="table table-bordered">
                <tr>
                    <th style="width: 10px">ID</th>
                    <th>订单号</th>
                    <th>商品名称</th>
                    <th>收货人姓名</th>
                    <th>充值手机号</th>
                    <th>消费积分</th>
                    <th>状态</th>
                    <th>兑换时间</th>
                    <th style="width: 40px" colspan="1">操作</th>
                </tr>
                @foreach($data as $key=>$value)
                <tr>
                    <td>{{$value->id}}</td>
                    <td>{{$value->order_code}}</td>
                    <td>{{$value->sku_name}}</td>
                    <td>{{$value->receiver}}</td>
                    <td>{{$value->mobile}}</td>
                    <td>{{$value->score}} 积分</td>
                    <td> @if($value->status==1)
                            处理中
                         @elseif($value->status==2)
                            已发放
                        @endif
                    </td>
                    <td>{{$value->created_at}}</td>
                    <td style="width: 40px">
                        @if($value->status==1)
                        <button type="button" class="btn btn-block btn-success btn-sm" onclick="grant({{$value->id}})">发放</button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
            {!! $data->appends(['start_time'=>$start_time,'end_time'=>$end_time,'order_code'=>$order_code,'mobile'=>$mobile,'status'=>$status])->links() !!}
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

        function grant(id){
            $.ajax({
                data:{
                    id:id,
                    _token:"{{csrf_token()}}"
                },
                dataType:'json',
                type:'post',
                url:"{{url('admin/scoreproduct/grant')}}",
                success:function(data){
                    alert(data.msg);
                    location.reload();
                }
            });
        }

    </script>





@endsection