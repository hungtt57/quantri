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
use FileSetting;
class SettingController extends Controller
{
  public function index($id = null){
    $groups = GroupSetting::where('parent_id', 0)->where('visible', 1)->orderBy('order', 'ASC')->get();
    if($id) {
      $types = GroupSetting::where('parent_id', $id)->orderBy('order', 'ASC')->get();
    } else {
      $minGroupOrder = GroupSetting::where('parent_id', 0)->where('visible', 1)->min('order');
      $firstGroup = GroupSetting::where('parent_id', 0)->where('order', $minGroupOrder)->first();
      $types = GroupSetting::where('parent_id', $firstGroup->id)->orderBy('order', 'ASC')->get();
      $id = $firstGroup->id;
    }
    if(count($types)) {
      $minTypeOrder = $types->min('order');
      $type = $types->where('order', $minTypeOrder)->first();
      return view('admin.pages.setting.index', array('groups' => $groups, 'types' => $types, 'menuActive' => 'setting', 'selectedGroup' => $id, 'selectedType' => $type->key));
    }
    return view('admin.pages.setting.index', array('groups' => $groups, 'types' => $types, 'menuActive' => 'setting', 'selectedGroup' => $id));
  }

  public function create(SettingRequest $request) {
    if ($request->isMethod('post'))  {
      $setting = Setting::create($request->all());
      $type = GroupSetting::findOrFail($request->type_id);
      $group = GroupSetting::findOrFail($type->parent_id);
      
      FileSetting::set($group->key.'.'.$type->key.'.'.$request->key,$request->value);

      return redirect('setting/'.$type->parent_id)->with(['flash_message' => 'Đã thêm cài đặt!', 'message_level' => 'success', 'message_icon' => 'check', 'selectedType' => $type->key]);
    } else {
      $groups = GroupSetting::where('visible', 1)->get();
      return view('admin.pages.setting.add', array('groups' => $groups ,'menuActive' => 'setting'));
    }
  }

  public function update($id, SettingRequest $request) {
    if ($request->isMethod('patch'))  {
       $key = Setting::find($id)->key;
      Setting::findOrFail($id)->update($request->all());
     
      $type = GroupSetting::findOrFail($request->type_id);
       $group = GroupSetting::findOrFail($type->parent_id);
 
       FileSetting::forget($group->key.'.'.$type->key.'.'.$key); // delete setting old
       
        FileSetting::set($group->key.'.'.$type->key.'.'.$request->key,$request->value);

      return redirect('setting/'.$type->parent_id)->with(['flash_message' => 'Đã lưu cài đặt!', 'message_level' => 'success', 'message_icon' => 'check', 'selectedType' => $type->key]);
    } else {
      $setting = Setting::findOrFail($id);
      $groups = GroupSetting::where('visible', 1)->get();
      return view('admin.pages.setting.edit', array('setting' => $setting, 'groups' => $groups, 'menuActive' => 'setting'));
    }
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

public function updateGeneral(Request $request) {
  if ($request->isMethod('post'))  {
    $arraySetting = config('general');

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

  if(File::put(base_path() . '/config/general.php', "<?php\n return $data ;")) {
    return redirect('general')->with(['flash_message' => 'Đã lưu cài đặt!', 'message_level' => 'success', 'message_icon' => 'check']);
  }
} else {
  $roles = Role::all();
  return view('admin.pages.setting.general', array('roles' => $roles, 'menuActive' => 'Setting General'));
}
}

public function indexGroup(){
  $groups = GroupSetting::where('parent_id', 0)->where('visible', 1)->orderBy('order', 'ASC')->get();
  return view('admin.pages.setting.group.index', array('groups' => $groups, 'menuActive' => 'setting'));
}

public function createGroup(GroupSettingRequest $request) {
  if ($request->isMethod('post'))  {
    $group = GroupSetting::create($request->all());

    FileSetting::set($request->input('key'),'');



    return redirect('setting/group')->with(['flash_message' => 'Đã thêm nhóm cài đặt!', 'message_level' => 'success', 'message_icon' => 'check']);
  } else {
    return view('admin.pages.setting.group.add');
  }
}

public function updateGroup($id, GroupSettingRequest $request) {
  if ($request->isMethod('patch'))  {
    GroupSetting::findOrFail($id)->update($request->all());
    return redirect('setting/group')->with(['flash_message' => 'Đã lưu nhóm cài đặt!', 'message_level' => 'success', 'message_icon' => 'check']);
  } else {
    $group = GroupSetting::findOrFail($id);
    return view('admin.pages.setting.group.edit', array('group' => $group, 'menuActive' => 'setting'));
  }
}

public function updateAllGroup(Request $request){
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

public function indexType($id = null){
  $groups = GroupSetting::where('parent_id', 0)->where('visible', 1)->orderBy('order', 'ASC')->get();
  if($id) {
    $types = GroupSetting::where('parent_id', $id)->orderBy('order', 'ASC')->get();
  } else {
    $minGroupOrder = GroupSetting::where('parent_id', 0)->where('visible', 1)->min('order');
    $firstGroup = GroupSetting::where('parent_id', 0)->where('order', $minGroupOrder)->first();
    $types = GroupSetting::where('parent_id', $firstGroup->id)->orderBy('order', 'ASC')->get();
  }
  return view('admin.pages.setting.type.index', array('groups' => $groups, 'types' => $types, 'menuActive' => 'setting', 'selectedGroup' => $id));
}

public function createType(GroupSettingRequest $request) {
  if ($request->isMethod('post'))  {
    $type = GroupSetting::create($request->all());


    $group= GroupSetting::find($request->parent_id);

    FileSetting::set($group->key.'.'.$request->key,''); // write file setting.json



    return redirect('setting/type/'.$request->parent_id)->with(['flash_message' => 'Đã thêm loại cài đặt!', 'message_level' => 'success', 'message_icon' => 'check']);
  } else {
    $groups = GroupSetting::where('parent_id', 0)->where('visible', 1)->orderBy('order', 'ASC')->get();
    return view('admin.pages.setting.type.add', array('groups' => $groups ,'menuActive' => 'setting'));
  }
}

public function updateType($id, GroupSettingRequest $request) {
  if ($request->isMethod('patch'))  {
    GroupSetting::findOrFail($id)->update($request->all());


    $group= GroupSetting::find($request->parent_id);

 


    return redirect('setting/type/'.$request->parent_id)->with(['flash_message' => 'Đã lưu loại cài đặt!', 'message_level' => 'success', 'message_icon' => 'check']);
  } else {
    $type = GroupSetting::findOrFail($id);
    $groups = GroupSetting::where('parent_id', 0)->where('visible', 1)->orderBy('order', 'ASC')->get();
    return view('admin.pages.setting.type.edit', array('type' => $type, 'groups' => $groups ,'menuActive' => 'setting'));
  }
}

public function updateAllType(Request $request){
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

public function synchronous($selectedGroup, $selectedType = null) {
  $activeModules = Module::getByStatus(1);
  foreach ($activeModules as $module) {
    $group = GroupSetting::where('key', $module->getLowerName())->first();
    if(count($group) == 0) {
      $group = new GroupSetting();
      $group->key = $module->getLowerName();
      $group->name = $module->getStudlyName();
      $group->order = GroupSetting::where('parent_id', 0)->max('order') + 1;
      $group->save();
    } else {
      $group->visible = 1;
      $group->save();
    }
  }

  $inactiveModules = Module::getByStatus(0);
  foreach ($inactiveModules as $module) {
    $group = GroupSetting::where('key', $module->getLowerName())->first();
    if(count($group)) {
      $group->visible = 0;
      $group->save();
    }
  }

  if($selectedType) {
    return redirect('setting/'.$selectedGroup)->with(['flash_message' => 'Đã đồng bộ các module!', 'message_level' => 'success', 'message_icon' => 'check', 'selectedType' => $selectedType]);
  }
  return redirect('setting/'.$selectedGroup)->with(['flash_message' => 'Đã đồng bộ các module!', 'message_level' => 'success', 'message_icon' => 'check']);
}
}
