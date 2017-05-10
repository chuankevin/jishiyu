@extends('admin.layouts.layout')
@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">添加渠道</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" method="post" onsubmit="return check()">
            {{csrf_field()}}
            <div class="box-body">
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">渠道等级：</label>

                    <div class="col-sm-4">
                        <select class="form-control" name="lv" id="lv">
                            <option value="1">一级渠道</option>
                            <option value="2">二级渠道</option>
                            <option value="3">三级渠道</option>
                            <option value="4">四级渠道</option>
                            <option value="5">五级渠道</option>
                        </select>
                    </div>
                </div>
                <div class="form-group lv-1" style="display:none">
                    <label for="" class="col-sm-2 control-label">一级渠道：</label>

                    <div class="col-sm-4">
                        <select class="form-control" name="" onchange="getLv2(1,2)">
                            <option value="">请选择</option>
                            @foreach($channel1 as $key=>$value)
                                <option value="{{$value->id}}">{{$value->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group lv-2" style="display:none">
                    <label for="" class="col-sm-2 control-label">二级渠道：</label>

                    <div class="col-sm-4">
                        <select class="form-control" name="" onchange="getLv2(2,3)">
                            <option value="">请选择</option>
                        </select>
                    </div>
                </div>
                <div class="form-group lv-3" style="display:none">
                    <label for="" class="col-sm-2 control-label">三级渠道：</label>

                    <div class="col-sm-4">
                        <select class="form-control" name="" onchange="getLv2(3,4)">
                            <option value="">请选择</option>
                        </select>
                    </div>
                </div>
                <div class="form-group lv-4" style="display:none">
                    <label for="" class="col-sm-2 control-label">四级渠道：</label>

                    <div class="col-sm-4">
                        <select class="form-control" name="" onchange="getLv2(4,5)">
                            <option value="">请选择</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">渠道名称：</label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="name" placeholder="" name="name">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">备注：</label>

                    <div class="col-sm-6">
                        <textarea name="" id="" class='form-control' cols="50" rows="5"></textarea>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">提交</button>
                <a href="javascript:history.go(-1);"><button type="button" class="btn btn-default">取消</button></a>

            </div>
            <!-- /.box-footer -->
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
        //字段验证
        function check(){
            //名称
            if($('#name').val()==''){
                msg('请填写渠道名称');
                return false;
            }
        }


        $('#lv').change(function(){

            //alert($('#lv').val());
            if($('#lv').val()==2){
                $('.lv-1,.lv-2,.lv-3,.lv-4').hide();
                $('.lv-1 select,.lv-2 select,.lv-3 select,.lv-4 select').attr('name','');
                $('.lv-1 select').attr('name','pid');
                $('.lv-1').show();
            }else if($('#lv').val()==3){
                $('.lv-1,.lv-2,.lv-3,.lv-4').hide();
                $('.lv-1 select,.lv-2 select,.lv-3 select,.lv-4 select').attr('name','');
                $('.lv-2 select').attr('name','pid');
                $('.lv-1,.lv-2').show();
            }else if($('#lv').val()==4){
                $('.lv-1,.lv-2,.lv-3,.lv-4').hide();
                $('.lv-1 select,.lv-2 select,.lv-3 select,.lv-4 select').attr('name','');
                $('.lv-3 select').attr('name','pid');
                $('.lv-1,.lv-2,.lv-3').show();
            }else if($('#lv').val()==5){
                $('.lv-1,.lv-2,.lv-3,.lv-4').hide();
                $('.lv-1 select,.lv-2 select,.lv-3 select,.lv-4 select').attr('name','');
                $('.lv-4 select').attr('name','pid');
                $('.lv-1,.lv-2,.lv-3,.lv-4').show();
            }else if($('#lv').val()==1){
                $('.lv-1,.lv-2,.lv-3,.lv-4').hide();
            }
        });

        function getLv2(i,j){
            var pid=$('.lv-'+i+' select option:selected').val();
            $.ajax({
                type:'post',
                dateType:'json',
                data:{
                    pid:pid,
                    _token:"{{csrf_token()}}"
                },
                url:"{{url('admin/channel/lv')}}",
                success:function(data){
                    $('.lv-'+j+' select').empty();
                    $('.lv-'+j+' select').append("<option value=''>请选择</option>");
                    $.each(data,function(k,v){
                        var html="<option value='"+ v.id+"'>"+ v.name+"</option>";
                        $('.lv-'+j+' select').append(html);
                    });

                }
            });
        }

    </script>

@endsection