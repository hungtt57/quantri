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
use Gate;
class UserController extends Controller
{   
    public function index(){


            if (Gate::denies('UserController.index')){
               abort(403);
           }
        $roles = Role::where('name', '<>', 'Default')->get();

        $default_role = Role::where('name', '=', 'Default')->firstOrFail();

        return view('admin.pages.user', array('roles' => $roles, 'default_role' => $default_role, 'menuActive' => 'User'));
    }

    public function store(UserRequest $request){

            if (Gate::denies('UserController.store')){
               abort(403);
           }
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

    public function show($id){

            if (Gate::denies('UserController.show')){
               abort(403);
           }
        $user = User::findOrFail($id);
        $user->roles = Role_User::rolesOfUser($id);
        return Response::json($user);
    }
       public function edit($id){

            if (Gate::denies('UserController.edit')){
               abort(403);
           }
        $user = User::findOrFail($id);
        $user->roles = Role_User::rolesOfUser($id);
        return Response::json($user);
    }

    public function update($id, UserRequest $request){

            if (Gate::denies('UserController.update')){
               abort(403);
           }
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

    public function destroy(UserRequest $request){

            if (Gate::denies('UserController.destroy')){
               abort(403);
           }
        $i = 0;
        if (is_string($request->ids)) {
            $user_ids = explode(' ', $request->ids);
            foreach ($user_ids as $user_id) {
                if ($user_id != NULL) {
                    if (Auth::user()->id == $user_id) {
                        $i = 0;
                        break;
                    }
                    else 
                        $i++;
                }
            }
        }

        if ($i > 0) {
            foreach ($user_ids as $user_id) {
                if ($user_id != NULL)
                    User::findOrFail($user_id)->delete();
            }
            return Response::json(['flash_message' => 'Đã xóa người dùng!', 'message_level' => 'success', 'message_icon' => 'check']);
        } else {
            return Response::json(['flash_message' => 'Bạn không thể xóa!', 'message_level' => 'danger', 'message_icon' => 'ban']);
        }
    }
}
