<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Route;
use Auth;
use App\User;
class UserController extends BaseController
{
   public function index(){
 //   	$role = Role::create(['name' => 'QTV']);
	//  $permission = Permission::create(['name' => 'edit post']);
	//  $role->givePermissionTo('edit post');
	// $user=User::where('name','=','admin')->first();
	//$user->assignRole('Admin');
	  if (Auth::attempt(['name' => 'admin', 'password' => 'admin'])) {
            // Authentication passed...
          
        }
	return view('Backend/user');
   }
   public function edit(){
 //  $c = Route::current()->getAction();
   $c = Route::getRoutes();
   foreach ($c as $value) {
       echo $value->getName();
    }
 
   }
}
