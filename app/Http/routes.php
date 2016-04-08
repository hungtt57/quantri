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
Route::group(['middleware' => ['web']], function () {
	
	Auth::loginUsingId(1);
	
			Route::get('/edit',
			[ 'uses' => 'UserController@edit',
			  'as' => 'UserController.edit'
			]);

			Route::get('/delete',
			[ 'uses' => 'UserController@delete',
			  'as' => 'UserController.delete'
			]);


});