<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MarketingContentController extends Controller
{
    public function promotions() {
        return view('backend.marketing_content.promotions');
    }
}
