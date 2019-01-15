<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\IdentityCheck;
use App\Admin;
use App\User;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
       // echo
        //die();

        $admins = Admin::all();
 

        return view('admin',['admins' => $admins]);
    }

    public function showRegisterForm()
    {
        return view('admin-register');
    }


    public function create(Request $request)
    {
       
          //validate the form data 
        $this->validate($request,[
            'email' => 'required|email',
            'password' => 'required|:min:6' 
        ]);
        
        $admin = new Admin;
        $admin->email = $request->email;
        $admin->password =  Hash::make($request->password);
        $admin->save();

        return redirect()->route('admin.dashboard'); 
    }
    
    public function edit($id)
    {
        $admin = Admin::find($id);

        return view('admin-edit',['admin' =>$admin]);
    }

 
    public function update(Request $request,$id)
    {
        

             //validate the form data 
             $this->validate($request,[
                'email' => 'required|email',
                'password' => 'required|:min:6' 
            ]);
            
            $admin = Admin::find($id);
            $admin->email = $request->email;
            $admin->password =  Hash::make($request->password);
            $admin->save();
    
            return redirect()->route('admin.dashboard'); 
        }


        public function destroy($id)
        {
            $admin = Admin::find($id);
            $admin->delete();
            return redirect()->route('admin.dashboard'); 
        }


        public function showUsers()
        {
            
            $users = User::all();


            return view('admin-user',['users'=>$users]);
        }

        public function loginAsUser($id)
        {
            $user = User::find($id);

           Auth::guard('web')->login($user);
            
            return redirect()->route('showuserprofile');   
        }

        public function destroyUser($id)
        {
            $user = User::find($id);
            $user->delete();

            return redirect()->route('admin.users'); 
        }

        public function showUserRegisterForm(Request $request)
        {

            return view('admin-register-user');  
        }
        public function createUser(Request $request)
        {
            $this->validate($request, [
                'first_name' => 'required', 'string', 'max:255',
                'last_name' => 'required', 'string', 'max:255',
                'email' => 'required', 'string', 'email', 'max:255', 'unique:users',
                'password' => 'required', 'string', 'min:6', 'confirmed',
                'tckn' => 'required', 'string', 'size:11', 'unique:users'
            ]);

          

            $identityCheck = IdentityCheck::soapIdentityCheck($request->tckn,$request->first_name.' '.$request->last_name ,$request->birthyear);
        
            // if(!$algorithmCheck){return view('auth.register',['tckn_error' => 'Lütfen Geçerli Bir T.C Kimlik Numarası Girin.']);}
             if(!$identityCheck){return view('auth.register');['tckn_error' => 'Lütfen Geçerli Kimlik Bilgileri Girin.'];}
     
     
              User::create([
                 'first_name' =>$request->first_name,
                 'last_name' => $request->last_name,
                 'email' =>$request->email,
                 'password' => Hash::make($request->password),
                 'tckn' => $request->tckn,
                 'phone' => $request->phone,
                 'birthyear' => $request->birthyear,
             ]);

             return redirect()->route('admin.users'); 

        }



}
