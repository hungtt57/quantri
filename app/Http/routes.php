<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['web']], function () {
    
Route::get('/user',
	[ 'uses' => 'Backend\UserController@index',
	  'as' => 'UserController.index'
	]);

$get ='edit user,edit post';

Route::get('/user/{post}', [
   'uses' => 'Backend\UserController@edit',
   'as' => 'UserController.edit'
]);


Route::get('/articale/{post}', [
   'middleware'=> 'can:'.$get,
   'uses' => 'Backend\UserController@articale',
   'as' => 'UserController.article'
]);





}); //end middleware web