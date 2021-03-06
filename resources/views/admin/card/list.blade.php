@extends('admin.layouts.layout')
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">信用卡列表</h3>
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
                    <th>名称</th>
                    <th>点击量</th>
                    <th>额度范围</th>
                    <th>费率</th>
                    <th>期限范围</th>
                    <th>最快放款</th>
                    <th>缩略图</th>
                    <th>发布时间</th>
                    {{--<th>状态</th>--}}
                    <th style="width: 40px" colspan="2">操作</th>
                </tr>
                @foreach($data as $key=>$value)
                <tr>
                    <td>{{$value->id}}</td>
                    <td>
                        <a href="{{$value->link}}" target="_blank">{{$value->post_title}}</a>
                    </td>
                    <td>{{$value->post_hits}}</td>
                    <td>{{$value->edufanwei}}</td>
                    <td>{{$value->feilv}}</td>
                    <td>{{$value->qixianfanwei}}</td>
                    <td>{{$value->zuikuaifangkuan}}</td>
                    <td>
                        @if($value->smeta!='')
                       <a href="{{asset('/upload/'.json_decode($value->smeta)->thumb)}}" target="_blank">
                            <img src="{{asset('/upload/'.json_decode($value->smeta)->thumb)}}" alt="" width="40">
                        @else
                               <a href="{{asset('/upload/default.png')}}" target="_blank">
                                   <img src="{{asset('/upload/default.png')}}" alt="" width="40">
                        @endif
                       </a>
                    </td>
                    <td>{{$value->post_date}}</td>
                    {{--<td></td>--}}
                    <td style="width: 40px">
                        <a href="{{url('admin/card/edit')}}?id={{$value->id}}"><button type="button" class="btn btn-block btn-success btn-sm">编辑</button></a>
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
           {!! $data->appends(['keywords'=>$keywords])->links() !!}

        </div>
    </div>

    <script>
        $(function() {
            $('.selectpicker2').select2();
        });

        function _delete(id){
            $.ajax({
                data:{
                    id:id
                },
                dataType:'json',
                type:'get',
                url:"{{url('admin/card/delete')}}",
                success:function(data){
                    alert(data.msg);
                    location.reload();
                }
            });
        }
    </script>





@endsection