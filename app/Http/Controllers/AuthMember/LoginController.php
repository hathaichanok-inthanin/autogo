<?php

namespace App\Http\Controllers\AuthMember;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Member;
use Validator;

class LoginController extends Controller
{
    public function __construct(){
        $this->middleware('guest:member')->except('logout');
    }

    public function showLoginForm(){
        return view('authMember.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'กรุณากรอกอีเมล',
            'email.email' => 'รูปแบบอีเมลไม่ถูกต้อง',
            'password.required' => 'กรุณากรอกรหัสผ่าน',
        ]);

        if (Auth::guard('member')->attempt(
            ['email' => $request->email, 'password' => $request->password], 
            $request->filled('remember')
        )) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'))->with('alert-success', 'เข้าสู่ระบบสำเร็จ');
        }
        return back()->withErrors([
            'email' => 'อีเมลหรือรหัสผ่านไม่ถูกต้อง',
        ])->withInput($request->only('email', 'remember'));
    }

    public function logout(Request $request){
        Auth::guard('member')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->guest(route( 'login' ));
    }
}