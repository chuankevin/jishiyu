<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\HomeController;
use App\Models\Comment;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CommentController extends HomeController
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 评论列表
     */
    public function getList(Request $request){
        $data=new Comment();
        //条件筛选
        $start_time=$request->start_time ? $request->start_time : date('Y-m-d');
        $end_time=$request->end_time ? $request->end_time : date("Y-m-d");

        //时间筛选
        if($start_time!=''){
            $data=$data->where('comment.created_at','>=',$start_time);
        }
        if($end_time!=''){
            $end=date('Y-m-d',strtotime($end_time)+3600*24);
            $data=$data->where('comment.created_at','<=',$end);
        }

        $data=$data
            ->select('comment.id','users.mobile','products.pro_name','comment.score','comment','comment.created_at','is_hide')
            ->leftjoin('users','users.id','=','comment.uid')
            ->leftjoin('products','products.id','=','comment.pid')
            ->orderBy('created_at','desc')
            ->paginate(15);
        //dd($data);

        return view('admin.comment.list',compact('data','start_time','end_time'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 评论详情
     */
    public function getDetail(Request $request){
        //接收参数
        $id=$request->id;
        $comment=Comment::select('comment.id','users.mobile','products.pro_name','comment.score','comment','comment.created_at','is_hide')
            ->leftjoin('users','users.id','=','comment.uid')
            ->leftjoin('products','products.id','=','comment.pid')
            ->where('comment.id',$id)
            ->first();
        return view('admin.comment.detail',compact('comment'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 隐藏评论
     */
    public function postHide(Request $request){
        //接收参数
        $id=$request->id;
        $is_hide=$request->is_hide;
        //更新数据
        $comment=Comment::find($id);
        if($is_hide==0){
            $comment->is_hide=1;
            $comment->save();
            return response()->json(['msg'=>'隐藏成功']);
        }elseif ($is_hide==1){
            $comment->is_hide=0;
            $comment->save();
            return response()->json(['msg'=>'显示成功']);
        }
    }
}
