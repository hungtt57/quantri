<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	  protected $fillable = [
        'name'
    ];

    public function permissions(){
    	return $this->hasMany('App\Permission');
    }

    /**
     * The users that belong to the role.
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

  	public function assign(Permission $permission){
  		return $this->permissions()->save($permission);
  	}
}
