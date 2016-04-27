<?php

use Illuminate\Database\Seeder;
use App\GroupSetting;

class GroupSettingsTableSeeder extends Seeder
{
    public function run()
    {
        $groupSystem = new GroupSetting();
        $groupSystem->key = 'system';
        $groupSystem->name = 'System';
        $groupSystem->order = 1;
        $groupSystem->save();

        $groupOther = new GroupSetting();
        $groupOther->key = 'other';
        $groupOther->name = 'Other';
        $groupOther->order = 2;
        $groupOther->save();

        $typeApp = new GroupSetting();
        $typeApp->parent_id = 1;
        $typeApp->key = 'app';
        $typeApp->name = 'App';
        $typeApp->order = 1;
        $typeApp->save();

        $typeCss = new GroupSetting();
        $typeCss->parent_id = 1;
        $typeCss->key = 'css';
        $typeCss->name = 'CSS';
        $typeCss->order = 2;
        $typeCss->save();
        
        $typeJs = new GroupSetting();
        $typeJs->parent_id = 1;
        $typeJs->key = 'javascript';
        $typeJs->name = 'Java Script';
        $typeJs->order = 3;
        $typeJs->save();
    }
}
