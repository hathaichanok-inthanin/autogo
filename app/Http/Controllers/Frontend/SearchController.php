<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\TireSize;
use App\Models\TireSpec;
use App\Models\Product;

class SearchController extends Controller
{
    public function tireSearch(Request $request) {
        $widths = TireSize::distinct()->orderBy('width', 'asc')->pluck('width');
        $ratios = TireSize::distinct()->orderBy('ratio', 'asc')->pluck('ratio');
        $rims   = TireSize::distinct()->orderBy('rim', 'asc')->pluck('rim');

        $width = $request->get('width');
        $ratio = $request->get('ratio');
        $rim = str_ireplace('r', '', $request->get('rim'));

        $products = Product::whereHas('tireSpec', function($q) use ($width, $ratio, $rim) {
            $q->where('width', $width)
            ->where('ratio', $ratio)
            ->where('rim', $rim);
        })->get();

        $size = "{$width}/{$ratio}R{$rim}";

        return view('frontend.products.product-tire-search')->with('products', $products)
                                                            ->with('size', $size)
                                                            ->with('widths', $widths)
                                                            ->with('ratios', $ratios)
                                                            ->with('rims', $rims);
    }
}
