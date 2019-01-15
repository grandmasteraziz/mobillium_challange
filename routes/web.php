<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


// web site
Route::group(['prefix' => 'auth'], function() {
    Route::auth();
    Route::post('/update','UserController@update')->name('auth.update');
    
});
Route::get('/user', 'UserController@showMe')->name('showuserprofile');

//Admin Panel
Route::group(['prefix' => 'admin'], function() { 


    Route::get('/auth/login','Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login','Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('logout','Auth\AdminLoginController@logout')->name('admin.logout');
    
    Route::get('/admin','AdminController@index')->name('admin.dashboard');
    Route::get('/admin/create', 'AdminController@showRegisterForm')->name('admin.register');
    Route::post('/admin/register', 'AdminController@create')->name('admin.register.submit');
    Route::get('admin/{id}/edit','AdminController@edit')->name('admin.edit');
    Route::post('admin/{id}/update','AdminController@update')->name('admin.update');
    Route::get('admin/{id}/delete','AdminController@destroy')->name('admin.delete');


    // user
    Route::get('user','AdminController@showUsers')->name('admin.users');
    Route::get('user/create','AdminController@showUserRegisterForm')->name('admin.user.register');
    Route::post('/user/create', 'AdminController@createUser')->name('admin.user.register.submit');
    Route::get('user/{id}/login','AdminController@loginAsUser')->name('admin.login.as.user');
    Route::get('user/{id}/delete','AdminController@destroyUser')->name('admin.delete.user');
    Route::get('user/{id}/edit','AdminController@editUser')->name('admin.edit.user');
    Route::post('/user/{id}/update', 'AdminController@updateUser')->name('admin.user.update.submit');
    

});



Route::get('/home', 'HomeController@index')->name('home');

