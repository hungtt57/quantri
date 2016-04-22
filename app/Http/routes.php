<?php
// đặt tên route có as theo định dạng Controller.method
// KO muốn add vào permission thêm Not vào đầu chuỗi as
Route::get('/', ['as' => 'Not.HomeController.dashboard', 'uses' => 'HomeController@index']);

//Disable register
Route::get('login', ['as' => 'Not.AuthController.show', 'uses' => 'Auth\AuthController@showLoginForm']);
Route::post('login', ['as' => 'Not.AuthController.login', 'uses' => 'Auth\AuthController@login']);
Route::get('logout', ['as' => 'Not.AuthController.logout', 'uses' => 'Auth\AuthController@logout']);

Route::group(['middleware' => 'auth'], function(){
	//Role management
	Route::get('role', ['as' => 'RoleController.index', 'uses' => 'RoleController@index']);
	Route::get('role/destroy/{id}', ['as' => 'RoleController.destroy', 'uses' => 'RoleController@destroy']);
	Route::post('role/add', ['as' => 'RoleController.store', 'uses' => 'RoleController@store']);
	Route::get('synchronous', ['as' => 'RoleController.synchronous', 'uses' => 'RoleController@synchronous']);
	 
	//User management
    Route::get('user', ['as' => 'UserController.index', 'uses' => 'UserController@index']);
	Route::get('user/edit/{id}', ['as' => 'UserController.edit', 'uses' => 'UserController@edit']);
	Route::get('user/show/{id}', ['as' => 'UserController.show', 'uses' => 'UserController@show']);
	Route::post('user/add', ['as' => 'UserController.store', 'uses' => 'UserController@store']);
	Route::patch('user/{id}', ['as' => 'UserController.update', 'uses' => 'UserController@update']);
	Route::delete('user/destroy', ['as' => 'UserController.destroy', 'uses' => 'UserController@destroy']);

    Route::get('profile', ['as' => 'Not.UserController.profile.show', 'uses' => 'UserController@showProfile']);
    Route::post('profile', ['as' => 'Not.UserController.profile.update', 'uses' => 'UserController@updateProfile']);
    
	//Article management
    Route::get('article', ['as' => 'ArticleController.index', 'uses' => 'ArticleController@index']);
	Route::get('article/edit/{id}', ['as' => 'ArticleController.edit', 'uses' => 'ArticleController@edit']);
	Route::get('article/show/{id}', ['as' => 'ArticleController.show', 'uses' => 'ArticleController@show']);
	Route::post('article/add', ['as' => 'ArticleController.store', 'uses' => 'ArticleController@store']);
	Route::patch('article/{id}', ['as' => 'ArticleController.update', 'uses' => 'ArticleController@update']);
	Route::delete('article/destroy', ['as' => 'ArticleController.destroy', 'uses' => 'ArticleController@destroy']);


    // Setting 
    Route::get('setting-general', ['as' => 'SettingController.showGeneral', 'uses' => 'SettingController@showGeneral']);
    Route::post('setting-general', ['as' => 'SettingController.updateGeneral', 'uses' => 'SettingController@updateGeneral']);
    Route::get('setting', ['as' => 'SettingController.index', 'uses' => 'SettingController@index']);

    //Get list by Ajax
    Route::get('listArticle', ['as' => 'Not.AjaxController.article.list', 'uses' => 'AjaxController@listArticle']);
    Route::get('listUser', ['as' => 'Not.AjaxController.user.list', 'uses' => 'AjaxController@listUser']);
    Route::get('updatePermission', ['as' => 'Not.AjaxController.update.permission', 'uses' => 'AjaxController@updatePermission']);
});
