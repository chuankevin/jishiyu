@extends('admin.layouts.layout')
@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">添加产品</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" method="post" onsubmit="return check()" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="box-body">
                <div class="form-group lv-1" >
                    <label for="" class="col-sm-2 control-label">产品名称：</label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="pro_name" placeholder="请输入产品名称" name="pro_name" value="{{$data->pro_name}}">
                    </div>
                </div>
                <div class="form-group lv-1" >
                    <label for="" class="col-sm-2 control-label">产品描述：</label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="pro_describe" placeholder="请输入产品描述" name="pro_describe" value="{{$data->pro_describe}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">产品链接：</label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="pro_link" placeholder="请输入产品链接" name="pro_link" value="{{$data->pro_link}}">
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
                        <textarea name="condition" id="condition" class='form-control' cols="50" rows="5" placeholder="请输入申请条件">{{$data->tiaojian}}</textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">产品分类：</label>

                    <div class="form-group col-sm-6">
                        <div class="checkbox">
                            @foreach($cats as $cat)
                                <label>
                                    <input type="checkbox" name="cat_id[]" value="{{$cat->id}}"
                                               @if($data->cat_id==$cat->id)
                                                    checked
                                               @endif
                                           @foreach($pro_cats as $pro_cat)
                                               @if($pro_cat->cid==$cat->id)
                                                    checked
                                               @endif
                                           @endforeach
                                    >{{$cat->cat_name}}
                                </label>
                            @endforeach
                        </div>

                    </div>
                </div>

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
                                           @foreach($product_tags as $product_tag)
                                           @if($product_tag->tag_id==$item->id)
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
                    <label for="" class="col-sm-2 control-label">认证资料：</label>

                    <div class="form-group col-sm-6">
                        <div class="checkbox">
                            @foreach($product_data as $item)
                                <label>
                                    <input type="checkbox" name="data_id[]" value="{{$item->id}}"
                                           @if($data->data_id)
                                                @if(in_array($item->id,json_decode($data->data_id)))
                                                    checked
                                                @endif
                                           @endif
                                    >{{$item->data_name}}
                                </label>
                            @endforeach
                        </div>

                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">其他认证资料：</label>

                    <div class="form-group col-sm-6">
                        <div class="checkbox">
                            @foreach($other_type as $item)
                                <label>
                                    <input class="other-{{$item->default}}" type="checkbox" name="other_id[]" onclick="selectType(this)" value="{{$item->id}}"
                                           @if($data->other_id)
                                                @if(in_array($item->id,json_decode($data->other_id)))
                                                    checked
                                                @endif
                                            @endif
                                    >{{$item->name}}
                                </label>
                            @endforeach
                        </div>

                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">产品类型：</label>

                    <div class="form-group col-sm-6">
                        <div class="radio">
                            <label>
                                <input type="radio" name="type" value="1" @if ($data->type==1) checked @endif >好评推荐
                            </label>
                            <label>
                                <input type="radio" name="type" value="2" @if ($data->type==2) checked @endif>急速放款
                            </label>
                        </div>

                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">API对接类型：</label>

                    <div class="form-group col-sm-6">
                        <div class="radio">
                            <label>
                                <input type="radio" name="api_type" value="1" @if ($data->api_type==1) checked @endif>H5链接
                            </label>
                            <label>
                                <input type="radio" name="api_type" value="2" @if ($data->api_type==2) checked @endif>免登录
                            </label>
                            <label>
                                <input type="radio" name="api_type" value="3" @if ($data->api_type==3) checked @endif>全流程
                            </label>
                        </div>

                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">上传图片：</label>
                    <img src="{{asset('/upload/'.$data->img)}}" class="iconimg" alt="" style="width: 100px;height: 100px;">
                    <div class="upload-div" style="margin-top:-16px;margin-left:40%;">
                        <button type="button" class="btn btn-primary" id="changeImg">点击上传</button>
                    </div>
                    {{--<input type="file" id="exampleInputFile" name="image">--}}
                    <div style="display:none">
                        <input id="fileToUpload" type="file" size="20" name="fileToUpload" class="input">
                        <button id="buttonUpload">上传</button>
                    </div>

                </div>
            </div>
            <input type="hidden" name="img_path" id="file_url" value="{{$data->img}}">
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
        //选中方法
        function selectType(obj){
            var classname=obj.className;
            if(classname!="other-"){
                if(obj.checked){
                    $('.'+classname).prop("checked",true);
                }else{
                    $('.'+classname).prop("checked",false);
                }
            }
        }
        //字段验证
        function check(){
            //名称
            if($('#pro_name').val()==''){
                msg('请输入产品名称');
                return false;
            }
            //描述
            if($('#pro_describe').val()==''){
                msg('请输入产品描述');
                return false;
            }
            //产品链接
            if($('#pro_link').val()==''){
                msg('请输入产品链接');
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
                url:'{{url('/admin/product/img')}}',//处理图片脚本
                secureuri :false,
                fileElementId :'fileToUpload',//file控件id
                dataType : 'json',
                success : function (data){
                    if(data.msg==1){
                        $(".iconimg").attr("src","{{asset('/upload/')}}"+"/"+data.path);
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