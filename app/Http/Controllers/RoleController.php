<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Role;
use App\Http\Requests\RoleRequest;
use Response;
use App\Permission;
use Route;
use Session;
use Request;

class RoleController extends Controller
{
	  public function index(){
        $roles = Role::all();
        $role_first = Role::first();
        $role_permission = $role_first->permissions;
        $permissions = Permission::all();
        return view('admin.pages.role', array('roles' => $roles, 'menuActive' => 'role','role_permission' => $role_permission,'permissions' => $permissions));
    }

    public function store(RoleRequest $request){
        $role = Role::create($request->all());
        return Response::json(['flash_message' => 'Đã thêm role!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    public function synchronous(){
      // Update lai active permission về 0
      $update = Permission::updateAll();
      $routes= Route::getRoutes();
   
      foreach ($routes as $value) {
          $array = array();
          $array = explode('.',$value->getName());
          $permissionName = $value->getName();
          $controller = $array[0];
          $method = $array[1];

          $permission= Permission::where('name','=',$permissionName)->first();

          //Khong tao permission vs dashboard va auth
          if($controller == 'Not'){
              continue;
          } 

          if($permission){ 
            //Da co permission tương ứng voi controller
            $permission->label= trans('messages.'.$method);
            //Update lai gia tri active thanh 1
            $permission->active='1';
            $permission->save();
            continue;
          }else{ 
                // Chua co permission
                $permissionParent= Permission::where('name','=',$controller)->first();
                if($permissionParent){ // đã có controller cha
                   $newPermission = new Permission;
                   $newPermission->parent_id = $permissionParent->id;
                   $newPermission->name=$permissionName;
                   $newPermission->label= trans('messages.'.$method);
                   $newPermission->active='1';
                   $newPermission->save();
                 
                }else{ 
                    // Chưa có controller cha
                    $permissionParent = new Permission;
                    $permissionParent->name = $controller;
                    $permissionParent->parent_id = '0';
                    $permissionParent->active = '1';
                    $permissionParent->label= trans('messages.'.$controller);
                    $permissionParent->save();

                    $newPermission = new Permission;
                    $newPermission->parent_id = $permissionParent->id;
                    $newPermission->name = $permissionName;
                    $newPermission->active='1';
                    $newPermission->label= trans('messages.'.$method);
                    $newPermission->save();
                }
          }
        }
      Permission::where('active', 0)->delete();
      return redirect('role')->with('messages', 'Đồng bộ thành công!');
    }

    public function destroy($id){
      $role = Role::find($id);
      $name = $role->name;
      $role->delete();
      return redirect('role')->with('messages', 'Đã xóa quyền '.$name.'!');
    }

    public function updatePermission(){
        if(Request::ajax()){
            $data = Request::input('data');
            $id = explode(',',$data);
            $role_id = $id[0];
            
            $role = Role::findOrFail($role_id);
            $role->removeAllPermissions();

            for($i = 1; $i < sizeof($id); $i++){
              $role->assignPermission(Permission::findOrFail($id[$i]));
            } 
            return 'oke';    
        } 
    }
}
