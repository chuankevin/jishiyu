<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\HomeController;
use App\Models\AdminUser;
use App\Models\UserRoleDetail;
use App\Models\UserRoles;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class AdminUserController extends HomeController
{
    /**
     * @param Request $request
     * @return mixed
     * 管理员列表
     */
    public function getList(Request $request){

        $data=new AdminUser();
        $data=$data
            ->leftjoin('user_roles','admin_user.id','=','user_roles.userId')
            ->leftjoin('user_role_detail','user_roles.roleId','=','user_role_detail.id')
            ->select('admin_user.*','user_role_detail.name as role_name')
            ->paginate(10);
        return view('admin.adminuser.list',compact('data'));
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws Exception
     * 添加管理员
     */
    public function anyAdd(Request $request){

        if($request->isMethod('post')){
            DB::beginTransaction();
            try {
                //新增管理员
                $data=new AdminUser();
                $data->name=$request->name;
                $data->password=Crypt::encrypt($request->pwd);
                $data->save();
                //绑定角色
                UserRoles::insert(['userId'=>$data->id,'roleId'=>$request->role_id]);

                DB::commit();

                $roles=UserRoleDetail::get();
                return view('admin.adminuser.add',compact('roles'))->with('msg','添加成功');
            } catch (Exception $e){
                DB::rollback();
                throw $e;
            }
        }else{
            //角色数据
            $roles=UserRoleDetail::get();
            return view('admin.adminuser.add',compact('roles'));
        }

    }

    /**
     * @param Request $request
     * @return mixed
     * @throws Exception
     * 编辑管理员
     */
    public function anyEdit(Request $request){

        if($request->isMethod('post')){
            DB::beginTransaction();
            try {
                //编辑管理员
                $data=AdminUser::find($request->id);
                $data->name=$request->name;
                $data->password=Crypt::encrypt($request->pwd);
                $data->save();
                //绑定角色
                UserRoles::where('userId',$request->id)
                    ->update(['roleId'=>$request->role_id]);

                DB::commit();

                return Redirect::to('admin/adminuser/list');
            } catch (Exception $e){
                DB::rollback();
                throw $e;
            }
        }else{
            //管理员数据
            $data=AdminUser::leftjoin('user_roles','admin_user.id','=','user_roles.userId')
                ->select('admin_user.*','user_roles.roleId')
                ->find($request->id);
            $data->password=Crypt::decrypt($data->password);
            //dd($data);
            //角色数据
            $roles=UserRoleDetail::get();
            return view('admin.adminuser.edit',compact('roles','data'));
        }
    }

    /**
     * @param Request $request
     * @return mixed
     * 删除
     */
    public function postDelete(Request $request){
        $data=AdminUser::find($request->id);
        if($data->delete()){
            return response()->json(['msg'=>'删除成功']);
        }else{
            return response()->json(['msg'=>'删除失败']);
        }
    }
}
