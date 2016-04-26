<?php
//Route::group(['middleware' => 'web'], function(){
// Đặt tên route theo định dạng Controller.Method
// Không muốn add vào permission thêm Not vào đầu

//Authentication
Route::get('login', ['as' => 'Not.AuthController.show', 'uses' => 'Auth\AuthController@showLoginForm']);
Route::post('login', ['as' => 'Not.AuthController.login', 'uses' => 'Auth\AuthController@login']);
Route::get('logout', ['as' => 'Not.AuthController.logout', 'uses' => 'Auth\AuthController@logout']);
Route::get('auth/facebook', ['as' => 'Not.AuthController.redirectFacebook', 'uses' => 'Auth\AuthController@redirectToProvider']);
Route::get('auth/facebook/callback', ['as' => 'Not.AuthController.handleFacebook', 'uses' => 'Auth\AuthController@handleProviderCallback']);

Route::group(['middleware' => 'auth'], function(){
	Route::get('/', ['as' => 'Not.HomeController.dashboard', function(){
		return view('admin.pages.dashboard');
	}]);

	//Role management
	Route::get('role', ['as' => 'RoleController.index', 'uses' => 'RoleController@index']);
	Route::get('role/destroy/{id}', ['as' => 'RoleController.destroy', 'uses' => 'RoleController@destroy']);
	Route::post('role/add', ['as' => 'RoleController.store', 'uses' => 'RoleController@store']);
	Route::get('synchronous', ['as' => 'RoleController.synchronous', 'uses' => 'RoleController@synchronous']);
	Route::get('updatePermission', ['as' => 'Not.RoleController.permission.update', 'uses' => 'RoleController@updatePermission']);
	 
	//User management
	Route::get('listUser', ['as' => 'Not.UserController.list', 'uses' => 'UserController@listUser']);
    Route::get('user', ['as' => 'UserController.index', 'uses' => 'UserController@index']);
	Route::get('user/edit/{id}', ['as' => 'UserController.edit', 'uses' => 'UserController@edit']);
	Route::get('user/show/{id}', ['as' => 'UserController.show', 'uses' => 'UserController@show']);
	Route::post('user/add', ['as' => 'UserController.store', 'uses' => 'UserController@store']);
	Route::patch('user/{id}', ['as' => 'UserController.update', 'uses' => 'UserController@update']);
	Route::delete('user/destroy', ['as' => 'UserController.destroy', 'uses' => 'UserController@destroy']);

    Route::get('profile', ['as' => 'Not.UserController.profile.show', 'uses' => 'UserController@showProfile']);
    Route::post('profile', ['as' => 'Not.UserController.profile.update', 'uses' => 'UserController@updateProfile']);
    Route::get('password', ['as' => 'Not.UserController.password.show', 'uses' => 'UserController@showPassword']);
    Route::post('password', ['as' => 'Not.UserController.password.update', 'uses' => 'UserController@updatePassword']);

    // Setting 
    Route::get('general', ['as' => 'SettingController.general.show', 'uses' => 'SettingController@showGeneral']);
    Route::post('general', ['as' => 'SettingController.general.update', 'uses' => 'SettingController@updateGeneral']);
    Route::group(['prefix' => 'setting'], function () {
	    Route::get('/', ['as' => 'SettingController.index', 'uses' => 'SettingController@index']);
	    Route::get('group', ['as' => 'SettingController.group.index', 'uses' => 'SettingController@groupIndex']);
	    Route::get('group/add', ['as' => 'SettingController.group.add', 'uses' => 'SettingController@groupAdd']);
	    Route::post('group/add', ['as' => 'SettingController.group.store', 'uses' => 'SettingController@groupStore']);
	});

});
//});
