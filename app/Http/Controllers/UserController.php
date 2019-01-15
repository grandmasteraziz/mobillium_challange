<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\IdentityCheck;
use Illuminate\Support\Facades\View;
use App\User;

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


    public function update(Request $request)
    {
        $this->validator($request->all());
        $identityCheck = IdentityCheck::soapIdentityCheck($request->tckn ,$request->first_name.' '.$request->last_name ,$request->birthyear);
        
        if(!$identityCheck){return view('showMe',['user'=> Auth::user(),'tcknError' => 'Lütfen Geçerli Kimlik Bilgileri Girin.']); }

        $user = User::find(Auth::id());
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->tckn = $request->tckn;
        $user->phone = $request->phone;
        $user->birthyear = $request->birthyear;
        $user->birthyear = Hash::make($request->password);
        $user->save();

       
        return view('showMe',['user'=>$user]);
        
    }


    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'tckn' => ['required', 'string', 'size:11', 'unique:users']
        ]);
    }

}
