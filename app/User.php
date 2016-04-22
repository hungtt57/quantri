<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'phone', 'address', 'bio', 'avatar',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The roles that belong to the user.
     */
    public function roles(){
        return $this->belongsToMany('App\Role', 'role_user', 'user_id', 'role_id');
    }

    public function hasRole($role){
        if(is_string($role)){
            return $this->roles->contains('name', $role);
        }
        return !! $role->intersect($this->roles)->count();
    }

    // Ham nay chay bi loi quan he trong CSDL, thay the bang ham assignRole()
    // public function assign($role){
    //     if(is_string($role)){
    //         return $this->roles()->save(Role::whereName($role)->firstOrFail());
    //     }
    //     return $this->roles()->save($role);
    // }

    public function assignRole(Role $role){
        return $this->roles()->attach($role->id);
    }

    public function removeRole(Role $role){
        return $this->roles()->detach($role->id);
    }

    public function removeAllRole(){
        return $this->roles()->detach();
    }

    public function socials(){
        return $this->hasMany('App\Social');
    }
}
