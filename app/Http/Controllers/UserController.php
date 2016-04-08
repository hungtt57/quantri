<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gate;
use App\Http\Requests;
use App\User;
use App\Permission;
use Auth;
use Route;
class UserController extends Controller
{
    public function edit(){
         $c = Route::getRoutes();
       foreach ($c as $value) {
           echo $value->getName();
        }
 
    //	return view('welcome');
    }
    public function delete(){

    }   
}
