<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\Admin;
use App\Models\Shop;
use App\Models\Partner;
use App\Models\Staff;

class UserManagementController extends Controller
{
    public function admins(Request $request) {
        $NUM_PAGE = 20;
        $account_admins = Admin::paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend.users.admin')->with('NUM_PAGE',$NUM_PAGE)
                                          ->with('page',$page)
                                          ->with('account_admins',$account_admins);
    }

    public function deleteAccountAdmin($id) {
        Admin::destroy($id);
        return back();
    }

    public function editAccountAdmin(Request $request) {
        $id = $request->get('id');
        $admin = Admin::findOrFail($id);
        $admin->update($request->all());
        $admin->save();
        return back();
    }

    public function partners(Request $request) {
        $NUM_PAGE = 20;
        $shops = Shop::where('is_active','1')->get();
        $partners = Partner::paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend.users.partner')->with('NUM_PAGE',$NUM_PAGE)
                                            ->with('page',$page)
                                            ->with('shops',$shops)
                                            ->with('partners',$partners);
    }

    public function addPartner(Request $request) {
        $request->validate([
            'shop_id' => 'required',
            'name' => 'required',
            'tel' => 'required',
        ], [
            'shop_id.required' => 'กรุณาเลือกร้านค้า',
            'name.required' => 'กรุณาระบุชื่อผู้ใช้งาน',
            'tel.required' => 'กรุณาระบุเบอร์โทร (Username)',
        ]);

        $partner = $request->all();
        $partner['password'] = Hash::make($partner['password_name']);
        $partner = Partner::create($partner);
        $request->session()->flash('alert-success', 'เพิ่มบัญชีผู้ใช้ร้านค้าสำเร็จ');
        return redirect()->intended(route('users.partners.index'));
    }

    public function deleteAccountPartner($id) {
        Partner::destroy($id);
        return back();
    }

    public function editAccountPartner(Request $request) {
        $id = $request->get('id');
        $partner = Partner::findOrFail($id);
        $partner->update($request->all());
        $partner->save();
        return back();
    }

    public function staffs($id) {
        $partner_id = $id;
        $staffs = Staff::where('partner_id',$id)->get();
        return view('backend.users.staff')->with('partner_id',$partner_id)
                                          ->with('staffs',$staffs);
    }

    public function addStaff(Request $request) {
        
        $request->validate([
            'name' => 'required',
            'tel' => 'required',
            'username' => 'required',
        ], [
            'name.required' => 'กรุณาระบุชื่อ-นามสกุล',
            'tel.required' => 'กรุณาระบุเบอร์โทร',
            'username' => 'กรุณาระบุชื่อเข้าใช้งาน'
        ]);

        $staff = $request->all();
        $staff['password'] = Hash::make($staff['password_name']);
        $staff = Staff::create($staff);
        $request->session()->flash('alert-success', 'เพิ่มบัญชีพนักงานสำเร็จ');
        return back();
    }

    public function deleteAccountStaff($id) {
        Staff::destroy($id);
        return back();
    }

    public function editAccountStaff(Request $request) {
        $id = $request->get('id');
        $staff = Staff::findOrFail($id);
        $staff->update($request->all());
        $staff->save();
        return back();
    }
}
