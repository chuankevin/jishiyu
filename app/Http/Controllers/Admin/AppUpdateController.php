<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\HomeController;
use App\Models\AppUpdate;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AppUpdateController extends HomeController
{
    public function anyEdit(Request $request){
        if($request->isMethod('post')){
            $data=AppUpdate::first();
            $data->version=$request->version;
            $data->type=$request->type;
            $data->update_url=$request->update_url;
            if($data->save()){
                $data=AppUpdate::first();
                return view('admin.appupdate.edit',compact('data'))->with('msg','编辑成功！');
            }
        }else{
            $data=AppUpdate::first();
            //dd($data);
            return view('admin.appupdate.edit',compact('data'));
        }
    }
}
