<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\HomeController;
use App\Models\Message;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MessageController extends HomeController
{
    public function getList(Request $request){
        $data=new Message();
        $keywords=$request->keywords;
        if($keywords!=''){
            $data=$data->where('message.name','like','%'.$keywords.'%');
        }
        $data=$data
            ->leftjoin('message_type','message.type_id','=','message_type.id')
            ->leftjoin('message_rep','message.rep_id','=','message_rep.id')
            ->leftjoin('message_rem','message.rem_id','=','message_rem.id')
            ->select('message.id as msg_id','message.name','message_type.name as type_name','message_type.icon','amount','repayment_date','message_rep.name as rep_name','message_rem.name as rem_name','remark')
            ->orderBy('message.created_at','desc')
            ->paginate(15);

        return view('admin.message.list',compact('data','keywords'));
    }
}
