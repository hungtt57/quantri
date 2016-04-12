<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	protected $fillable = [
        'name'
    ];

    public function permissions(){
    	return $this->hasMany(Permission::class);
    }

  	public function assign(Permission $permission){
  		return $this->permissions()->save($permission);
  	}
}
