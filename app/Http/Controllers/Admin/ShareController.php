<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\HomeController;
use App\Models\Share;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ShareController extends HomeController
{
    public function anyEdit(Request $request){
        if($request->isMethod('post')){
            $data=Share::first();
            $data->share_title=$request->share_title;
            $data->share_content=$request->share_content;
            $data->share_url=$request->share_url;
            $data->bg_img=$request->img_path;
            if($data->save()){
                $data=Share::first();
                return view('admin.share.edit',compact('data'))->with('msg','编辑分享成功！');
            }
        }else{
            $data=Share::first();
            //dd($data);
            return view('admin.share.edit',compact('data'));
        }
    }
}
