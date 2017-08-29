<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\HomeController;
use App\Models\ProductCate;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class ProductCateController extends HomeController
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 产品分类列表
     */
    public function getList(Request $request){

        $data=new ProductCate();

        //分类数据
        $data=$data->orderBy('list_order')->paginate(15);

        return view('admin.productcate.list',compact('data'));
    }

    /**
     * @param Request $request
     * @return mixed
     * 添加产品分类
     */
    public function anyAdd(Request $request){
        if($request->isMethod('post')){
            $data=new ProductCate();
            $data->cat_name=$request->cat_name;
            $data->list_order=$request->list_order;
            $data->cat_icon=$request->img_path;

            if($data->save()){
                return view('admin.productcate.add')->with('msg','添加产品分类成功');
            }
        }else{
            return view('admin.productcate.add');
        }
    }

    /**
     * @param Request $request
     * @return mixed
     * 编辑产品分类
     */
    public function anyEdit(Request $request){

        if($request->isMethod('post')){

            $data=ProductCate::find($request->id);
            $data->cat_name=$request->cat_name;
            $data->list_order=$request->list_order;
            $data->cat_icon=$request->img_path;

            if($data->save()){
                return Redirect::to('admin/productcate/list');
            }
        }else{
            //banner数据
            $data=ProductCate::where('id',$request->id)->first();

            return view('admin.productcate.edit',compact('data'));
        }
    }

    /**
     * @param Request $request
     * @return mixed
     * 删除产品分类
     */
    public function postDelete(Request $request){
        $id=$request->id;
        $data=ProductCate::find($id);
        if($data->delete()){
            return response()->json(['msg'=>'删除成功']);
        }else{
            return response()->json(['msg'=>'删除失败']);
        }
    }
}
