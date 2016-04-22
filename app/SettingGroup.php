<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SettingGroup extends Model
{
    protected $table = 'setting_groups';
    
    protected $fillable = array('parent_id', 'key', 'name', 'description');

    public function settings(){
    	return $this->hasMany('App\Setting');
    }
}

