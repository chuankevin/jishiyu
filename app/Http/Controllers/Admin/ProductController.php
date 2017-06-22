<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\HomeController;
use App\Models\ProductData;
use App\Models\Products;
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
        $status=isset($request->status) ? $request->status : 1;
        if($status!=''){
            $data=$data->where('status',$status);
        }else{
            $data=$data->where('status',1);
        }
        //业务数据
        $data=$data
            ->orderBy('created_at','desc')
            ->paginate(10);

        return view('admin.product.list',compact('data','keywords','status'));
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
            $data->qx_unit=$request->qx_unit;
            $data->type=$request->type;
            $data->img=$request->img_path;
            $data->data_id=json_encode($request->tags);
            if($data->save()){
                return Redirect::to('admin/product/list');
            }

        }else{
            $product_data=ProductData::get();
            return view('admin.product.add',compact('product_data'));
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
            $data->qx_unit=$request->qx_unit;
            $data->type=$request->type;
            $data->img=$request->img_path;
            $data->data_id=json_encode($request->tags);
            if($data->save()){
                return Redirect::to('admin/product/list');
            }


        }else{
            //回显产品数据
            $data=Products::find($id);
            //资料选项
            $product_data=ProductData::get();
            return view('admin.product.edit',compact('data','product_data'));
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
        $path='./data/upload/products/';
        if(!is_dir($path)){
            mkdir($path);
        }
        $upFilePath = md5(date('ymdhis').rand(100000,999999)).".jpg";
        $ok=move_uploaded_file($_FILES['fileToUpload']['tmp_name'],$path.$upFilePath);

        if($ok === FALSE){
            echo json_encode(['msg'=>'0','path'=>'/products/'.$upFilePath]);
        }else{
            echo json_encode(['msg'=>'1','path'=>'/products/'.$upFilePath]);
        }
    }

}
