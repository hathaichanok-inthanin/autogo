<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Shop;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $id = $request->id;
        $qty = $request->qty;
        
        $product = Product::with('tireSpec')->find($id);
        
        if(!$product) {
            return response()->json(['status' => 'error', 'message' => 'ไม่พบสินค้า']);
        }

        // ดึงตะกร้าเดิมจาก Session (ถ้าไม่มีให้เป็น array ว่าง)
        $cart = session()->get('cart', []);

        // คำนวณราคา (เช็คว่ามีโปรโมชั่นไหม)
        $price = ($product->sale_price > 0 && $product->sale_price < $product->price) 
                 ? $product->sale_price 
                 : $product->price;

        // ถ้ามีของชิ้นนี้ในตะกร้าอยู่แล้ว ให้บวกเพิ่ม
        if(isset($cart[$id])) {
            $cart[$id]['quantity'] += $qty;
        } else {
            // ถ้ายังไม่มี ให้สร้างใหม่
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => $qty,
                "price" => $price,
                "image" => $product->tireSpec->model->model_image ?? null // เก็บชื่อรูปไว้โชว์ในตะกร้า
            ];
        }

        // บันทึกลง Session
        session()->put('cart', $cart);

        // ส่งผลลัพธ์กลับไปบอกหน้าบ้าน พร้อมจำนวนสินค้าในตะกร้าล่าสุด
        return response()->json([
            'status' => 'success', 
            'cart_count' => count($cart)
        ]);
    }

    public function index(){
        $cart = session()->get('cart', []);
        
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $branchId = session('selected_branch_id');
        $branch = $branchId ? Shop::find($branchId) : null;

        return view('frontend.cart.index', compact('cart', 'total', 'branch'));
    }

    public function proceedToCheckout(Request $request){
        $request->validate([
            'booking_date' => 'required',
            'booking_time' => 'required',
        ], [
            'booking_date.required' => 'กรุณาเลือกวันที่เข้าใช้บริการ',
            'booking_time.required' => 'กรุณาเลือกเวลาที่สะดวก',
        ]);

        session([
            'booking_date' => $request->booking_date,
            'booking_time' => $request->booking_time
        ]);

        return redirect()->route('checkout');
    }

    public function remove($id){
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'ลบสินค้าเรียบร้อยแล้ว');
    }

    public function update(Request $request){
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            
            $itemSubtotal = $cart[$request->id]['price'] * $request->quantity;

            $total = 0;
            foreach($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            return response()->json([
                'subtotal' => number_format($itemSubtotal), 
                'total'    => number_format($total)
            ]);
        }
    }
}
