<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Article;
use Response;
use App\User;
use App\Role_User;

class AjaxController extends Controller
{
    public function listArticle(){
        $articles = Article::orderBy('id', 'DESC')->get();
        return Response::json(['data' => $articles]);
    }

    public function listUser(){
        $users = User::orderBy('id', 'DESC')->get();
        foreach ($users as $user) {
            $user->roles = Role_User::rolesOfUser($user->id);
        }
        return Response::json(['data' => $users]);
    }
}
