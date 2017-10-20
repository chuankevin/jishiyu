@extends('admin.layouts.layout')
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">点击量查询</h3>
        </div>
        <form class="form-inline" method="get">
            <div class="box-body">
                <div class="form-group">
                    时间：
                    <input type="text" class="form-control date-picker start" name="start_time" placeholder="" value="{{$start_time}}">－
                    <input type="text" class="form-control date-picker end" name="end_time" placeholder="" value="{{$end_time}}">&nbsp;&nbsp;&nbsp;&nbsp;
                    点击排序：
                    <select class="form-control selectpicker2" name="list_order">
                        <option value="desc" @if($list_order=='desc') selected @endif >降序</option>
                        <option value="asc" @if($list_order=='asc') selected @endif >升序</option>
                    </select>&nbsp;&nbsp;&nbsp;&nbsp;
                    {{--上架位置：
                    <select class="form-control selectpicker2" id="channel" name="location">

                    </select>--}}&nbsp;
                    <button type="submit" class="btn btn-primary">搜索</button>
                    <button type="button" class="btn btn-success" onclick="location.reload()">刷新</button>
                </div>
            </div>
        </form>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="col-md-20">
                <!-- Custom Tabs -->
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false">新APP</a></li>
                        <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="true">老APP</a></li>
                        <li class=""><a href="#tab_3" data-toggle="tab">H5</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <table class="table table-bordered">
                                <tr>
                                    <th>产品名称</th>
                                    <th>点击量</th>
                                    <th>点击时间</th>
                                </tr>
                                @foreach($product_hits as $key=>$value)
                                    <tr>
                                        <td style="width: 25%;">{{$value['pname']}}</td>
                                        <td style="width: 25%;">{{$value->hits}}</td>
                                        <td style="width: 25%;">{{$value->created_at}}</td>
                                    </tr>
                                @endforeach
                                 <tr>
                                     <th>总计</th>
                                     <th>{{$product_hits_total}}</th>
                                     <td></td>
                                 </tr>
                            </table>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="tab_2">
                            <table class="table table-bordered">
                                <tr>
                                    <th>产品名称</th>
                                    <th>点击量</th>
                                    <th>点击时间</th>
                                </tr>
                                @foreach($business_hits as $key=>$value)
                                    <tr>
                                        <td style="width: 25%;">{{$value['pname']}}</td>
                                        <td style="width: 25%;">{{$value->hits}}</td>
                                        <td style="width: 25%;">{{$value->created_at}}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th>总计</th>
                                    <th>{{$business_hits_total}}</th>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="tab_3">
                            <table class="table table-bordered">
                                <tr>
                                    <th>产品名称</th>
                                    <th>点击量</th>
                                    <th>点击时间</th>
                                </tr>
                                @foreach($h5_hits as $key=>$value)
                                    <tr>
                                        <td style="width: 25%;">{{$value['pname']}}</td>
                                        <td style="width: 25%;">{{$value->hits}}</td>
                                        <td style="width: 25%;">{{$value->created_at}}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th>总计</th>
                                    <th>{{$h5_hits_total}}</th>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- nav-tabs-custom -->
            </div>

        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
            {{--{!! $data->appends(['start_time'=>$start_time,'end_time'=>$end_time,'keywords'=>$keywords,'post_status'=>$post_status,'location'=>$location])->links() !!}--}}
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