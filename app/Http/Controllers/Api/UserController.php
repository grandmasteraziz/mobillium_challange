<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Http\Requests\UpdateUserRequest; 
use App\Http\Requests\StoreUserRequest;
use App\Http\IdentityCheck\IdentityCheck;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; 
use App\User;

class UserController extends ApiController
{
 
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    { 

        

        return response()->json($request->user());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        //$request->validated();
       
        $cafe = array ('a'=>1,'b'=>2);
          

        return response()->json($request,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
       
       $authUser = Auth::user(); 
       $count = 0;

       if($authUser->id != $id)
       {
         return response()->json(['message'=>'Unauthorised','code' => 401], 401); 
       }

       if($authUser->tckn != $request->tckn){ $count++; }
       if($authUser->first_name != $request->first_name){ $count++; }
       if($authUser->last_name != $request->last_name){ $count++; }
       if($authUser->birthyear != $request->birtyear){ $count++; }
       
       if($count > 0)
       {
            $identityCheck = IdentityCheck::soapIdentityCheck($request->tckn,$request->first_name.' '.$request->last_name ,$request->birthyear);  
   
            if(!$identityCheck){return response()->json(["message"=>"tckn error","code" => 403],403);}         
       }
 
      
 
       $user = User::find(Auth::id());
       $user->first_name = $request->first_name;
       $user->last_name = $request->last_name;
       $user->email = $request->email;
       $user->password = Hash::make($request->password);
       $user->tckn = $request->tckn;
       $user->phone = $request->phone;
       $user->birthyear = $request->birthyear;
      
       $user->save();

       var_dump($user);
       die();

       return response()->json($user,202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
