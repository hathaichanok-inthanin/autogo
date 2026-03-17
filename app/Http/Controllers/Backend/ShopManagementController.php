<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

use App\Models\Shop;

class ShopManagementController extends Controller
{
    public function index(Request $request){
        $shops = Shop::orderBy('created_at', 'desc');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $shops->where(function($q) use ($search) {
                $q->where('shop_name', 'LIKE', "%{$search}%")
                ->orWhere('branch_name', 'LIKE', "%{$search}%")
                ->orWhere('phone', 'LIKE', "%{$search}%")
                ->orWhere('province', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('status') && $request->input('status') !== 'all') {
            $status = $request->input('status');
            $shops->where('is_active', $status);
        }

        $shops = $shops->paginate(10);

        return view('backend.shops.index', compact('shops'));
    }

    public function store(Request $request){
        $request->validate([
            'shop_name' => 'required|string|max:255',
            'shop_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'email' => 'required|email|unique:shops,email',
            'password' => 'required|string|min:6', 
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'zipcode' => 'required|string|max:10',
        ], [
            'shop_name.required' => 'กรุณาระบุชื่อร้านค้า',
            'email.unique' => 'อีเมลนี้ถูกใช้งานไปแล้ว',
            'latitude.required' => 'กรุณาระบุพิกัด Latitude',
            'longitude.required' => 'กรุณาระบุพิกัด Longitude',
        ]);

        try {
            $data = $request->all();
            
            $data['is_active'] = $request->has('is_active') ? 1 : 0;
            $data['password'] = Hash::make($request->password); 

            if($request->hasFile('shop_image')){
                $image = $request->file('shop_image');
                $filename = md5(($image->getClientOriginalName(). time()) . time()) . "_o." . $image->getClientOriginalExtension();
                $image->move(public_path('image_upload/shop_image/'), $filename);
                $data['shop_image'] = $filename; 
            }

            Shop::create($data);

            return redirect()->back()->with('success', 'เพิ่มร้านค้าเรียบร้อยแล้ว');

        } catch (\Exception $e) {
            // Log::error($e->getMessage());
            dd($e->getMessage());
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage());
        }
    }

    public function searchNearMe(Request $request){
        $lat = $request->lat;
        $lng = $request->lng;
        $keyword = $request->keyword;
        $radius = $request->radius ?? 10;

        $query = Shop::query()->where('is_active', 1);

        if ($keyword) {
            $query->where(function($q) use ($keyword) {
                $q->where('shop_name', 'LIKE', "%{$keyword}%")
                ->orWhere('address_text', 'LIKE', "%{$keyword}%")
                ->orWhere('district', 'LIKE', "%{$keyword}%")
                ->orWhere('zipcode', 'LIKE', "%{$keyword}%");
            });
        }

        if ($lat && $lng) {
            $query->select('*')
                ->selectRaw(
                    '( 6371 * acos( cos( radians(?) ) *
                    cos( radians( latitude ) ) *
                    cos( radians( longitude ) - radians(?) ) +
                    sin( radians(?) ) *
                    sin( radians( latitude ) ) ) ) AS distance', 
                    [$lat, $lng, $lat]
                )
                ->having('distance', '<=', $radius)
                ->orderBy('distance', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $shops = $query->get();

        return response()->json($shops);
    }

    public function destroy($id) {
        Shop::destroy($id);
        return back();
    }

    public function shopEdit(Request $request) {
        $request->validate([
            'shop_name' => 'required|string|max:255',
            'shop_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'zipcode' => 'required|string|max:10',
        ], [
            'shop_name.required' => 'กรุณาระบุชื่อร้านค้า',
            'latitude.required' => 'กรุณาระบุพิกัด Latitude',
            'longitude.required' => 'กรุณาระบุพิกัด Longitude',
        ]);

        $id = $request->get('id');
        $shop = Shop::findOrFail($id);

        $data = $request->all();
        
        if($request->hasFile('shop_image')){

            if($shop->shop_image && file_exists(public_path('image_upload/shop_image/'.$shop->shop_image))){
                unlink(public_path('image_upload/shop_image/'.$shop->shop_image));
            }

            $image = $request->file('shop_image');
            $filename = md5(($image->getClientOriginalName(). time()) . time()) . "_o." . $image->getClientOriginalExtension();
            $image->move('image_upload/shop_image/', $filename);

            $data['shop_image'] = $filename;
        }

        $shop->update($data);
        return back()->with('success', 'แก้ไขข้อมูลเรียบร้อยแล้ว');
    }
}
