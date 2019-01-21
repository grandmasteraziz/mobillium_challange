<?php

use Illuminate\Http\Request;
use App\Http\Requests\StoreUser;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('api/userto', function (Request $request) {
//     return json_encode(array ('a'=>1,'b'=>2,'c'=>3,'d'=>4,'e'=>5));
// });

// Route::post('/api/me',function(Request $req){
    
//     //$req->validated();
 

//     return json_encode(array ('a'=>1,'b'=>2,'c'=>3,'d'=>4,'e'=>5));
// });



Route::post('api/auth/register', 'Api\AuthController@register');
Route::post('api/auth/login', 'Api\AuthController@login');
Route::get('api/auth/logout', 'Api\AuthController@logout');
Route::get('api/user/me', 'Api\UserController@index');
Route::resource('api/auth', 'Api\AuthController');

// Route::get('api/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:api');