<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\HomeController;
use App\Models\Card;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CardController extends HomeController
{
    public function getList(Request $request){
        $data=new Card();
        //条件筛选
        $keywords=$request->keywords;
        if($keywords!=''){
            $data=$data->where('post_title','like','%'.$keywords.'%');
        }
        //信用卡数据
        $data=$data
            ->where('post_status',1)
            ->orderBy('post_date','desc')
            ->select('id','post_title','post_hits','edufanwei','feilv','qixianfanwei','zuikuaifangkuan','smeta','post_date','link')
            ->paginate(10);

        return view('admin.card.list',compact('data','keywords'));
    }

    public function anyAdd(Request $request){
        if($request->isMethod('post')){
            DB::beginTransaction();
            try {
                //维护信用卡数据
                $data=new Card();
                $data->post_title=$request->post_title;
                $data->edufanwei=$request->edufanwei;
                $data->feilv=$request->feilv;
                $data->qixianfanwei=$request->qixianfanwei;
                $data->zuikuaifangkuan=$request->zuikuaifangkuan;
                $data->shenqingtiaojian=$request->shenqingtiaojian;
                $data->link=$request->link;
                $data->smeta=json_encode(['thumb'=>$request->img_path]);
                $data->post_date=date('Y-m-d H:i:s');
                $data->post_modified=date('Y-m-d H:i:s');
                $data->save();


                DB::commit();

                return view('admin.card.add')->with('msg','添加信用卡成功！');

            } catch (Exception $e){
                DB::rollback();
                throw $e;
            }

        }else{

            return view('admin.card.add');
        }

    }


    public function anyEdit(Request $request){
        $id=$request->id;
        if($request->isMethod('post')){;
            DB::beginTransaction();
            try {
                //维护信用卡数据
                $data=Card::find($id);
                $data->post_title=$request->post_title;
                $data->edufanwei=$request->edufanwei;
                $data->feilv=$request->feilv;
                $data->qixianfanwei=$request->qixianfanwei;
                $data->zuikuaifangkuan=$request->zuikuaifangkuan;
                $data->shenqingtiaojian=$request->shenqingtiaojian;
                $data->link=$request->link;
                $data->smeta=json_encode(['thumb'=>$request->img_path]);
                $data->post_modified=date('Y-m-d H:i:s');
                $data->save();


                DB::commit();

                return Redirect::to('admin/card/list');

            } catch (Exception $e){
                DB::rollback();
                throw $e;
            }

        }else{
            //回显业务数据
            $data=Card::find($id);
            return view('admin.card.edit',compact('data'));
        }

    }

    public function getDelete(Request $request){
        $id=$request->id;
        $business=Card::find($id);
        if($business->delete()){
            return response()->json(['msg'=>'删除成功']);
        }else{
            return response()->json(['msg'=>'删除失败']);
        }

    }

    public function postImg(Request $request){
        $path='./upload/';
        $upFilePath = md5(date('ymdhis').rand(100000,999999)).".jpg";
        $ok=move_uploaded_file($_FILES['fileToUpload']['tmp_name'],$path.$upFilePath);
        if($ok === FALSE){
            echo json_encode(['msg'=>'0','file_url'=>'http://'.$_SERVER['SERVER_NAME'].'/upload/'.$upFilePath,'path'=>$upFilePath]);
        }else{
            echo json_encode(['msg'=>'1','file_url'=>'http://'.$_SERVER['SERVER_NAME'].'/upload/'.$upFilePath,'path'=>$upFilePath]);
        }
    }
}
