<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\IdentityCheck;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\View;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
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

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

   
       // $algorithmCheck = IdentityCheck::algorithmCheck($data['tckn']);
        $identityCheck = IdentityCheck::soapIdentityCheck($data['tckn'],$data['first_name'].' '.$data['last_name'] ,$data['birthyear']);
        
       // if(!$algorithmCheck){return view('auth.register',['tckn_error' => 'Lütfen Geçerli Bir T.C Kimlik Numarası Girin.']);}
        if(!$identityCheck){return view('auth.register');['tckn_error' => 'Lütfen Geçerli Kimlik Bilgileri Girin.'];}


        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'tckn' => $data['tckn'],
            'phone' => $data['phone'],
            'birthyear' => $data['birthyear'],
        ]);
    }

   


}
