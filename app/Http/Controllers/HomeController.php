<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Setting;
class HomeController extends Controller
{
    public function index(){
		 return view('admin.pages.dashboard');
  //   	$path = base_path() . '/config/setting.php';
		// $contents = File::get();
		// echo $contents;
    	Setting::set('system.App.Name', 'Phil');
    	 Setting::set('names.surname', 'F');
    }
}
