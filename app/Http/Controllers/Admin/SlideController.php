<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\HomeController;
use App\Models\Slide;
use App\Models\SlideCat;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class SlideController extends HomeController
{
    /**
     * @param Request $request
     * @return mixed
     * Banner列表
     */
    public function getList(Request $request){

        $data=new Slide();
        //条件筛选
        $cid=$request->cid;
        if($cid!=''){
            $data=$data->where('slide_cid',$cid);
        }
        //banner数据
        $data=$data->orderBy('slide_id','desc')->paginate(10);
        //分类数据
        $cats=SlideCat::get();
        return view('admin.slide.list',compact('data','cats','cid'));
    }

    /**
     * @param Request $request
     * @return mixed
     * 添加Banner
     */
    public function anyAdd(Request $request){
        if($request->isMethod('post')){
            $data=new Slide();
            $data->slide_cid=$request->cid;
            $data->slide_name=$request->slide_name;
            $data->slide_pic=$request->img_path;
            $data->slide_url=$request->slide_url;
            $data->slide_des=$request->slide_des;
            $data->slide_content=$request->slide_content;
            if($data->save()){
                //分类数据
                $cats=SlideCat::get();
                return view('admin.slide.add',compact('cats'))->with('msg','添加Banner成功');
            }
        }else{
            //分类数据
            $cats=SlideCat::get();
            return view('admin.slide.add',compact('cats'));
        }
    }

    /**
     * @param Request $request
     * @return mixed
     * 编辑Banner
     */
    public function anyEdit(Request $request){

        if($request->isMethod('post')){
            $slide_cid=$request->cid;
            $slide_name=$request->slide_name;
            $slide_pic=$request->img_path;
            $slide_url=$request->slide_url;
            $slide_des=$request->slide_des;
            $slide_content=$request->slide_content;
            $data=Slide::where('slide_id',$request->id)
                ->update([
                    'slide_cid'=>$slide_cid,
                    'slide_name'=>$slide_name,
                    'slide_pic'=>$slide_pic,
                    'slide_url'=>$slide_url,
                    'slide_des'=>$slide_des,
                    'slide_content'=>$slide_content
                ]);
            if($data!==false){
                return Redirect::to('admin/slide/list');
            }
        }else{
            //分类数据
            $cats=SlideCat::get();
            //banner数据
            $data=Slide::where('slide_id',$request->id)->first();

            return view('admin.slide.edit',compact('cats','data'));
        }
    }

    /**
     * @param Request $request
     * @return mixed
     * 删除Banner
     */
    public function postDelete(Request $request){
        $id=$request->id;
        $data=Slide::where('slide_id',$id);
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
            echo json_encode(['msg'=>'0','path'=>'/upload/'.date('Ymd').'/'.$upFilePath]);
        }else{
            echo json_encode(['msg'=>'1','path'=>'/upload/'.date('Ymd').'/'.$upFilePath]);
        }
    }

}
