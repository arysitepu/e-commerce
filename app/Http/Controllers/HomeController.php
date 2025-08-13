<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at','desc')->get();
        $data = [
            'products' => $products
        ];
        return view('e-commerce.index', $data);
    }
}
