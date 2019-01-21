<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\IdentityCheck\IdentityCheck;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash;
use App\User;

class AuthController extends ApiController
{


    public function register(StoreUserRequest $request)
    {
        // var_dump($request->all());
      
        $identityCheck = IdentityCheck::soapIdentityCheck($request->tckn,$request->first_name.' '.$request->last_name ,$request->birthyear);
       
        
         if(!$identityCheck){ return response()->json(["message"=>"tckn error"],403); }
        
        
         $input = $request->all(); 
         $input['password'] = Hash::make($input['password']); 
         $user = User::create($input);
         
         
      
    
          
         $success['token'] = $user->createToken('MyApp')->accessToken; 
         $success['user'] =  $user;

        
        
         return response()->json($success, 201); 

       //  return $this->showOne($user, 201);
    }


    public function login(LoginUserRequest $request)
    { 
       
        if(Auth::attempt(['tckn' => $request->tckn, 'password' => $request->password]))
        { 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')->accessToken; 
            $success['user'] =  $user;

            return response()->json(['success' => $success], 200); 
        } 
       
        return response()->json(['message'=>'Unauthorised','code' => 401], 401); 
    }  
 
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
