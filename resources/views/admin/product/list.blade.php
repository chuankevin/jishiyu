@extends('admin.layouts.layout')
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">产品列表</h3>
        </div>
        <form class="form-inline" method="get" >
            <div class="box-body">
                <div class="form-group">
                    关键词：
                    <input type="text" class="form-control" name="keywords" placeholder="请输入关键词" value="{{$keywords}}">&nbsp;&nbsp;&nbsp;&nbsp;
                    发布状态：
                    <select class="form-control selectpicker2" id="channel" name="status">
                        <option value="1" @if($status==1) selected @endif >已上架</option>
                        <option value="0" @if($status==0) selected @endif>已下架</option>
                    </select>&nbsp;&nbsp;&nbsp;
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
                    <th>产品名称</th>
                    <th>产品描述</th>
                    <th>产品类型</th>
                    <th>图标</th>
                    <th>发布时间</th>
                    <th>状态</th>
                    <th style="width: 40px" colspan="2">操作</th>
                </tr>
                @foreach($data as $key=>$value)
                <tr>
                    <td>{{$value->id}}</td>
                    <td><input type="text" style="width:30px" value="{{$value->order}}" onchange="changeOrder(this,{{$value->id}})"></td>
                    <td><a href="{{$value->pro_link}}" target="_blank">{{$value->pro_name}}</a></td>
                    <td>{{$value->pro_describe}}</td>
                    <td>
                        @if($value->type==1)
                            好评推荐
                        @else
                            急速放贷
                        @endif
                    </td>
                    <td>
                       <a href="{{asset('upload/'.$value->img)}}" target="_blank">
                            <img src="{{asset('upload/'.$value->img)}}" alt="" width="40">
                       </a>
                    </td>
                    <td>{{$value->created_at}}</td>
                    <td>@if($value->status==1) 已上架 @else 已下架 @endif</td>
                    <td style="width: 40px">
                        <button type="button" class="btn btn-block btn-warning btn-sm" onclick="if(confirm('确定要执行吗？')){is_sale({{$value->id}},{{$value->status}})}">@if($value->status==0) 上架 @else 下架 @endif</button>
                    </td>
                    <td style="width: 40px">
                        <a href="{{url('admin/product/edit')}}?id={{$value->id}}"><button type="button" class="btn btn-block btn-success btn-sm">编辑</button></a>
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

           {!! $data->appends(['keywords'=>$keywords,'post_status'=>$status])->links() !!}

        </div>
    </div>

    <script>
        $(function() {
            //$('.selectpicker2').select2();
        });

        function _delete(id){
            $.ajax({
                data:{
                    id:id
                },
                dataType:'json',
                type:'get',
                url:"{{url('admin/product/delete')}}",
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
                url:"{{url('admin/product/order')}}",
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
                url:"{{url('admin/product/update')}}",
                success:function(data){
                    alert(data.msg);
                    location.reload();
                }
            });
        }
    </script>


@endsection