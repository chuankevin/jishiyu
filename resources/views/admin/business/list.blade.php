@extends('admin.layouts.layout')
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">业务列表</h3>
        </div>
        <form class="form-inline" method="get" >
            <div class="box-body">
                <div class="form-group">
                    关键词：
                    <input type="text" class="form-control" name="keywords" placeholder="请输入关键词" value="{{$keywords}}">&nbsp;&nbsp;&nbsp;&nbsp;
                    发布状态：
                    <select class="form-control selectpicker2" id="channel" name="post_status">
                        <option value="1" @if($post_status==1) selected @endif >已上架</option>
                        <option value="0" @if($post_status==0) selected @endif>已下架</option>
                    </select>&nbsp;&nbsp;&nbsp;
                    上架位置：
                    <select class="form-control selectpicker2" id="channel" name="location">
                        <option value="1" @if($location==1) selected @endif >APP</option>
                        <option value="2" @if($location==2) selected @endif>H5</option>
                    </select>&nbsp;&nbsp;&nbsp;&nbsp;
                    上架时间：
                    <input type="text" class="form-control date-picker start" name="start_time" placeholder="" value="{{$start_time}}">－
                    <input type="text" class="form-control date-picker end" name="end_time" placeholder="" value="{{$end_time}}">&nbsp;&nbsp;&nbsp;&nbsp;

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
                    <th style="width: 30px">排序</th>
                    <th>名称</th>
                    <th>app点击</th>
                    <th>h5点击</th>
                    <th>额度范围</th>
                    <th>费率</th>
                    <th>期限范围</th>
                    <th>缩略图</th>
                    <th>发布时间</th>
                    <th>
                        @if(isset($_GET['post_status']) && $_GET['post_status']==0)
                            下架时间
                        @else
                            更新时间
                        @endif
                    </th>
                    <th>状态</th>
                    <th>上架位置</th>
                    <th style="width: 40px" colspan="2">操作</th>
                </tr>
                @foreach($data as $key=>$value)
                <tr>
                    <td>{{$value->id}}</td>
                    <td><input type="text" style="width:30px" value="{{$value->listorder}}" onchange="changeOrder(this,{{$value->id}})"></td>
                    <td>
                        <a href="{{$value->link}}" target="_blank">{{$value->post_title}}</a>
                    </td>
                    <td>{{$value->post_hits}}</td>
                    <td>{{$value->h5_hits}}</td>
                    <td>{{$value->edufanwei}}</td>
                    <td>{{$value->feilv}}</td>
                    <td>{{$value->qixianfanwei}}</td>
                    <td>
                        @if($value->smeta!='')
                       <a href="{{asset('/upload/'.json_decode($value->smeta)->thumb)}}" target="_blank">
                            <img src="{{asset('/upload/'.json_decode($value->smeta)->thumb)}}" alt="" width="40">
                       </a>
                        @else
                               <a href="{{asset('/upload/default.png')}}" target="_blank">
                                   <img src="{{asset('/upload/default.png')}}" alt="" width="40">
                        @endif
                       </a>
                    </td>
                    <td>{{$value->post_date}}</td>
                    <td>{{$value->post_modified}}</td>
                    <td>@if($value->post_status==1) 已上架 @else 已下架 @endif</td>
                    <td>@if($value->location==1) APP @else H5 @endif</td>
                    <td style="width: 40px">
                        <button type="button" class="btn btn-block btn-warning btn-sm" onclick="if(confirm('确定要执行吗？')){is_sale({{$value->id}},{{$value->post_status}})}">@if($value->post_status==0) 上架 @else 下架 @endif</button>
                    </td>
                    <td style="width: 40px">
                        <a href="{{url('admin/business/edit')}}?id={{$value->id}}"><button type="button" class="btn btn-block btn-success btn-sm">编辑</button></a>
                    </td>
                    <td style="width: 40px">
                        <button type="button" class="btn btn-block btn-danger btn-sm" onclick="if(confirm('确定要删除吗？')){_delete({{$value->id}})}">删除</button>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">

           {!! $data->appends(['keywords'=>$keywords,'post_status'=>$post_status,'location'=>$location,'start_time'=>$start_time,'end_time'=>$end_time])->links() !!}

        </div>
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

        function _delete(id){
            $.ajax({
                data:{
                    id:id
                },
                dataType:'json',
                type:'get',
                url:"{{url('admin/business/delete')}}",
                success:function(data){
                    alert(data.msg);
                    location.reload();
                }
            });
        }

        function changeOrder(obj,id){
            $.ajax({
                data:{
                    id:id,
                    order:obj.value
                },
                dataType:'json',
                type:'get',
                url:"{{url('admin/business/order')}}",
                success:function(data){
                    //alert(data.msg);
                    location.reload();
                }
            });
        }

        function is_sale(id,status){
            $.ajax({
                data:{
                    id:id,
                    status:status
                },
                dataType:'json',
                type:'get',
                url:"{{url('admin/business/update')}}",
                success:function(data){
                    alert(data.msg);
                    location.reload();
                }
            });
        }
    </script>


@endsection