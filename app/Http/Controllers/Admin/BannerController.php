<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\HomeController;
use App\Models\Banner;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class BannerController extends HomeController
{
    /**
     * @param Request $request
     * @return mixed
     * Banner列表
     */
    public function getList(Request $request){

        $data=new Banner();

        //banner数据
        $data=$data->orderBy('order','desc')->paginate(15);

        return view('admin.banner.list',compact('data'));
    }

    /**
     * @param Request $request
     * @return mixed
     * 添加Banner
     */
    public function anyAdd(Request $request){
        if($request->isMethod('post')){
            $data=new Banner();
            $data->title=$request->title;
            $data->img_url=$request->img_url;
            $data->img=$request->img_path;

            if($data->save()){
                return view('admin.banner.add')->with('msg','添加Banner成功');
            }
        }else{
            return view('admin.banner.add');
        }
    }

    /**
     * @param Request $request
     * @return mixed
     * 编辑Banner
     */
    public function anyEdit(Request $request){

        if($request->isMethod('post')){

            $data=Banner::find($request->id);
            $data->title=$request->title;
            $data->img_url=$request->img_url;
            $data->img=$request->img_path;

            if($data->save()){
                return Redirect::to('admin/banner/list');
            }
        }else{
            //banner数据
            $data=Banner::where('id',$request->id)->first();

            return view('admin.banner.edit',compact('data'));
        }
    }

    /**
     * @param Request $request
     * @return mixed
     * 删除Banner
     */
    public function postDelete(Request $request){
        $id=$request->id;
        $data=Banner::find($id);
        if($data->delete()){
            return response()->json(['msg'=>'删除成功']);
        }else{
            return response()->json(['msg'=>'删除失败']);
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
            echo json_encode(['msg'=>'0','path'=>date('Ymd').'/'.$upFilePath]);
        }else{
            echo json_encode(['msg'=>'1','path'=>date('Ymd').'/'.$upFilePath]);
        }
    }
}
