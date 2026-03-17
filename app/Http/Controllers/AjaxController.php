<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ProductModel;

class AjaxController extends Controller
{
    public function getModelByBrand($brandId){
        $models = ProductModel::where('brand_id', $brandId)
                              ->select('id', 'model_name')
                              ->orderBy('model_name', 'asc')
                              ->get();

        return response()->json($models);
    }
}
