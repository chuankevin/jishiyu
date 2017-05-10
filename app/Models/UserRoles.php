<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRoles extends Model
{
    protected $table='user_roles';

    //关联角色表详情
    public function RoleDetail(){
        return $this->hasOne('App\Models\UserRoleDetail','id','roleId');
    }
}
