<?php

namespace App\Http\Controllers\AuthAdmin;

use App\Models\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterAdminController extends Controller
{
    public function ShowRegisterForm(){
        return view('authAdmin/register');
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(), $this->rules_register(), $this->messages_register());
        if($validator->passes()) {
            $admin = $request->all();
            $admin['password'] = Hash::make($admin['password_name']);
            $admin = Admin::create($admin);
            $request->session()->flash('alert-success', 'เพิ่มแอดมินสำเร็จ');
            return redirect()->intended(route('admin.dashboard'));
        }
        else {
            $request->session()->flash('alert-danger', 'เพิ่มแอดมินไม่สำเร็จ กรุณาตรวจสอบข้อมูล');
            return back()->withErrors($validator)->withInput();
        }
    }

    public function rules_register() {
        return [
            'name' => 'required',
            'username' => 'required|unique:admin',
            'password_name' => 'required|min:6',
        ];
    }

    public function messages_register() {
        return [
            'name.required' => 'กรุณากรอกชื่อผู้ใช้งาน',
            'username.required' => 'กรุณากรอกชื่อเข้าใช้งานระบบ',
            'username.unique' => 'username นี้มีผู้ใช้งานแล้ว',
            'password_name.required' => 'กรุณากรอกรหัสผ่าน',
        ];
    }
}
