<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
     use Authenticatable, CanResetPassword;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
   // protected $table='users';
    // protected $fillable = [
    //     'name', 'email', 'password',
    // ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function roles(){
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($role){ //manager role
        if(is_string($role)){
            return $this->roles->contains('name',$role);
        }
        return !! $role->intersect($this->roles)->count();
        // foreach ($role as $r) {
        //     if($this->hasRole($r->name)){
        //         return true;
        //     }
        //     # code...
        // }
        // return false;
    }

    public function assign($role){

        if(is_string($role)){

            return $this->roles()->save( Role::whereName($role)->firstOrFail()           );

        }

        return $this->roles()->save($role);


    }


}
