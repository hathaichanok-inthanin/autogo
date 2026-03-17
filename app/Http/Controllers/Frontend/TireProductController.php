<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Brand;
use App\Models\ProductModel;
use App\Models\Product;
use App\Models\TireSpec;

class TireProductController extends Controller
{
    public function productTireBrand() {
        $brands = Brand::where('status','เปิดใช้งาน')->get();
        return view('frontend/products/tire/product-tire-brand',compact('brands'));
    }

    public function productTireByBrand($brand) {
        $models = ProductModel::whereHas('brand', function ($query) use ($brand) {
            $query->where('brand_name',$brand);
        })->where('status','เปิดใช้งาน')->get();
        return view('frontend/products/tire/product-tire-by-brand',compact('brand','models'));
    }

    public function productTireByModel($brand, $model) {
        $products = Product::query()
            ->whereHas('brand', function ($query) use ($brand) {
                $query->where('brand_name', $brand);
            })
            ->whereHas('model', function ($query) use ($model) {
                $query->where('model_name', $model);
            })
            ->where('is_active', '1')
            ->get();
        return view('frontend/products/tire/product-tire-by-model',compact('brand','products','model'));
    }

    public function productTireRunflatBrand() {
        $brands = Brand::where('status', 'เปิดใช้งาน')
            ->whereHas('tireSpecs', function($query) {
                $query->where('runflat', 'ใช่');
            })
            ->get();
        return view('frontend/products/tire-runflat/product-tire-brand',compact('brands'));
    }

    public function productTireRunflatByBrand($brand) {
        $models = ProductModel::query()
                ->whereHas('tireSpecs', function($query) {
                    $query->where('runflat', 'ใช่');
                })
                ->whereHas('brand',function ($query) use ($brand) {
                    $query->where('brand_name',$brand);
                })
                ->where('status','เปิดใช้งาน')->get();
        return view('frontend/products/tire-runflat/product-tire-by-brand',compact('brand','models'));
    }

    public function productTireRunflatByModel($brand, $model) {
        $products = Product::query()
            ->whereHas('tireSpec', function($query) {
                $query->where('runflat', 'ใช่');
            })
            ->whereHas('brand', function ($query) use ($brand) {
                $query->where('brand_name', $brand);
            })
            ->whereHas('model', function ($query) use ($model) {
                $query->where('model_name', $model);
            })
            ->where('is_active', '1')
            ->get();
        return view('frontend/products/tire-runflat/product-tire-by-model',compact('brand','products','model'));
    }

    public function productTireEVBrand() {
        $brands = Brand::where('status', 'เปิดใช้งาน')
            ->whereHas('tireSpecs', function($query) {
                $query->where('ev', 'ใช่');
            })
            ->get();
        return view('frontend/products/tire-ev/product-tire-brand',compact('brands'));
    }

    public function productTireEVByBrand($brand) {
        $models = ProductModel::query()
                ->whereHas('tireSpecs', function($query) {
                    $query->where('ev', 'ใช่');
                })
                ->whereHas('brand',function ($query) use ($brand) {
                    $query->where('brand_name',$brand);
                })
                ->where('status','เปิดใช้งาน')->get();
        return view('frontend/products/tire-ev/product-tire-by-brand',compact('brand','models'));
    }

    public function productTireEVByModel($brand, $model) {
        $products = Product::query()
            ->whereHas('brand', function ($query) use ($brand) {
                $query->where('brand_name', $brand);
            })
            ->whereHas('model', function ($query) use ($model) {
                $query->where('model_name', $model);
            })
            ->whereHas('tireSpec', function($query) {
                $query->where('ev', 'ใช่');
            })
            ->where('is_active', '1')
            ->get();
        return view('frontend/products/tire-ev/product-tire-by-model',compact('brand','products','model'));
    }
}
