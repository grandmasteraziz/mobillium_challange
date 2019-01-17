<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('api/userto', function (Request $request) {
    return json_encode(array ('a'=>1,'b'=>2,'c'=>3,'d'=>4,'e'=>5));
});

Route::post('/api/me',function(Request $request){
    $request->validate([
        'title' => 'required|unique:posts|max:255',
        'body' => 'required',
    ]);


    return json_encode(array ('a'=>1,'b'=>2,'c'=>3,'d'=>4,'e'=>5));
});

Route::get('api/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');