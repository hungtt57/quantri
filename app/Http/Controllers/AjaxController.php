<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use App\Http\Requests;
use App\Article;
use Response;
use App\User;
use App\Role_User;
use App\Permission_Role;
use Auth;
use Request;
use Input;

class AjaxController extends Controller
{
    public function listArticle(){
        $articles = Article::orderBy('id', 'DESC')->get();
        return Response::json(['data' => $articles]);
    }

    public function listUser(){
        //$users = User::orderBy('id', 'DESC')->get();
        $users = User::where('id', '!=', Auth::id())->orderBy('id', 'DESC')->get();
        foreach ($users as $user) {
            $user->roles = Role_User::rolesOfUser($user->id);
        }
        return Response::json(['data' => $users]);
    }
    public function updatePermission(){
        if(Request::ajax()){
            $data = Request::input('data');
            $id = explode(',',$data);
            $role_id = $id[0];
            
            Permission_Role::where('role_id',$role_id)->delete();

            for($i = 1 ;$i < sizeof($id);$i++){
                   $permission_role = new Permission_Role;
                   $permission_role->role_id = $role_id;
                   $permission_role->permission_id = $id[$i];
                   $permission_role->save();
            } 
            return 'oke';    
        } 
    }
}
