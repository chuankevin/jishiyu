<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\HomeController;
use App\Models\PushLog;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PushLogController extends HomeController
{
    public function getList(Request $request){
        $data=new PushLog();
        $keywords=$request->keywords;
        if($keywords){
           $data=$data->where('push_mobile','like','%'.$keywords.'%');
        }
        $data=$data->paginate(15);

        return view('admin.pushlog.list',compact('data','keywords'));
    }
}
