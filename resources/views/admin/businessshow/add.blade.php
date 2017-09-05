@extends('admin.layouts.layout')
@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">H5展示产品</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" method="post" onsubmit="return check()">
            {{csrf_field()}}
            <div class="box-body" style="margin-left: 30px">

                <div class="form-group">

                        <div class="checkbox">
                            @foreach($data as $key=>$val)
                            <label style="padding: 20px;">
                                <input type="checkbox" name="business_id[]" value="{{$val->id}}"
                                       @if(in_array($val->id,$business_id))
                                           checked
                                       @endif
                                >
                                {{$val->post_title}}
                            </label>
                            @endforeach
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