<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Toastr;

class CustomAuth extends Controller
{
    public function login()
    {
        return view('auth.login');
    }
    public function postLogin(Request $request)
    {
        if (\Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'owner'
        ])) {

            Toastr::success('Selamat Datang ' . Auth::user()->name , 'Success');
            return redirect(route('home'));
        }
        elseif (\Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'admin'
        ])) {

            Toastr::success('Selamat Datang ' . Auth::user()->name , 'Success');
            return redirect(route('home'));
        }
        else
        {
            Toastr::error('Username atau Password anda salah!', 'Error', ["positionClass" => "toast-top-right"]);
            return redirect('/');
        }




    }

    public function customLogout()
    {
        Auth::logout();

        return redirect('/');
    }
}
