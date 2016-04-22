<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Role;
use File;
use Image;
class SettingController extends Controller
{
  public function index(){
    return view('admin.pages.setting', array('menuActive' => 'setting'));
  }
   
  public function showGeneral(){
      $roles = Role::all();
      return view('admin.pages.setting-general', array('roles' => $roles, 'menuActive' => 'Setting General'));
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
}
