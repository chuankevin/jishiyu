<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\HomeController;
use App\Models\RoleMenu;
use App\Models\RoleMenuDetail;
use App\Models\UserRoleDetail;
use App\Models\UserRoles;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class RoleController extends HomeController
{
    /**
     * @param Request $request
     * @return mixed
     * @throws Exception
     * 添加角色
     */
    public function anyAdd(Request $request){
        if($request->isMethod('post')){
            DB::beginTransaction();
            try {
                //添加角色
                $data=new UserRoleDetail();
                $data->name=$request->role_name;
                $data->save();
                //绑定权限
                foreach($request->menu as $value){
                    RoleMenu::insert(['roleId'=>$data->id,'menuId'=>$value]);
                }

                DB::commit();
                $menus=RoleMenuDetail::get();
                return view('admin.role.add',compact('menus'))->with('msg','添加角色成功');
            } catch (Exception $e){
                DB::rollback();
                throw $e;
            }


        }else{
            $menus=RoleMenuDetail::get();
            return view('admin.role.add',compact('menus'));
        }
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws Exception
     * 编辑角色
     */
    public function anyEdit(Request $request){

        $data=UserRoleDetail::find($request->id);
        if($request->isMethod('post')){
            DB::beginTransaction();
            try {
                //更新角色
                $data->name=$request->role_name;
                $data->save();
                //绑定权限
                RoleMenu::where('roleId',$request->id)->delete();
                foreach($request->menu as $value){
                    RoleMenu::insert(['roleId'=>$request->id,'menuId'=>$value]);
                }

                DB::commit();

                return Redirect::to('admin/role/list');
            } catch (Exception $e){
                DB::rollback();
                throw $e;
            }


        }else{
            $menus=RoleMenuDetail::get();
            $role_menu=RoleMenu::where('roleId',$request->id)->get();
            return view('admin.role.edit',compact('data','menus','role_menu'));
        }
    }

    /**
     * @param Request $request
     * @return mixed
     * 角色列表
     */
    public function getList(Request $request){
        $data=UserRoleDetail::paginate(10);
        return view('admin.role.list',compact('data'));
    }

    /**
     * @param Request $request
     * @return mixed
     * 删除角色
     */
    public function postDelete(Request $request){
        $data=UserRoleDetail::find($request->id);
        if($data->delete()){
            return response()->json(['msg'=>'删除成功']);
        }else{
            return response()->json(['msg'=>'删除失败']);
        }
    }
}
