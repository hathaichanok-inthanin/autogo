<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\TireSize;
use App\Models\Shop;
use App\Models\ContactUs;

class FrontendController extends Controller
{
    public function index() {
        $widths = TireSize::select('width')->distinct()->orderBy('width', 'asc')->pluck('width');
        $ratios = TireSize::select('ratio')->distinct()->orderBy('ratio', 'asc')->pluck('ratio');
        $rims = TireSize::select('rim')->distinct()->orderBy('rim', 'asc')->pluck('rim');
        return view('frontend/index')->with('widths',$widths)
                                     ->with('ratios',$ratios)
                                     ->with('rims',$rims);
    }

    public function contactUs() {
        $shops = Shop::where('is_active','1')->get();
        return view('frontend/system/contact-us')->with('shops',$shops);
    }

    public function contactUsPost(Request $request) {
        $contact = $request->all();
        $contact = ContactUs::create($contact);
        $request->session()->flash('alert-success', 'ยื่นข้อมูลติดต่อเราสำเร็จ กรุณารอการติดต่อกลับ ภายใน 15 วันทำการ');
        return back();
    }

    public function promotion() {
        return view('frontend/system/promotion');
    }

    public function branch() {
        $shops = Shop::orderBy('created_at', 'desc')->get();
        return view('frontend/system/branch')->with('shops',$shops);
    }

    public function branchDetail($id) {
        $branch = Shop::findOrFail($id);
        return view('frontend/system/branch-detail')->with('branch',$branch);
    }

    public function aboutUs() {
        return view('frontend/system/about-us');
    }

    public function howToOrder() {
        return view('frontend/system/how-to-order');
    }

    public function frequentlyAskedQuestions() {
        return view('frontend/system/frequently-asked-questions');
    }
}
