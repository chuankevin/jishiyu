<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RoleMenu extends Model
{
    protected $table='role_menus';

    public function userroledetail(){
        return $this->hasOne('App\Models\UserRoleDetail','id','roleId');
    }

    public function rolemenudetail(){
        return $this->hasOne('App\Models\RoleMenuDetail','id','menuId');
    }


    public static function getMenuList($uid){
        return DB::select('SELECT
                            cmf_user_roles.userId,
                            cmf_role_menu_details.menuName,
                            cmf_role_menu_details.category
                            FROM
                            cmf_user_roles
                            INNER JOIN cmf_user_role_detail ON cmf_user_roles.roleId = cmf_user_role_detail.id
                            INNER JOIN cmf_role_menus ON cmf_role_menus.roleId = cmf_user_role_detail.id
                            INNER JOIN cmf_role_menu_details ON cmf_role_menu_details.id = cmf_role_menus.menuId
                            WHERE
                            cmf_user_roles.userId = ?',[$uid]);
    }


    public static function hasMenu($menuList,$menu){
        foreach ($menuList as $row) {
            if($row->menuName==$menu)
                return true;
        }
        return false;
    }


    public static function hasMenuCategory($menuList,$menu,$field){
        foreach ($menuList as $row) {
            if($row->$field==$menu)
                return true;
        }
        return false;
    }
}
