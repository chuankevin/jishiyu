<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\HomeController;
use App\Models\Business;
use App\Models\BusinessShow;
use App\Models\Products;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BusinessShowController extends HomeController
{
    public function anyAdd(Request $request){
        $model=BusinessShow::first();
        $data=Business::where('post_status',1)
            ->select('post_title','id')
            ->get();


        if($request->isMethod('post')){
            $model->business_id=json_encode($request->business_id);
            if($model->save()){
                $business_id=json_decode($model->business_id);
                return view('admin.businessshow.add',compact('data','business_id'));
            }

        }else{
            $business_id=json_decode($model->business_id);
            return view('admin.businessshow.add',compact('data','business_id'));
        }

    }
}
