<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'key', 'value', 'description', 'type_id'
    ];

    public function setting_group()
    {
        return $this->belongsTo('App\Setting_Group');
    }
}
