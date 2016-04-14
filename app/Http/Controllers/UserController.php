<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\Http\Requests\UserRequest;
use Response;
use Auth;
use App\Role;
use App\Role_User;

class UserController extends Controller
{   
    public function index(){
        $roles = Role::where('name', '<>', 'Default')->get();

        $default_role = Role::where('name', '=', 'Default')->firstOrFail();

        return view('admin.pages.user', array('roles' => $roles, 'default_role' => $default_role, 'menuActive' => 'User'));
    }

    public function store(UserRequest $request){
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        $role_ids = $request->role;
        foreach ($role_ids as $role_id) {
            $user->assignRole(Role::findOrFail($role_id));
        }
        
        return Response::json(['flash_message' => 'Đã thêm người dùng!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    public function edit($id){
        $user = User::findOrFail($id);
        $user->roles = Role_User::rolesOfUser($id);
        return Response::json($user);
    }

    public function update($id, UserRequest $request){
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if(isset($request->password)){
            $user->password = bcrypt($request->password);
        }
        $user->save();

        $user->removeAllRole();
        $role_ids = $request->role;
        foreach ($role_ids as $role_id) {
            $user->assignRole(Role::findOrFail($role_id));
        }

        return Response::json(['flash_message' => 'Đã cập nhật thông tin người dùng!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    public function destroy($id){
        $user = User::findOrFail($id);
        if(Auth::user()->id == $user->id){
            return Response::json(['flash_message' => 'Bạn không thể xóa người dùng này!', 'message_level' => 'danger', 'message_icon' => 'ban']);
        } else {
            $user->delete();
            return Response::json(['flash_message' => 'Đã xóa người dùng!', 'message_level' => 'success', 'message_icon' => 'check']);
        }
    }
}
