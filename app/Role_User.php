<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Role_User extends Model
{
    protected $table = 'role_user';

    protected $fillable = array('role_id', 'user_id');

    public static function rolesOfUser($id) {
        $roles = DB::table('role_user')
                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                ->where('role_user.user_id', '=', $id)
                ->get();
        return $roles;
    }

    public static function usersOfRole($id) {
        $users = DB::table('role_user')
                ->join('users', 'role_user.user_id', '=', 'users.id')
                ->where('role_user.role_id', '=', $id)
                ->get();
        return $users;
    }
}
