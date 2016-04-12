<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Permission extends Model
{
    public function roles(){
    	return $this->belongsToMany('App\Role');
    }
    
    public static function updateAll(){
    	DB::table('permissions')->where('parent_id','!=',0)->update(array('active' => 0));
    }
}
