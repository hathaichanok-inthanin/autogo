<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ProductCategories;
use App\Models\ProductTire;
use App\Models\TireSalePrice;
use App\Models\TirePromotionSalePrice;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use App\Models\Product;
use App\Models\TireSpec;  
use App\Models\PriceHistory; 
use App\Models\Brand;
use App\Models\ProductModel;
use App\Models\TireSize;

class ProductController extends Controller
{

    public function deleteProductTire($id) {
        TireSalePrice::where('tire_id',$id)->delete();
        TirePromotionSalePrice::where('tire_id',$id)->delete();
        ProductTire::destroy($id);
        return back();
    }
    
    public function productCategories(Request $request) {
        $product_categories = ProductCategories::get();
        return view('backend.products.product_categories')->with('product_categories',$product_categories);
    }

    public function createProductCategories(Request $request) {
        $product_category = $request->all();
        $product_category = ProductCategories::create($product_category);
        $request->session()->flash('alert-success', 'เพิ่มหมวดหมู่สินค้าสำเร็จ');
        return back();
    }

    public function editProductCategories(Request $request) {
        $id = $request->get('id');
        $category = ProductCategories::findOrFail($id);
        $category->update($request->all());
        $category->save();
        return back();
    }

    public function deleteProductCategories($id) {
        ProductCategories::destroy($id);
        return back();
    }

    public function productBrand(Request $request) {
        $NUM_PAGE = 30;
        $product_brands = Brand::withCount('tireSpecs')
                                               ->paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend.products.product_brand')->with('NUM_PAGE',$NUM_PAGE)
                                                     ->with('page',$page)
                                                     ->with('product_brands',$product_brands);
    }

    public function createProductBrand(Request $request) {
        $product_brands = $request->all();
        $product_brands = Brand::create($product_brands);

        if($request->hasFile('brand_image')){
            $image = $request->file('brand_image');
            $filename = md5(($image->getClientOriginalName(). time()) . time()) . "_o." . $image->getClientOriginalExtension();
            $image->move('image_upload/brand_image/', $filename);
            $path = 'image_upload/brand_image/'.$filename;
            $product_brands->brand_image = $filename;
            $product_brands->save();
        }

        $request->session()->flash('alert-success', 'เพิ่มแบรนด์สินค้าสำเร็จ');
        return back();
    }

    public function deleteProductBrand($id) {
        Brand::destroy($id);
        return back();
    }

    public function updateProductBrand(Request $request) {
        $id = $request->get('id');
        $brand = Brand::findOrFail($id);
        $brand->update($request->all());
        if($request->hasFile('brand_image')){
            $image = $request->file('brand_image');
            $filename = md5(($image->getClientOriginalName(). time()) . time()) . "_o." . $image->getClientOriginalExtension();
            $image->move('image_upload/brand_image/', $filename);
            $path = 'image_upload/brand_image/'.$filename;
            $brand->brand_image = $filename;
            $brand->update();
        }
        $brand->save();
        return redirect()->route('brands.index')->with('success', 'อัพเดตข้อมูลแบรนด์สำเร็จ');
    }

    public function searchBrand(Request $request) {
        $NUM_PAGE = 30;

        $query = Brand::withCount('tireSpecs');

        if ($request->filled('brand')) {
            $keyword = $request->input('brand');
            $query->where('brand_name', 'LIKE', "%{$keyword}%");
        }

        if ($request->filled('status') && $request->input('status') !== 'all') {
            $status = $request->input('status');
            $query->where('status', $status);
        }

        $product_brands = $query->orderBy('id','desc')->paginate($NUM_PAGE);
        $product_brands->appends($request->all());

        $page = $request->input('page', 1);

       return view('backend.products.product_brand')->with('NUM_PAGE',$NUM_PAGE)
                                                     ->with('page',$page)
                                                     ->with('product_brands',$product_brands);
    }

    public function productModel(Request $request) {
        $NUM_PAGE = 20;
        $product_brands = Brand::get();
        $product_models = ProductModel::withCount('tireSpecs')
                                      ->paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend.products.product_model')->with('NUM_PAGE',$NUM_PAGE)
                                                     ->with('page',$page)
                                                     ->with('product_brands',$product_brands)
                                                     ->with('product_models',$product_models);
    }

    public function createProductModel(Request $request) {
        $product_model = $request->all();

        if ($request->has('features')) {
            $data['features'] = json_encode($request->features, JSON_UNESCAPED_UNICODE);
        }

        $product_model = ProductModel::create($product_model);

        if($request->hasFile('model_image')){
            $image = $request->file('model_image');
            $filename = md5(($image->getClientOriginalName(). time()) . time()) . "_o." . $image->getClientOriginalExtension();
            $image->move('image_upload/model_image/', $filename);
            $path = 'image_upload/model_image/'.$filename;
            $product_model->model_image = $filename;
            $product_model->save();
        }

        $request->session()->flash('alert-success', 'เพิ่มรุ่นสินค้าสำเร็จ');
        return back();
    }

    public function deleteProductModel($id) {
        ProductModel::destroy($id);
        return back();
    }

    public function updateProductModel(Request $request) {
        $id = $request->get('id');
        $model = ProductModel::findOrFail($id);

        $input = $request->all();

        if (!$request->has('features')) {
            $input['features'] = null;
        }

        $model->fill($input);

        if($request->hasFile('model_image')){
            $image = $request->file('model_image');
            $filename = md5(($image->getClientOriginalName(). time()) . time()) . "_o." . $image->getClientOriginalExtension();
            $image->move('image_upload/model_image/', $filename);
            if($model->model_image) { @unlink('image_upload/model_image/'.$model->model_image); } //ลบรูปเก่าทิ้ง
            $model->model_image = $filename;
        }

        $model->save();
        return redirect()->route('product_models.index')->with('success', 'อัพเดตข้อมูลรุ่นสินค้าสำเร็จ');
    }

    public function searchModel(Request $request) {
        $NUM_PAGE = 30;

        $product_brands = Brand::get();

        $query = ProductModel::query();

        if ($request->filled('model_name')) {
            $query->where('model_name', 'LIKE', '%' . $request->model_name . '%');
        }

        if ($request->filled('brand') && $request->brand != 'all') {
            $query->where('brand_id', $request->brand);
        }

        if ($request->filled('typecar') && $request->typecar != 'all') {
            $query->where('type_car', $request->typecar);
        }

        $product_models = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend.products.product_model')->with('NUM_PAGE',$NUM_PAGE)
                                                     ->with('page',$page)
                                                     ->with('product_brands',$product_brands)
                                                     ->with('product_models',$product_models);
    }

    // ลองเขียนแบบใหม่
    public function products(Request $request) {
        $query = Product::with(['tireSpec.model', 'tireSpec.brand', 'tireSpec']);

        // ค้นหาขนาดยาง
        if ($request->filled('full_size')) {
            $fullSize = $request->full_size;
            if (preg_match('/(\d{3})[\/\s-]*(\d{2})[\/\s-]*R?(\d{2})/i', $fullSize, $matches)) {
                $w = $matches[1];
                $r = $matches[2];
                $rim = $matches[3];

                $query->whereHas('tireSpec', function($q) use ($w, $r, $rim) {
                    $q->where('width', $w)
                    ->where('ratio', $r)
                    ->where('rim', $rim);
                });
            } else {
                $query->where('name', 'like', "%$fullSize%");
            }
        }

        // ค้นหาจาก Keyword (ชื่อสินค้า หรือ SKU)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                ->orWhere('sku', 'like', "%$search%");
            });
        }

        // กรองหน้ากว้าง (Width) - โดยเจาะเข้าไปหาในตาราง tireSpec
        if ($request->filled('width')) {
            $query->whereHas('tireSpec', function($q) use ($request) {
                $q->where('width', $request->width);
            });
        }

        // กรองขอบยาง (Rim)
        if ($request->filled('rim')) {
            $query->whereHas('tireSpec', function($q) use ($request) {
                $q->where('rim', $request->rim);
            });
        }

        // ดึงข้อมูลสินค้า
        $products = $query->latest()->paginate('30');
        $products->appends($request->all());

        $widths = TireSpec::distinct()->orderBy('width', 'asc')->pluck('width');
        $rims   = TireSpec::distinct()->orderBy('rim', 'asc')->pluck('rim');


        return view('backend.products.index')->with('products', $products)
                                             ->with('widths',$widths)
                                             ->with('rims',$rims);
}

    public function create(){
        $product_brands = Brand::get();
        $tire_sizes = TireSize::select('id', 'size')
                              ->orderBy('size', 'asc')
                              ->get();
        return view('backend.products.create')->with('product_brands',$product_brands)
                                              ->with('tire_sizes',$tire_sizes);
    }

    public function store(Request $request){
        $request->validate([
            'product_type' => 'required|in:tire',
            'brand_id'     => 'required|exists:brands,id',
            'model_id'     => 'required|exists:models,id',
            'tire_size_id' => 'required',
            'price'        => 'required|numeric',
            'cost_price'   => 'nullable|numeric',
            'year'         => 'required|numeric',
        ]);

        $brand = Brand::findOrFail($request->brand_id);
        $model = ProductModel::findOrFail($request->model_id);
        $tireSizeObj = TireSize::findOrFail($request->tire_size_id); 
        
        $sizeString = $tireSizeObj->size; 

        preg_match('/(\d+)\/(\d+)R(\d+)/i', $sizeString, $matches);
        $width = $matches[1] ?? 0;
        $ratio = $matches[2] ?? 0;
        $rim   = $matches[3] ?? 0;

        $generatedName = $brand->brand_name . ' ' . $model->model_name . ' ' . $sizeString;

        DB::transaction(function () use ($request, $generatedName, $width, $ratio, $rim) {
            
            // --- STEP 1: บันทึกตารางแม่ (Products) ---
            $product = Product::create([
                'product_type' => 'tire',
                'brand_id'     => $request->brand_id,
                'model_id'     => $request->model_id,
                'sku'          => $request->sku,  
                'name'         => $generatedName,
                'slug'         => Str::slug($generatedName) . '-' . time(),
                'price'        => $request->price,
                'cost_price'   => $request->cost_price ?? 0,
                'sale_price'   => $request->sale_price,
                'is_active'    => $request->is_active ?? 1,
                'is_featured'  => $request->is_featured ?? 0,
            ]);

            // --- STEP 2: บันทึกตารางลูก (Tire Specs) ---
            if ($request->product_type === 'tire') {
                TireSpec::create([
                    'product_id'   => $product->id,
                    'brand_id'     => $request->brand_id,
                    'model_id'     => $request->model_id,
                    'width'        => $width,          
                    'ratio'        => $ratio,
                    'rim'          => $rim,
                    'speed_symbol' => $request->speed_symbol,
                    'load_index'   => $request->load_index,
                    'year'         => $request->year,
                    'dot'          => $request->dot,
                    'type_car'     => $request->type_car,
                    'runflat'      => $request->runflat,
                    'features'     => $request->features,
                    'ev'           => $request->ev,
                ]);
            }

            // --- STEP 3: บันทึกประวัติราคา (Price Histories) ---
            PriceHistory::create([
                'product_id' => $product->id,
                'cost_price' => $request->cost_price ?? 0,
                'price'      => $request->price,
                'sale_price' => $request->sale_price,
            ]);
        });

        return redirect()->route('products.index')->with('success', 'เพิ่มสินค้าเรียบร้อยแล้ว (SKU: '.$request->sku.')');
    }

    public function edit($id) {
        $product = Product::with('tireSpec')->findOrFail($id);
        $product_brands = Brand::all();

        $brandId = optional($product->tireSpec)->brand_id;

        $product_models = ProductModel::where('brand_id', $brandId)->get();
        $tire_sizes = TireSize::all();
        
        return view('backend.products.edit')->with('product_brands',$product_brands)
                                            ->with('product_models',$product_models)
                                            ->with('tire_sizes',$tire_sizes)
                                            ->with('product',$product);
    }

    public function update(Request $request){
        $request->validate([
            'brand_id'     => 'required',
            'model_id'     => 'required',
            'tire_size_id' => 'required',
            'price'        => 'required|numeric',
            'year'         => 'required',
        ]);

        $id = $request->get('id');
        $product = Product::findOrFail($id);

        $tireSizeObj = TireSize::findOrFail($request->tire_size_id);
        $sizeString = $tireSizeObj->size;

        preg_match('/(\d+)\/(\d+)R(\d+)/i', $sizeString, $matches);
        $width = $matches[1] ?? 0;
        $ratio = $matches[2] ?? 0;
        $rim   = $matches[3] ?? 0;

        $brand = Brand::findOrFail($request->brand_id);
        $model = ProductModel::findOrFail($request->model_id);
        $generatedName = $brand->brand_name . ' ' . $model->model_name . ' ' . $sizeString;

        DB::transaction(function () use ($request, $product, $generatedName, $width, $ratio, $rim) {
            
            $priceChanged = (
                $product->price != $request->price ||
                $product->cost_price != $request->cost_price || 
                $product->sale_price != $request->sale_price
            );

            $product->update([
                'name'         => $generatedName,
                'slug'         => Str::slug($generatedName) . '-' . $product->id, 
                'price'        => $request->price,
                'cost_price'   => $request->cost_price,
                'sale_price'   => $request->sale_price,
                'is_active'    => $request->has('is_active') ? 1 : 0,
                'is_featured'  => $request->has('is_featured') ? 1 : 0,
            ]);

            $product->tireSpec()->updateOrCreate(
                ['product_id' => $product->id],
                [
                    'brand_id'     => $request->brand_id,
                    'model_id'     => $request->model_id,
                    'width'        => $width,
                    'ratio'        => $ratio,
                    'rim'          => $rim,
                    'speed_symbol' => $request->speed_symbol,
                    'load_index'   => $request->load_index,
                    'year'         => $request->year,
                    'dot'          => $request->dot,
                    'type_car'     => $request->type_car,
                    'runflat'      => $request->runflat,
                    'features'     => $request->features,
                    'ev'           => $request->ev,
                ]
            );

            if ($priceChanged) {
                PriceHistory::create([
                    'product_id' => $product->id,
                    'cost_price' => $request->cost_price,
                    'price'      => $request->price,
                    'sale_price' => $request->sale_price,
                    'updated_by_user_id' => auth()->id(),
                ]);
            }
        });

        return redirect()->route('products.index')->with('success', 'แก้ไขสินค้าเรียบร้อยแล้ว');
    }

    public function destroy($id){
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->back()->with('success', 'ลบสินค้าเรียบร้อยแล้ว (ย้ายไปถังขยะ)');
    }

    public function getPriceHistory($id){
        $product = Product::with(['priceHistories.admin', 'priceHistories' => function($q) {
            $q->orderBy('created_at', 'desc');
        }])->findOrFail($id);

        return view('backend.products.partials.price_history_modal', compact('product'))->render();
    }

    public function tireSize(Request $request) {
        $NUM_PAGE = 50;
        $tire_sizes = TireSize::addSelect([
            'products_count' => TireSpec::selectRaw('count(*)')
                ->whereColumn('tire_specs.width', 'tire_sizes.width')
                ->whereColumn('tire_specs.ratio', 'tire_sizes.ratio')
                ->whereRaw("REPLACE(tire_specs.rim, 'R', '') = REPLACE(tire_sizes.rim, 'R', '')")
        ])
        ->paginate($NUM_PAGE);

        $widths = TireSize::distinct()->orderBy('width', 'asc')->pluck('width');
        $rims   = TireSize::distinct()->orderBy('rim', 'asc')->pluck('rim');

        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend.products.tire_size')->with('NUM_PAGE',$NUM_PAGE)
                                                 ->with('page',$page)
                                                 ->with('tire_sizes',$tire_sizes)
                                                 ->with('widths',$widths)
                                                 ->with('rims',$rims);
    }

    public function createTireSize(Request $request) {
        $width = $request->get('width');
        $ratio = $request->get('ratio');
        $rim = $request->get('rim');

        $tire_size = new TireSize;
        $tire_size->size = $width . '/' . $ratio . $rim;
        $tire_size->width = $width;
        $tire_size->ratio = $ratio;
        $tire_size->rim = $rim;

        $tire_size->save();

        $request->session()->flash('alert-success', 'เพิ่มขนาดยางใหม่สำเร็จ');
        return back();
    }

    public function searchSize(Request $request) {
        $NUM_PAGE = 20;

        $widths = TireSize::select('width')->distinct()->orderBy('width', 'asc')->pluck('width');
        $rims   = TireSize::select('rim')->distinct()->orderBy('rim', 'asc')->pluck('rim');

        $query = TireSize::query();

        $query->addSelect([
            'products_count' => TireSpec::selectRaw('count(*)')
                ->whereColumn('tire_specs.width', 'tire_sizes.width')
                ->whereColumn('tire_specs.ratio', 'tire_sizes.ratio')
                ->whereRaw("REPLACE(tire_specs.rim, 'R', '') = REPLACE(tire_sizes.rim, 'R', '')")
        ]);

        if ($request->filled('full_size')) {
            $query->where('size', 'like', "%{$request->full_size}%");
        }

        if ($request->filled('width')) {
            $query->where('width', $request->width);
        }

        if ($request->filled('ratio')) {
            $query->where('ratio', $request->ratio);
        }

        if ($request->filled('rim')) {
            $query->where('rim', $request->rim);
        }

        $tire_sizes = $query->orderBy('width')
                            ->orderBy('rim')
                            ->orderBy('ratio')
                            ->paginate($NUM_PAGE);
                            
        $tire_sizes->appends($request->all());

        return view('backend.products.tire_size', compact('widths', 'rims', 'tire_sizes'));
    }

    public function deleteTireSize($id) {
        TireSize::destroy($id);
        return back();
    }
}
