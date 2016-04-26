<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Role;
use File;
use Image;
use App\Setting;
use App\GroupSetting;
use App\Http\Requests\SettingRequest;
use App\Http\Requests\GroupSettingRequest;

class SettingController extends Controller
{
    public function index($key = null){
      $groups = GroupSetting::where('parent_id', 0)->orderBy('order', 'ASC')->get();

      $types = GroupSetting::where('parent_id', 1)->orderBy('order', 'ASC')->get();
      
      return view('admin.pages.setting.index', array('groups' => $groups, 'types' => $types, 'menuActive' => 'setting'));
    }

    public function add(){
      return view('admin.pages.setting.add');
    }

    public function store(SettingRequest $request){
      
    }

    public function edit($id){
      return view('admin.pages.setting.edit', array('menuActive' => 'setting'));
    }

    public function update($id, SettingRequest $request){
        
    }
   
    public function showGeneral(){
        $roles = Role::all();
        return view('admin.pages.setting.general', array('roles' => $roles, 'menuActive' => 'Setting General'));
    }

    public function updateGeneral(Request $request){
       $arraySetting = config('setting');

       $default_role_name = $request->default_role;
       $date_format = $request->date_format;
       $time_format = $request->time_format;
       $timezone = $request->timezone;
       $arraySetting['default_role'] = $default_role_name;
       $arraySetting['date_format'] = $date_format;
       $arraySetting['time_format'] = $time_format;
       $arraySetting['timezone'] = $timezone;

       $email = $request->email;
       if($email){
           $arraySetting['email'] = $email;
       }

       $lang = $request->lang;
       if($lang){
           $arraySetting['lang'] = $lang;
       }
       
       $logo=$request->file('logo');
       if($logo){
          $filename = 'logo'.'.' . $logo->getClientOriginalExtension();
          $path = public_path().'/'. $filename;
          Image::make($logo->getRealPath())->resize(110, 24)->save($path);
          $logo='public/'.$filename;
        }
        $arraySetting['logo'] = $logo;

        $data = var_export($arraySetting, 1);

        if(File::put(base_path() . '/config/setting.php', "<?php\n return $data ;")) {
          return redirect('setting-general')->with(['flash_message' => 'Đã lưu cài đặt!', 'message_level' => 'success', 'message_icon' => 'check']);
        }
    }

    public function groupIndex(){
      $groups = GroupSetting::where('parent_id', 0)->orderBy('order', 'ASC')->get();
      return view('admin.pages.setting.group.index', array('groups' => $groups, 'menuActive' => 'setting'));
    }

    public function groupAdd(){
      return view('admin.pages.setting.group.add');
    }

    public function groupStore(GroupSettingRequest $request){
      $group = GroupSetting::create($request->all());
      return redirect('setting/group')->with(['flash_message' => 'Đã thêm nhóm cài đặt!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    public function groupEdit($id){
      $group = GroupSetting::findOrFail($id);
      return view('admin.pages.setting.group.edit', array('group' => $group, 'menuActive' => 'setting'));
    }

    public function groupUpdate($id, GroupSettingRequest $request){
       GroupSetting::findOrFail($id)->update($request->all());
       return redirect('setting/group')->with(['flash_message' => 'Đã lưu nhóm cài đặt!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    public function typeIndex(){
      $groups = GroupSetting::where('parent_id', 0)->orderBy('order', 'ASC')->get();

      $types = GroupSetting::where('parent_id', 1)->orderBy('order', 'ASC')->get();

      return view('admin.pages.setting.type.index', array('groups' => $groups, 'types' => $types, 'menuActive' => 'setting'));
    }

    public function typeAdd(){
      return view('admin.pages.setting.type.add');
    }

    public function typeStore(GroupSettingRequest $request){
      
    }

    public function typeEdit($id){
      return view('admin.pages.setting.type.edit', array('menuActive' => 'setting'));
    }

    public function typeUpdate($id, GroupSettingRequest $request){
        
    }
}
