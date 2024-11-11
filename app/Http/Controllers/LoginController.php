<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $user = $request->only('email','password');
        if (Auth::attempt($user)) {
            return redirect()->route('landing_page');
        } else {
            return redirect()->back()->with('error','Gagal login, silahkan cek dan coba lagi');
        }
    }
    public function logout()
{
	Auth::logout();
	return redirect('/');
}
}
