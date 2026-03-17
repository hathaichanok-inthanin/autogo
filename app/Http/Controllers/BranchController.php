<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Shop;

class BranchController extends Controller
{
    public function index()
    {
        return view('branches.search');
    }

    public function search(Request $request)
    {
        $lat = $request->input('lat');
        $lng = $request->input('lng');
        $radius = $request->input('distance', 10); // ค่า Default 10 km
        $keyword = $request->input('keyword');

        $branches = Shop::query();

        // กรณีมีพิกัด (กดปุ่มระบุตำแหน่ง หรือแปลงที่อยู่เป็นพิกัดมาแล้ว)
        if ($lat && $lng) {
            $branches->selectRaw("*,
                ( 6371 * acos( cos( radians(?) ) *
                  cos( radians( latitude ) ) *
                  cos( radians( longitude ) - radians(?) ) +
                  sin( radians(?) ) *
                  sin( radians( latitude ) ) )
                ) AS distance", [$lat, $lng, $lat])
                ->having('distance', '<=', $radius)
                ->orderBy('distance');
        } 
        // กรณีค้นหาด้วย Text (ชื่อ หรือ รหัสไปรษณีย์)
        elseif ($keyword) {
            $branches->where(function($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('zipcode', 'like', "%{$keyword}%")
                  ->orWhere('address', 'like', "%{$keyword}%");
            });
        }

        return response()->json($branches->get());
    }

    public function selectBranch($id){
        $shop = Shop::findOrFail($id);

        session()->put('selected_branch_id', $shop->id);
        session()->put('selected_shop_name', $shop->shop_name);
        session()->put('selected_branch_name', $shop->branch_name);

        session()->save();
        return redirect()->route('cart.index');
    }
}