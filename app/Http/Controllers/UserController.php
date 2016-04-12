<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\Http\Requests\UserRequest;
use Response;

class UserController extends Controller
{
    public function listUser(){
        $users = User::orderBy('id', 'DESC')->get();
        return Response::json(['data' => $users]);
    }
    
    public function index(){
        $users = User::orderBy('id', 'DESC')->get();
        return view('admin.pages.user', array('users' => $users, 'menuActive' => 'User'));
    }

    public function store(UserRequest $request){
        $user = User::create($request->all());
        return Response::json(['flash_message' => 'Đã thêm người dùng!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    public function edit($id){
        $user = User::findOrFail($id);
        return Response::json($user);
    }

    public function update($id, UserRequest $request){
        User::findOrFail($id)->update($request->all());
        return Response::json(['flash_message' => 'Đã cập nhật thông tin người dùng!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    public function destroy($id){
        User::findOrFail($id)->delete();
        return Response::json(['flash_message' => 'Đã xóa người dùng!', 'message_level' => 'success', 'message_icon' => 'check']);
    }
}
