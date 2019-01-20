<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Http\Requests\StoreUserRequest;
use App\User;

class AuthController extends ApiController
{


    public function register(StoreUserRequest $request)
    {
        $http = new GuzzleHttp\Client;
          
        $identityCheck = IdentityCheck::soapIdentityCheck($request->tckn,$request->first_name.' '.$request->last_name ,$request->birthyear);
        
        // if(!$algorithmCheck){return view('auth.register',['tckn_error' => 'Lütfen Geçerli Bir T.C Kimlik Numarası Girin.']);}
         if(!$identityCheck){return view('auth.register');['tckn_error' => 'Lütfen Geçerli Kimlik Bilgileri Girin.'];}
 
 
        $user = User::create([
             'first_name' =>$request->first_name,
             'last_name' => $request->last_name,
             'email' =>$request->email,
             'password' => Hash::make($request->password),
             'tckn' => $request->tckn,
             'phone' => $request->phone,
             'birthyear' => $request->birthyear,
         ]);

         $response = $http->post('http://your-app.com/oauth/token', [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => 'client-id',
                'client_secret' => 'client-secret',
                'username' => 'taylor@laravel.com',
                'password' => 'my-password',
                'scope' => '',
            ],
        ]);
        

         return $this->showOne($user, 201);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
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
