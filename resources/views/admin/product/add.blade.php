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
                        <input type="text" class="form-control" id="pro_name" placeholder="请输入产品名称" name="pro_name">
                    </div>
                </div>
                <div class="form-group lv-1" >
                    <label for="" class="col-sm-2 control-label">产品描述：</label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="pro_describe" placeholder="请输入产品描述" name="pro_describe">
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">产品链接：</label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="pro_link" placeholder="请输入产品链接" name="pro_link">
                    </div>
                </div>

                <div class="form-group lv-2" >
                    <label for="" class="col-sm-2 control-label">额度范围：</label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="edufanwei" placeholder="请输入额度范围" name="edufanwei">
                    </div>
                </div>
                <div class="form-group lv-3 " >
                    <label for="" class="col-sm-2 control-label">费率：</label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="feilv" placeholder="请输入费率" name="feilv">
                    </div>
                    <select class="form-control" name="fv_unit" id="fv_unit" style="width:60px">
                        <option value="1">日</option>
                        <option value="2">月</option>
                    </select>
                </div>
                <div class="form-group lv-4" >
                    <label for="" class="col-sm-2 control-label">期限范围：</label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="qixianfanwei" placeholder="请输入期限范围" name="qixianfanwei">
                    </div>
                    <select class="form-control" name="qx_unit" id="qx_unit" style="width:60px">
                        <option value="1">日</option>
                        <option value="2">月</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">最快放款：</label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="zuikuaifangkuan" placeholder="请输入最快放款时间" name="zuikuaifangkuan">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">申请条件：</label>

                    <div class="col-sm-6">
                        <textarea name="condition" id="condition" class='form-control' cols="50" rows="5" placeholder="请输入申请条件"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">新品或推荐：</label>

                    <div class="form-group col-sm-6">
                        <div class="radio">
                            <label>
                                <input type="radio" name="is_new" value="/20170904/xinpin.png" checked>新品
                            </label>
                            <label>
                                <input type="radio" name="is_new" value="/20170904/tuijian.png">推荐
                            </label>
                        </div>

                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">是否活动：</label>

                    <div class="form-group col-sm-6">
                        <div class="radio">
                            <label>
                                <input type="radio" name="is_activity" value="/20170904/huodong.png" checked>是
                            </label>
                            <label>
                                <input type="radio" name="is_activity" value="">否
                            </label>
                        </div>

                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">产品分类：</label>

                    <div class="form-group col-sm-6">
                        <div class="checkbox">
                            @foreach($cats as $cat)
                                <label>
                                    <input type="checkbox" name="cat_id[]" value="{{$cat->id}}">{{$cat->cat_name}}
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
                                        <input type="checkbox" name="{{$value->type_name_en}}[]" value="{{$v->property_id}}">{{$v->property_name}}
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
                                    <input type="checkbox" name="tags[]" value="{{$item->id}}">{{$item->tag_name}}
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
                                    <input type="checkbox" name="data_id[]" value="{{$item->id}}">{{$item->data_name}}
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
                                    <input class="other-{{$item->default}}" type="checkbox" name="other_id[]" onclick="selectType(this)" value="{{$item->id}}">{{$item->name}}
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
                                <input type="radio" name="type" value="1" checked>好评推荐
                            </label>
                            <label>
                                <input type="radio" name="type" value="2">急速放款
                            </label>
                        </div>

                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">API对接类型：</label>

                    <div class="form-group col-sm-6">
                        <div class="radio">
                            <label>
                                <input type="radio" name="api_type" value="1" checked>H5链接
                            </label>
                            <label>
                                <input type="radio" name="api_type" value="2">免登录
                            </label>
                            <label>
                                <input type="radio" name="api_type" value="3">全流程
                            </label>
                        </div>

                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">上传图片：</label>
                    <img src="" class="iconimg" alt="" style="width: 100px;height: 100px;">
                    <div class="upload-div" style="margin-top:-16px;margin-left:40%;">
                        <button type="button" class="btn btn-primary" id="changeImg">点击上传</button>
                    </div>
                    {{--<input type="file" id="exampleInputFile" name="image">--}}
                    <div style="display:none">
                        <input id="fileToUpload" type="file" size="20" name="fileToUpload" class="input">
                        <button id="buttonUpload">上传</button>
                    </div>

                </div>
                <hr>

                <div class="form-group lv-1" >
                    <label for="" class="col-sm-2 control-label">新手指导：</label>

                    <div class="col-sm-6">
                        <textarea name="guid" id="guid" class='form-control' cols="50" rows="5" placeholder="请输入新手指导"></textarea>
                    </div>
                </div>
                <div class="form-group lv-1" >
                    <label for="" class="col-sm-2 control-label">贷款类型：</label>

                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="loan_type" placeholder="请输入贷款类型" name="loan_type">
                    </div>
                </div>
                <div class="form-group lv-1" >
                    <label for="" class="col-sm-2 control-label">面向人群：</label>

                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="group" placeholder="请输入面向人群" name="group">
                    </div>
                </div>
                <div class="form-group lv-1" >
                    <label for="" class="col-sm-2 control-label">审核方式：</label>

                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="check_type" placeholder="请输入审核方式" name="check_type">
                    </div>
                </div>
                <div class="form-group lv-1" >
                    <label for="" class="col-sm-2 control-label">到账方式：</label>

                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="in_account_type" placeholder="请输入到账方式" name="in_account_type">
                    </div>
                </div>
                <div class="form-group lv-1" >
                    <label for="" class="col-sm-2 control-label">实际到账：</label>

                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="in_account" placeholder="请输入实际到账" name="in_account">
                    </div>
                </div>
                <div class="form-group lv-1" >
                    <label for="" class="col-sm-2 control-label">还款途径：</label>

                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="repayment" placeholder="请输入还款途径" name="repayment">
                    </div>
                </div>
                <div class="form-group lv-1" >
                    <label for="" class="col-sm-2 control-label">还款方式：</label>

                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="repay_type" placeholder="请输入还款方式" name="repay_type">
                    </div>
                </div>
                <div class="form-group lv-1" >
                    <label for="" class="col-sm-2 control-label">提前还款：</label>

                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="prepayment" placeholder="请输入提前还款" name="prepayment">
                    </div>
                </div>
                <div class="form-group lv-1" >
                    <label for="" class="col-sm-2 control-label">逾期还款：</label>

                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="delinquency" placeholder="请输入逾期还款" name="delinquency">
                    </div>
                </div>
                <div class="form-group lv-1" >
                    <label for="" class="col-sm-2 control-label">能否提额：</label>

                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="is_up" placeholder="请输入能否提额" name="is_up">
                    </div>
                </div>
                <div class="form-group lv-1" >
                    <label for="" class="col-sm-2 control-label">所属平台：</label>

                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="platform" placeholder="请输入所属平台" name="platform">
                    </div>
                </div>

            </div>
            <input type="hidden" name="img_path" id="file_url" value="">
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
                msg('请输入最快放款');
                return false;
            }
            //申请条件
            if($('#condition').val()==''){
                msg('请输入申请条件');
                return false;
            }
            //产品分类
            if($("input[name='cat_id[]']:checked").length==0) {
                msg('请选择产品分类');
                return false;
            }
            //标签
            if($("input[name='tags[]']:checked").length==0) {
                msg('请选择标签');
                return false;
            }
            //认证资料
            if($("input[name='data_id[]']:checked").length==0) {
                msg('请选择认证资料');
                return false;
            }
            //其他认证资料
            if($("input[name='other_id[]']:checked").length==0) {
                msg('请选择其他认证资料');
                return false;
            }
            /*//新手指导
            if($('#guid').val()==''){
                msg('请输入新手指导');
                return false;
            }
            //贷款类型
            if($('#loan_type').val()==''){
                msg('请输入贷款类型');
                return false;
            }
            //面向人群
            if($('#group').val()==''){
                msg('请输入面向人群');
                return false;
            }
            //审核方式
            if($('#check_type').val()==''){
                msg('请输入审核方式');
                return false;
            }
            //到账方式
            if($('#in_account_type').val()==''){
                msg('请输入到账方式');
                return false;
            }
            //实际到账
            if($('#in_account').val()==''){
                msg('请输入实际到账');
                return false;
            }
            //还款途径
            if($('#repayment').val()==''){
                msg('请输入还款途径');
                return false;
            }
            //还款方式
            if($('#repay_type').val()==''){
                msg('请输入还款方式');
                return false;
            }
            //提前还款
            if($('#prepayment').val()==''){
                msg('请输入提前还款');
                return false;
            }
            //逾期还款
            if($('#delinquency').val()==''){
                msg('请输入逾期还款');
                return false;
            }
            //能否提额
            if($('#is_up').val()==''){
                msg('请输入能否提额');
                return false;
            }
            //平台
            if($('#platform').val()==''){
                msg('请输入所属平台');
                return false;
            }*/

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