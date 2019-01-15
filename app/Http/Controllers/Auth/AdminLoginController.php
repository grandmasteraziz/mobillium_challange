<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth; 

class AdminLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin' , ['except' => ['logout']]);
    }

    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {

        //validate the form data 
        $this->validate($request,[
            'email' => 'required|email',
            'password' => 'required|:min:6' 
            
        ]);


        // attempt to log the  user in 
        $isLogged = Auth::guard('admin')->attempt([
            'email' => $request->email ,
            'password' => $request->password 
        ],$request->remember);

        // if successful, then redirect to their intendet location
        if($isLogged)
        {
            //TODO : if user is banned control!!


            return redirect()->intended(route('admin.dashboard'));
        }

        // if unsuccessful , then redirect back to the login with the form data 

        return redirect()->back()->withInput($request->only('email','remember'));
    }

       /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        return redirect('/');
    }
}
