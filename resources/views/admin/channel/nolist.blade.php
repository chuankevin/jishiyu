@extends('admin.layouts.layout')
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">渠道编号列表</h3>
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
                    <th style="width: 10px">ID</th>
                    <th>渠道编号</th>
                    <th>注册数量</th>
                    <th>激活数量</th>
                    <th>一级渠道</th>
                    <th>二级渠道</th>
                    <th>三级渠道</th>
                    <th>四级渠道</th>
                    <th>五级渠道</th>
                    <th>状态</th>
                    <th>创建时间</th>
                    <th style="width: 40px">操作</th>
                </tr>
                @foreach($data as $key=>$value)
                    <tr>
                        <td>{{$value->id}}</td>
                        <td>{{$value->no}}</td>
                        <td>{{$value->count}}</td>
                        <td>{{$value->activate_count}}</td>
                        <td>{{$value->lv1}}</td>
                        <td>{{$value->lv2}}</td>
                        <td>{{$value->lv3}}</td>
                        <td>{{$value->lv4}}</td>
                        <td>{{$value->lv5}}</td>

                        <td>
                            @if($value->is_delete==0)
                                正常
                            @elseif($value->is_delete==1)
                                禁用
                            @endif
                        </td>
                        <td>{{$value->create_at}}</td>
                        <td><button type="button" class="btn btn-block btn-danger btn-sm" onclick="if(confirm('确定要删除这条渠道吗？')){_delete({{$value->id}})}">删除</button></td>
                    </tr>
                @endforeach
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
            {!! $data->appends(['keywords'=>$keywords,'start_time'=>$start_time,'end_time'=>$end_time])->links() !!}
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