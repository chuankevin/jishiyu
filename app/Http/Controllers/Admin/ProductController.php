<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\HomeController;
use App\Models\ProCat;
use App\Models\ProductCate;
use App\Models\ProductDetail;
use App\Models\ProductTags;
use App\Models\BusinessPropertyName;
use App\Models\BusinessPropertyType;
use App\Models\ProductData;
use App\Models\ProductProperties;
use App\Models\Products;
use App\Models\Tags;
use App\Models\UserOtherType;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class ProductController extends HomeController
{
    /**
     * @param Request $request
     * @return mixed
     * 产品列表
     */
    public function getList(Request $request){
        $data=new Products();
        //条件筛选
        $keywords=$request->keywords;
        if($keywords!=''){
            $data=$data->where('pro_name','like','%'.$keywords.'%');
        }
        $status=isset($request->post_status) ? $request->post_status : 1;
        if($status!=''){
            $data=$data->where('status',$status);
        }else{
            $data=$data->where('status',1);
        }
        //上架时间筛选
        $start_time=$request->start_time;
        $end_time=$request->end_time;
        if($start_time!=''){
            $data=$data->where('created_at','>=',$start_time);
        }
        if($end_time!=''){
            $end=date('Y-m-d',strtotime($end_time)+3600*24);
            $data=$data->where('created_at','<',$end);
        }
        //业务数据
        $data=$data
            ->orderBy('created_at','desc')
            ->paginate(10);

        return view('admin.product.list',compact('data','keywords','status','start_time','end_time'));
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     * 添加产品
     */
    public function anyAdd(Request $request){
        if($request->isMethod('post')){
            //维护产品数据
            $data=new Products();
            $data->pro_name=$request->pro_name;
            $data->pro_describe=$request->pro_describe;
            $data->pro_link=$request->pro_link;
            $data->edufanwei=$request->edufanwei;
            $data->feilv=$request->feilv;
            $data->fv_unit=$request->fv_unit;
            $data->qixianfanwei=$request->qixianfanwei;
            $data->zuikuaifangkuan=$request->zuikuaifangkuan;
            $data->qx_unit=$request->qx_unit;
            $data->tiaojian=$request->condition;
            $data->api_type=$request->api_type;
            $data->type=$request->type;
            $data->img=$request->img_path;
            $data->data_id=json_encode($request->data_id);
            $data->other_id=json_encode($request->other_id);
            $data->is_new=$request->is_new;
            $data->is_activity=$request->is_activity;

            if($data->save()){
                //产品详情维护
                $product_detail=new ProductDetail();
                $product_detail->pid=$data->id;
                $product_detail->guid=$request->guid;
                $product_detail->loan_type=$request->loan_type;
                $product_detail->group=$request->group;
                $product_detail->check_type=$request->check_type;
                $product_detail->in_account_type=$request->in_account_type;
                $product_detail->in_account=$request->in_account;
                $product_detail->repayment=$request->repayment;
                $product_detail->repay_type=$request->repay_type;
                $product_detail->prepayment=$request->prepayment;
                $product_detail->delinquency=$request->delinquency;
                $product_detail->is_up=$request->is_up;
                $product_detail->platform=$request->platform;
                $product_detail->save();
                //维护产品属性
                $arr=array();//存属性
                $properties=BusinessPropertyType::get();//属性数据
                foreach($properties as $property){
                    $value=$property->type_name_en;
                    $arr[]=$request->$value;
                }
                $product_pro=new ProductProperties();
                foreach($arr as $v){
                    foreach($v as $vv){
                        $product_pro->insert(['business_id'=>$data->id,'property_id'=>$vv]);
                    }
                }
                //维护标签
                $tags=$request->tags;
                foreach ($tags as $tag){
                    ProductTags::insert([
                        'product_id'=>$data->id,
                        'tag_id'=>$tag,
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=>date('Y-m-d H:i:s'),
                    ]);
                }
                //维护分类
                $cats=$request->cat_id;
                foreach($cats as $cat){
                    ProCat::insert([
                        'pid'=>$data->id,
                        'cid'=>$cat,
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=>date('Y-m-d H:i:s'),
                    ]);
                }

                return Redirect::to('admin/product/list');
            }

        }else{
            //产品数据
            $product_data=ProductData::get();
            //其他资料
            $other_type=UserOtherType::get();
            //产品属性
            $property_type=BusinessPropertyType::get();
            foreach($property_type as $value){
                $value['data']=BusinessPropertyName::where('property_type',$value['type_id'])->get();
            }
            //标签
            $tags=Tags::get();
            //产品分类
            $cats=ProductCate::get();
            return view('admin.product.add',compact('product_data','other_type','property_type','tags','cats'));
        }

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     * 编辑产品
     */
    public function anyEdit(Request $request){
        $id=$request->id;
        if($request->isMethod('post')){
            //维护产品数据
            $data=Products::find($id);
            $data->pro_name=$request->pro_name;
            $data->pro_describe=$request->pro_describe;
            $data->pro_link=$request->pro_link;
            $data->edufanwei=$request->edufanwei;
            $data->feilv=$request->feilv;
            $data->fv_unit=$request->fv_unit;
            $data->qixianfanwei=$request->qixianfanwei;
            $data->zuikuaifangkuan=$request->zuikuaifangkuan;
            $data->qx_unit=$request->qx_unit;
            $data->tiaojian=$request->condition;
            $data->api_type=$request->api_type;
            $data->type=$request->type;
            $data->img=$request->img_path;
            $data->data_id=json_encode($request->data_id);
            $data->other_id=json_encode($request->other_id);
            $data->is_new=$request->is_new;
            $data->is_activity=$request->is_activity;
            if($data->save()){
                //产品详情维护
                $product_detail=ProductDetail::where('pid',$data->id)->first();
                if(!$product_detail){
                    $product_detail=new ProductDetail();
                    $product_detail->pid=$data->id;
                    $product_detail->save();
                }
                $product_detail->guid=$request->guid;
                $product_detail->loan_type=$request->loan_type;
                $product_detail->group=$request->group;
                $product_detail->check_type=$request->check_type;
                $product_detail->in_account_type=$request->in_account_type;
                $product_detail->in_account=$request->in_account;
                $product_detail->repayment=$request->repayment;
                $product_detail->repay_type=$request->repay_type;
                $product_detail->prepayment=$request->prepayment;
                $product_detail->delinquency=$request->delinquency;
                $product_detail->is_up=$request->is_up;
                $product_detail->platform=$request->platform;
                $product_detail->save();
                //维护产品属性
                $arr=array();//存属性
                $properties=BusinessPropertyType::get();//属性数据
                foreach($properties as $property){
                    $value=$property->type_name_en;
                    $arr[]=$request->$value;
                }
                //维护属性数据
                ProductProperties::where('business_id',$id)->delete();
                $product_pro=new ProductProperties();
                foreach($arr as $v){
                    foreach($v as $vv){
                        $product_pro->insert(['business_id'=>$id,'property_id'=>$vv]);
                    }
                }
                //维护标签
                ProductTags::where('product_id',$id)->delete();
                $tags=$request->tags;
                foreach ($tags as $tag){
                    ProductTags::insert([
                        'product_id'=>$data->id,
                        'tag_id'=>$tag,
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=>date('Y-m-d H:i:s'),
                    ]);
                }
                //维护分类
                ProCat::where('pid',$id)->delete();
                $cats=$request->cat_id;
                foreach($cats as $cat){
                    ProCat::insert([
                        'pid'=>$data->id,
                        'cid'=>$cat,
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=>date('Y-m-d H:i:s'),
                    ]);
                }

                return Redirect::to('admin/product/list');
            }


        }else{
            //回显产品数据
            $data=Products::leftjoin('product_detail','product_detail.pid','=','products.id')
                ->where('products.id',$id)
                ->first();
            //资料选项
            $product_data=ProductData::get();
            //其他资料选项
            $other_type=UserOtherType::get();
            //产品属性
            $property_type=BusinessPropertyType::get();
            foreach($property_type as $value){
                $value['data']=BusinessPropertyName::where('property_type',$value['type_id'])->get();
            }
            //产品属性关联数据
            $properties=ProductProperties::where('business_id',$id)->get();
            //标签
            $tags=Tags::get();
            $product_tags=ProductTags::where('product_id',$id)->get();
            //产品分类
            $cats=ProductCate::get();
            $pro_cats=ProCat::where('pid',$id)->get();

            return view('admin.product.edit',compact('data','product_data','other_type','property_type','properties','tags','product_tags','cats','pro_cats'));
        }

    }

    /**
     * @param Request $request
     * @return mixed
     * 删除业务
     */
    public function getDelete(Request $request){
        $id=$request->id;
        $data=Products::find($id);
        if($data->delete()){
            return response()->json(['msg'=>'删除成功']);
        }else{
            return response()->json(['msg'=>'删除失败']);
        }

    }

    /**
     * @param Request $request
     * 排序
     */
    public function getOrder(Request $request){
        $id=$request->id;
        $order=$request->order;
        $data=Products::find($id);
        $data->order=$order;
        $data->save();

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 产品上下架
     */
    public function getUpdate(Request $request){
        $id=$request->id;
        $status=$request->status;
        $data=Products::find($id);
        if($status==0){
            $data->status=1;
            if($data->save()){
                return response()->json(['msg'=>'上架成功']);
            }else{
                return response()->json(['msg'=>'上架失败']);
            }
        }elseif ($status==1){
            $data->status=0;
            $data->updated_at=date('Y-m-d H:i:s');
            if($data->save()){
                return response()->json(['msg'=>'下架成功']);
            }else{
                return response()->json(['msg'=>'下架失败']);
            }
        }
    }

    /**
     * @param Request $request
     * 上传图片
     */
    public function postImg(Request $request){
        $path='./upload/'.date('Ymd').'/';
        if(!is_dir($path)){
            mkdir($path);
        }
        $upFilePath = md5(date('ymdhis').rand(100000,999999)).".jpg";
        $ok=move_uploaded_file($_FILES['fileToUpload']['tmp_name'],$path.$upFilePath);

        if($ok === FALSE){
            echo json_encode(['msg'=>'0','path'=>'/'.date('Ymd').'/'.$upFilePath]);
        }else{
            echo json_encode(['msg'=>'1','path'=>'/'.date('Ymd').'/'.$upFilePath]);
        }
    }

}
