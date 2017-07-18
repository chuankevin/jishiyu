<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\HomeController;
use App\Models\BootPage;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BootPageController extends HomeController
{
    public function anyEdit(Request $request){
        if($request->isMethod('post')){
            $data=BootPage::first();
            $data->time=$request->time;
            $data->boot_url=$request->boot_url;
            $data->boot_img=$request->img_path;
            if($data->save()){
                $data=BootPage::first();
                return view('admin.bootpage.edit',compact('data'))->with('msg','编辑启动页成功！');
            }
        }else{
            $data=BootPage::first();
            //dd($data);
            return view('admin.bootpage.edit',compact('data'));
        }
    }
}
