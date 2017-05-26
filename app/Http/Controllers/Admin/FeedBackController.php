<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\HomeController;
use App\Models\FeedBack;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class FeedBackController extends HomeController
{
    public function getList(Request $request){
        $data=new FeedBack();
        $keywords=$request->keywords;
        if($keywords!=''){
            $data=$data->where('problem','like','%'.$keywords.'%');
        }
        $data=$data->paginate(15);

        return view('admin.feedback.list',compact('data','keywords'));
    }
}
