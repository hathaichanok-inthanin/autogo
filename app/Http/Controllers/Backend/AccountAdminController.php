<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Admin;

class AccountAdminController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
    }
    
    public function accountAdmin(Request $request) {
        $NUM_PAGE = 30;
        $account_admins = Admin::paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/user/admin')->with('NUM_PAGE',$NUM_PAGE)
                                                        ->with('page',$page)
                                                        ->with('account_admins',$account_admins);
    }
}
