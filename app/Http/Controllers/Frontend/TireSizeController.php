<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\TireSize;


class TireSizeController extends Controller
{
    public function getRatios(Request $request){
        $ratios = TireSize::where('width', $request->width)
                    ->distinct()
                    ->orderBy('ratio', 'asc')
                    ->pluck('ratio');
                    
        return response()->json($ratios);
    }

public function getRims(Request $request){
        $rims = TireSize::where('width', $request->width)
                    ->where('ratio', $request->ratio)
                    ->distinct()
                    ->orderBy('rim', 'asc')
                    ->pluck('rim');

        return response()->json($rims);
    }
}
