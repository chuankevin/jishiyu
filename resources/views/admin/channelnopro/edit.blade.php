@extends('admin.layouts.layout')
@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">编辑比例</h3>
        </div>

        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" method="post" onsubmit="return check()">
            {{csrf_field()}}
            <div class="box-body">

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">渠道：</label>

                    <div class="checkbox col-sm-4">
                        <select class="form-control selectpicker2" id="channel_no_id" name="channel_no_id" disabled="disabled">
                            <option value="">请选择</option>
                            @foreach($channels as $channel)
                                <option value="{{$channel->id}}"
                                @if($data->channel_no_id==$channel->id)
                                    selected
                                @endif
                                >{{$channel->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">比例：</label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="proportion" placeholder="" name="proportion" value="{{$data->proportion}}">%
                    </div>
                </div>
                <div class="box-body">
                    <label for="" class="col-sm-2 control-label">其他时段：</label>
                    <div class="form-group" style="float: left;margin-left: 0%">
                        <input type="text" class="form-control date-picker start" name="start_time" placeholder="" value="{{$data->start}}" style="width:200px">－
                        <input type="text" class="form-control date-picker end" name="end_time" placeholder="" value="{{$data->end}}" style="width:200px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">其他时段比例：</label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="proportion2" placeholder="" name="proportion2" value="{{$data->proportion2}}">%
                    </div>
                </div>

                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">提交</button>
                    <a href="javascript:history.go(-1);"><button type="button" class="btn btn-default">取消</button></a>

                </div>
                <!-- /.box-footer -->
            </div>
        </form>
    </div>

    @if(isset($msg))
        <script type="text/javascript">
            $(function(){
                msg('{{$msg}}');
            });

        </script>
    @endif

    <script>
        $(function() {
            $('.date-picker').datepicker({
                format:'yyyy-mm-dd',
                language: 'zh-CN',
                autoclose: true,
                todayBtn : true,
            });
        });
        //字段验证
        function check(){

        /*    var reg=/^\w+$/;
            //alert(reg.test($('#name').val()));
            if(!reg.test($('#name').val())){
                msg('用户名格式不正确');
                return false;
            }*/
            //角色
            if($('#channel_no__id').val()=='') {
                msg('请选择渠道');
                return false;
            }

            if($('#proportion').val()=='') {
                msg('请填写比例');
                return false;
            }

        }


    </script>

@endsection