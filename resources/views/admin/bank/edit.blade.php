@extends('admin.layouts.layout')
@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">编辑业务</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" method="post" onsubmit="return check()" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="box-body">
                <div class="form-group lv-1" >
                    <label for="" class="col-sm-2 control-label">业务名称：</label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="post_title" placeholder="请输入业务名称" name="post_title" value="{{$data->post_title}}">
                    </div>
                </div>
                <div class="form-group lv-1" >
                    <label for="" class="col-sm-2 control-label">业务介绍：</label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="post_excerpt" placeholder="请输入一句话介绍" name="post_excerpt" value="{{$data->post_excerpt}}">
                    </div>
                </div>
                <div class="form-group lv-2" >
                    <label for="" class="col-sm-2 control-label">额度范围：</label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="edufanwei" placeholder="请输入额度范围" name="edufanwei" value="{{$data->edufanwei}}">
                    </div>
                </div>
                <div class="form-group lv-3" >
                    <label for="" class="col-sm-2 control-label">费率：</label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="feilv" placeholder="请输入费率" name="feilv" value="{{$data->feilv}}">
                    </div>
                    <select class="form-control" name="fv_unit" id="fv_unit" style="width:60px">
                        <option value="1" @if($data->fv_unit==1) selected @endif>日</option>
                        <option value="2" @if($data->fv_unit==2) selected @endif>月</option>
                    </select>
                </div>
                <div class="form-group lv-4" >
                    <label for="" class="col-sm-2 control-label">期限范围：</label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="qixianfanwei" placeholder="请输入期限范围" name="qixianfanwei" value="{{$data->qixianfanwei}}">
                    </div>
                    <select class="form-control" name="qx_unit" id="qx_unit" style="width:60px">
                        <option value="1" @if($data->qx_unit==1) selected @endif>日</option>
                        <option value="2" @if($data->qx_unit==2) selected @endif>月</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">最快放款：</label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="zuikuaifangkuan" placeholder="请输入最快放款时间" name="zuikuaifangkuan" value="{{$data->zuikuaifangkuan}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">申请条件：</label>

                    <div class="col-sm-6">
                        <textarea name="shenqingtiaojian" id="shenqingtiaojian" class='form-control' cols="50" rows="5" placeholder="请输入申请条件">{{$data->shenqingtiaojian}}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">APP申请地址：</label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="link" placeholder="请输入网址" name="link" value="{{$data->link}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">H5申请地址：</label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="link_h5" placeholder="请输入网址" name="link_h5" value="{{$data->link_h5}}">
                    </div>
                </div>
                {{--<div class="form-group">
                    <label for="" class="col-sm-2 control-label">申请地址：</label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="" placeholder="请输入申请地址" name="">
                    </div>
                </div>--}}

                @foreach($property_type as $value)
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">{{$value->type_name}}：</label>

                        <div class="form-group">
                            <div class="checkbox">
                                @foreach($value->data as $v)
                                <label>
                                    <input type="checkbox" name="{{$value->type_name_en}}[]" value="{{$v->property_id}}"
                                    @foreach($properties as $property)
                                        @if($property->property_id==$v->property_id)
                                            checked
                                        @endif
                                    @endforeach
                                    >{{$v->property_name}}
                                </label>
                                @endforeach
                            </div>

                        </div>
                    </div>
                @endforeach

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">标签：</label>

                    <div class="form-group col-sm-6">
                        <div class="checkbox">
                            @foreach($tags as $item)
                                <label>
                                    <input type="checkbox" name="tags[]" value="{{$item->id}}"
                                        @foreach($business_tags as $business_tag)
                                            @if($business_tag->tag_id==$item->id)
                                                checked
                                            @endif
                                        @endforeach
                                    >{{$item->tag_name}}
                                </label>
                            @endforeach
                        </div>

                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">上传图片：</label>
                    @if($data->smeta!='')
                        <img src="{{asset('upload/'.json_decode($data->smeta)->thumb)}}" class="iconimg" alt="" style="width: 100px;height: 100px;">
                    @else
                        <img src="" class="iconimg" alt="" style="width: 100px;height: 100px;">
                    @endif
                    <div class="upload-div" style="margin-top:-35px;margin-left:40%;">
                        <button type="button" class="btn btn-primary" id="changeImg">点击上传</button>
                    </div>
                    {{--<input type="file" id="exampleInputFile" name="image">--}}
                    <div style="display:none">
                        <input id="fileToUpload" type="file" size="20" name="fileToUpload" class="input">
                        <button id="buttonUpload">上传</button>
                    </div>

                </div>
            </div>
            @if($data->smeta!='')
                <input type="hidden" name="img_path" id="file_url" value="{{json_decode($data->smeta)->thumb}}">
            @else
                <input type="hidden" name="img_path" id="file_url" value="">
            @endif

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
            if($('#post_title').val()==''){
                msg('请输入业务名称');
                return false;
            }
            //介绍
            if($('#post_excerpt').val()==''){
                msg('请输入一句话介绍');
                return false;
            }
            //额度范围
            if($('#edufanwei').val()==''){
                msg('请输入额度范围');
                return false;
            }
            //费率
            if($('#feilv').val()==''){
                msg('请输入费率');
                return false;
            }
            //期限范围
            if($('#qixianfanwei').val()==''){
                msg('请输入期限范围');
                return false;
            }
            //最快放款
            if($('#zuikuaifangkuan').val()==''){
                msg('请输入最快放款时间');
                return false;
            }
            //申请条件
            if($('#shenqingtiaojian').val()==''){
                msg('请输入申请条件');
                return false;
            }
            //申请地址
            if($('#link').val()==''){
                msg('请输入APP申请地址');
                return false;
            }
            if($('#link_h5').val()==''){
                msg('请输入H5申请地址');
                return false;
            }
            //职业身份
            if($("input[name='identity[]']:checked").length==0) {
                msg('请选择职业身份');
                return false;
            }
            //贷款金额
            if($("input[name='money[]']:checked").length==0) {
                msg('请选择贷款金额');
                return false;
            }
            //期限
            if($("input[name='term[]']:checked").length==0) {
                msg('请选择期限');
                return false;
            }
            //贷款分类
            if($("input[name='cate[]']:checked").length==0) {
                msg('请选择期限');
                return false;
            }
            //标签
            if($("input[name='tags[]']:checked").length==0) {
                msg('请选择标签');
                return false;
            }else if($("input[name='tags[]']:checked").length>6){
                msg('最多只能选择6个标签');
                return false;
            }
            //图片
            if($('.iconimg').attr('src')==''){
                msg('请上传图片');
                return false;
            }
        }


        //上传图片
        $(function() {
            $('#changeImg').click(function () {
                $('#fileToUpload').click();
            });
            $('#fileToUpload').bind('change',function () {
                ajaxFileUpload();
            });
        });
        function ajaxFileUpload(){
            //上传文件
            $.ajaxFileUpload({
                data:{
                    _token:'{{csrf_token()}}'
                },
                url:'{{url('/admin/business/img')}}',//处理图片脚本
                secureuri :false,
                fileElementId :'fileToUpload',//file控件id
                dataType : 'json',
                success : function (data){
                    if(data.msg==1){
                        $(".iconimg").attr("src","{{asset('/data/upload/')}}"+data.path);
                        $('#file_url').val(data.path);
                        $('#fileToUpload').bind('change',function () {
                            ajaxFileUpload();
                        });
                        msg('上传成功');
                    }else{
                        msg('上传失败');
                    }

                }
            })
            return false;
        }

    </script>

@endsection