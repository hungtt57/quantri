<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Permission_Role extends Model
{
    public $timestamps = false;

    protected $table = 'permission_role';

    protected $fillable = array('permission_id', 'role_id');

    public static function permissionsOfRole($id) {
        $permissions = DB::table('permission_role')
                ->join('permissions', 'permission_role.permission_id', '=', 'permissions.id')
                ->where('permission_role.role_id', '=', $id)
                ->get();
        return $permissions;
    }

    public static function rolesOfPermission($id) {
        $roles = DB::table('permission_role')
                ->join('roles', 'permission_role.role_id', '=', 'roles.id')
                ->where('permission_role.permission_id', '=', $id)
                ->get();
        return $roles;
    }
}
