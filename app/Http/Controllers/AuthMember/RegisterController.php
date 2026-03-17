<?php

namespace App\Http\Controllers\AuthMember;

use App\Models\Member;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use Carbon\Carbon;

class RegisterController extends Controller
{
    public function ShowRegisterForm(){
        return view('authMember/register');
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(), $this->rules_register(), $this->messages_register());

        if($validator->passes()) {
            $data = $request->all();

            if (!empty($data['bday'])) {
                try {
                    $data['bday'] = Carbon::createFromFormat('d/m/Y', $data['bday'])->format('Y-m-d');
                } catch (\Exception $e) {
                    $data['bday'] = null;
                }
            }

            $data['password'] = Hash::make($data['password']);

            $member = Member::create($data);

            Auth::guard('member')->login($member);

            $request->session()->flash('alert-success', 'ลงทะเบียนสมาชิกสำเร็จ ยินดีต้อนรับครับ');
            return redirect()->route('home');
        }
        else {
            $request->session()->flash('alert-danger', 'ลงทะเบียนไม่สำเร็จ กรุณาตรวจสอบข้อมูล');
            return back()->withErrors($validator)->withInput();
        }
    }

    public function rules_register() {
        return [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'tel' => 'required|numeric',
            'email' => 'required|email|unique:members',
            'password' => 'required|min:6|confirmed',
            'address' => 'required',
            'subdistrict' => 'required',
            'district' => 'required',
            'province' => 'required',
            'zipcode' => 'required',
        ];
    }

    public function messages_register() {
        return [
            'name.required' => 'กรุณากรอกชื่อ',
            'surname.required' => 'กรุณากรอกนามสกุล',
            'tel.required' => 'กรุณากรอกเบอร์โทรศัพท์',
            'tel.numeric' => 'เบอร์โทรศัพท์ต้องเป็นตัวเลขเท่านั้น',
            'email.required' => 'กรุณากรอกอีเมล',
            'email.email' => 'รูปแบบอีเมลไม่ถูกต้อง',
            'email.unique' => 'อีเมลนี้มีผู้ใช้งานแล้ว',
            'password.required' => 'กรุณากรอกรหัสผ่าน',
            'password.min' => 'รหัสผ่านต้องมีอย่างน้อย 6 ตัวอักษร',
            'password.confirmed' => 'การยืนยันรหัสผ่านไม่ตรงกัน',
            'address.required' => 'กรุณากรอกที่อยู่',
            'subdistrict.required' => 'กรุณากรอกตำบล / แขวง',
            'district.required' => 'กรุณากรอกอำเภอ / เขต',
            'province.required' => 'กรุณากรอกจังหวัด',
            'zipcode.required' => 'กรุณากรอกรหัสไปรษณีย์',
        ];
    }
}
