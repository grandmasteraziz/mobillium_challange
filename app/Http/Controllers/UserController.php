<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\IdentityCheck\IdentityCheck;
use Illuminate\Support\Facades\View;
use App\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:web');
    }
 

    public function showMe()
    {
        $user = User::find(Auth::id());
     
        return view('showMe',['user'=>$user]);
    }


    public function update(UpdateUserRequest $request)
    {
         
       
        $identityCheck = IdentityCheck::soapIdentityCheck($request->tckn ,$request->first_name.' '.$request->last_name ,$request->birthyear);
        
        if(!$identityCheck){return view('showMe',['user'=> Auth::user(),'tcknError' => 'Lütfen Geçerli Kimlik Bilgileri Girin.']); }

        $user = User::find(Auth::id());
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->tckn = $request->tckn;
        $user->phone = $request->phone;
        $user->birthyear = $request->birthyear;
       
        $user->save();

       
        return view('showMe',['user'=>$user]);
        
    }


   

}
