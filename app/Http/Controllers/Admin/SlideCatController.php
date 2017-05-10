<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\HomeController;
use App\Models\SlideCat;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class SlideCatController extends HomeController
{
    /**
     * @param Request $request
     * @return mixed
     * 分类列表
     */
    public function getList(Request $request){
        $data=new SlideCat();
        $data=$data->orderBy('cid','desc')->paginate(10);
        return view('admin.slidecat.list',compact('data'));
    }

    /**
     * @param Request $request
     * @return mixed
     * 添加分类
     */
    public function anyAdd(Request $request){
        if($request->isMethod('post')){
            $data=new SlideCat();
            $data->cat_name=$request->cat_name;
            $data->cat_idname=$request->cat_idname;
            $data->cat_remark=$request->cat_remark;
            if($data->save()){
                return view('admin.slidecat.add')->with('msg','添加Banner分类成功');
            }
        }else{
            return view('admin.slidecat.add');
        }
    }

    /**
     * @param Request $request
     * @return mixed
     * 编辑分类
     */
    public function anyEdit(Request $request){


        if($request->isMethod('post')){
            $cat_name=$request->cat_name;
            $cat_idname=$request->cat_idname;
            $cat_remark=$request->cat_remark;
            $data=SlideCat::where('cid',$request->id)
                ->update(['cat_name'=>$cat_name,'cat_idname'=>$cat_idname,'cat_remark'=>$cat_remark]);

            if($data!==false){
                return Redirect::to('admin/slidecat/list');
            }
        }else{
            $data=SlideCat::where('cid',$request->id)->first();
            return view('admin.slidecat.edit',compact('data'));
        }
    }

    /**
     * @param Request $request
     * @return mixed
     * 删除分类
     */
    public function postDelete(Request $request){
        $id=$request->id;
        $data=SlideCat::where('cid',$id);
        if($data->delete()){
            return response()->json(['msg'=>'删除成功']);
        }else{
            return response()->json(['msg'=>'删除失败']);
        }
    }
}
