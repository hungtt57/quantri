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
use MultipleIterator;
use ArrayIterator;
use Module;

class SettingController extends Controller
{
    public function index($id = null){
      $groups = GroupSetting::where('parent_id', 0)->orderBy('order', 'ASC')->get();
      if($id) {
        $types = GroupSetting::where('parent_id', $id)->orderBy('order', 'ASC')->get();
      } else {
        $minGroupOrder = GroupSetting::where('parent_id', 0)->min('order');
        $firstGroup = GroupSetting::where('parent_id', 0)->where('order', $minGroupOrder)->first();
        $types = GroupSetting::where('parent_id', $firstGroup->id)->orderBy('order', 'ASC')->get();
      }
      if(count($types)) {
        $minTypeOrder = $types->min('order');
        $type = $types->where('order', $minTypeOrder)->first();
        return view('admin.pages.setting.index', array('groups' => $groups, 'types' => $types, 'menuActive' => 'setting', 'selectedGroup' => $id, 'selectedType' => $type->key));
      }
      return view('admin.pages.setting.index', array('groups' => $groups, 'types' => $types, 'menuActive' => 'setting', 'selectedGroup' => $id));
    }

    public function add(){
      $groups = GroupSetting::all();
      return view('admin.pages.setting.add', array('groups' => $groups ,'menuActive' => 'setting'));
    }

    public function store(SettingRequest $request){
      $setting = Setting::create($request->all());
      $type = GroupSetting::findOrFail($request->type_id);
      return redirect('setting/'.$type->parent_id)->with(['flash_message' => 'Đã thêm cài đặt!', 'message_level' => 'success', 'message_icon' => 'check', 'selectedType' => $type->key]);
    }

    public function edit($id){
      $setting = Setting::findOrFail($id);
      $groups = GroupSetting::all();
      return view('admin.pages.setting.edit', array('setting' => $setting, 'groups' => $groups, 'menuActive' => 'setting'));
    }

    public function update($id, SettingRequest $request){
      Setting::findOrFail($id)->update($request->all());
      $type = GroupSetting::findOrFail($request->type_id);
      return redirect('setting/'.$type->parent_id)->with(['flash_message' => 'Đã lưu cài đặt!', 'message_level' => 'success', 'message_icon' => 'check', 'selectedType' => $type->key]);
    }

    public function updateAll(Request $request){
       $ids = $request->id;
       $values = $request->value;
       
       $multiIterator = new MultipleIterator();
       $multiIterator->attachIterator(new ArrayIterator($ids));
       $multiIterator->attachIterator(new ArrayIterator($values));

       foreach($multiIterator as list($id, $value)) {
          $setting = Setting::findOrFail($id);
          $setting->value = $value;
          $setting->save();
       }
       $type = GroupSetting::findOrFail($setting->type_id);

       return redirect('setting/'.$type->parent_id)->with(['flash_message' => 'Đã lưu loại cài đặt!', 'message_level' => 'success', 'message_icon' => 'check', 'selectedType' => $type->key]);
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

    public function groupUpdateAll(Request $request){
       $ids = $request->id;
       $names = $request->name;

       $multiIterator = new MultipleIterator();
       $multiIterator->attachIterator(new ArrayIterator($ids));
       $multiIterator->attachIterator(new ArrayIterator($names));

       foreach($multiIterator as list($id, $name)) {
          $group = GroupSetting::findOrFail($id);
          $group->name = $name;
          $group->save();
       }

       return redirect('setting/group')->with(['flash_message' => 'Đã lưu nhóm cài đặt!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    public function typeIndex($id = null){
      $groups = GroupSetting::where('parent_id', 0)->orderBy('order', 'ASC')->get();
      if($id) {
        $types = GroupSetting::where('parent_id', $id)->orderBy('order', 'ASC')->get();
      } else {
        $minGroupOrder = GroupSetting::where('parent_id', 0)->min('order');
        $firstGroup = GroupSetting::where('parent_id', 0)->where('order', $minGroupOrder)->first();
        $types = GroupSetting::where('parent_id', $firstGroup->id)->orderBy('order', 'ASC')->get();
      }
      return view('admin.pages.setting.type.index', array('groups' => $groups, 'types' => $types, 'menuActive' => 'setting', 'selectedGroup' => $id));
    }

    public function typeAdd(){
      $groups = GroupSetting::where('parent_id', 0)->orderBy('order', 'ASC')->get();
      return view('admin.pages.setting.type.add', array('groups' => $groups ,'menuActive' => 'setting'));
    }

    public function typeStore(GroupSettingRequest $request){
      $type = GroupSetting::create($request->all());
      return redirect('setting/type/'.$request->parent_id)->with(['flash_message' => 'Đã thêm loại cài đặt!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    public function typeEdit($id){
      $type = GroupSetting::findOrFail($id);
      $groups = GroupSetting::where('parent_id', 0)->orderBy('order', 'ASC')->get();
      return view('admin.pages.setting.type.edit', array('type' => $type, 'groups' => $groups ,'menuActive' => 'setting'));
    }

    public function typeUpdate($id, GroupSettingRequest $request){
      GroupSetting::findOrFail($id)->update($request->all());
      return redirect('setting/type/'.$request->parent_id)->with(['flash_message' => 'Đã lưu loại cài đặt!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    public function typeUpdateAll(Request $request){
       $ids = $request->id;
       $names = $request->name;
       
       $multiIterator = new MultipleIterator();
       $multiIterator->attachIterator(new ArrayIterator($ids));
       $multiIterator->attachIterator(new ArrayIterator($names));

       foreach($multiIterator as list($id, $name)) {
          $type = GroupSetting::findOrFail($id);
          $type->name = $name;
          $type->save();
       }

       return redirect('setting/type/'.$type->parent_id)->with(['flash_message' => 'Đã lưu loại cài đặt!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    public function synchronous() {
      $modules = Module::getByStatus(1);
      foreach ($modules as $module) {
        $group = GroupSetting::where('key', $module->getLowerName())->get();
        if(count($group) == 0) {
          $group = new GroupSetting();
          $group->key = $module->getLowerName();
          $group->name = $module->getStudlyName();
          $group->order = GroupSetting::where('parent_id', 0)->max('order') + 1;
          $group->save();
        }
      }
      return redirect('setting')->with(['flash_message' => 'Đã đồng bộ các module!', 'message_level' => 'success', 'message_icon' => 'check']);
    }
}
