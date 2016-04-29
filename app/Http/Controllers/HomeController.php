<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use FileSetting;
class HomeController extends Controller
{
    public function index(){
 // 	$array = FileSetting::get('testgroup.App');
	// //FileSetting::forget('system.App');
	// $array = json_encode($array,JSON_PRETTY_PRINT);
	// echo $array;
	// exit();
	//FileSetting::set('testgroup.App2',$array);
    	FileSetting::edit('sssssssssss.demo2','aa');
		  return view('admin.pages.dashboard');
  //   	$path = base_path() . '/config/setting.php';
		// $contents = File::get();
		// echo $contents;
    	
    }
}
