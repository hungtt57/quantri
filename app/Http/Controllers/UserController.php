<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\Http\Requests\UserRequest;
use Response;
use Auth;
use App\Role_User;
use App\Role;

class UserController extends Controller
{
    public function listUser(){
        $users = User::orderBy('id', 'DESC')->get();
        foreach ($users as $user) {
            $user->roles = Role_User::rolesOfUser($user->id);
        }
        return Response::json(['data' => $users]);
    }
    
    public function index(){
        $roles = Role::all();
        //$users = User::orderBy('id', 'DESC')->get();
        return view('admin.pages.user', array('roles' => $roles, 'menuActive' => 'User'));
    }

    public function store(UserRequest $request){
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        return Response::json(['flash_message' => 'Đã thêm người dùng!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    public function edit($id){
        $user = User::findOrFail($id);
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
