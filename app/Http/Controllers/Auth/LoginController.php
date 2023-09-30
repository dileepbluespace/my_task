<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class LoginController extends Controller
{
    public function showAdminLoginForm()
    {
     
        if (Auth::check()) {
            return redirect()->route('admin.dshboard'); // Redirect to the admin dashboard
        }else{
            return view('auth.login');
        }
        
    }

    public function logout(){

        Auth::logout();
        return view('auth.login');
    }
    public function adminlogin(Request $request){
        $credentials = $request->only('email', 'password');
 
        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->route('admin.dshboard');
        }else{
            $errors = "username or password are not correct";
             return redirect()->route('admin.login')->withErrors($errors);
        }
    }
}
