<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    function Index(){
        if (!Auth::guest()){
            return redirect(route("home"));
        }
        return view("auth/login");
    }

    function Login(Request $request){
        $this->validate($request,[
            'email'=>'required|regex:/(.+)@(.+)\.(.+)/i',
            'password' => 'required',
         ]);
         if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect(route("home"));
         }else{
            Session::flash("err", "Invalid login credentials!");      
            return redirect(url("login"));
         }
    }

    function Register(){
        if (!Auth::guest()){
            return redirect(route("home"));
        }
        return view("auth/register");
    }

    function StoreUser(Request $request){
        $this->validate($request,[
            'name'=>'required|max:12',
            'email'=>'required|regex:/(.+)@(.+)\.(.+)/i|unique:users,email',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6',
         ]);
         $data = array(
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password)
         );
         User::insert($data);
         Session::flash("reg", "Yuo have registed successfully.");
         return redirect(url("login"));
    }

    function Logout(){
        Auth::logout();
        return redirect(url('login'));
    }
}
