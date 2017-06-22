<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\HomeController;
use App\Models\Bank;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BankController extends HomeController
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 银行列表
     */
    public function getList(Request $request){
        $data=new Bank();
        $data=$data->orderBy('created_at','desc')->paginate(15);
        return view('admin.bank.list',compact('data'));
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 添加银行
     */
    public function anyAdd(Request $request){
        if($request->isMethod('post')){

            $data=new Bank();
            $data->name=$request->name;
            $data->describe=$request->describe;
            $data->link=$request->link;
            $data->icon=$request->img_path;
            if($data->save()){
                return view('admin.bank.add')->with('msg','添加银行成功！');
            }
        }else{
            return view('admin.bank.add');
        }

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 编辑银行
     */
    public function anyEdit(Request $request){
        if($request->isMethod('post')){

        }else{
            return view('admin.bank.edit');
        }

    }

    /**
     * @param Request $request
     * 图片上传
     */
    public function postImg(Request $request){
        $path='./data/upload/bank/';
        $upFilePath = md5(date('ymdhis').rand(100000,999999)).".jpg";
        $ok=move_uploaded_file($_FILES['fileToUpload']['tmp_name'],$path.$upFilePath);

        if($ok === FALSE){
            echo json_encode(['msg'=>'0','path'=>'/bank/'.$upFilePath]);
        }else{
            echo json_encode(['msg'=>'1','path'=>'/bank/'.$upFilePath]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 删除银行
     */
    public function getDelete(Request $request){
        $id=$request->id;
        $data=Bank::find($id);
        if($data->delete()){
            return response()->json(['msg'=>'删除成功']);
        }else{
            return response()->json(['msg'=>'删除失败']);
        }
    }

}
