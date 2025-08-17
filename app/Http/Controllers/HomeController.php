<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function order()
    {
        return view('e-commerce.order');
    }

    public function orders()
    {
        $userId = Auth::id();
        $orders = Order::where('user_id', $userId)->orderBy('updated_at','desc')->get();
        return response()->json($orders);
    }

    public function detailOrder($id)
    {
        $order = Order::with('user', 'courier')->find($id);
        $orderItems = OrderItem::with('product')->where('order_id', $order->id)->orderBy('created_at', 'desc')->get();
        $orderItemSum = OrderItem::where('order_id', $order->id)->sum('quantity');
        $data = [
            'order' => $order,
            'orderItems' => $orderItems,
            'orderItemSum' => $orderItemSum
        ];
        return view('e-commerce.detail-order', $data);
    }

    public function productAll(Request $request)
    {
       $query = Product::query();

        // filter berdasarkan category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // filter berdasarkan produk
        if ($request->filled('product_id')) {
            $query->where('id', $request->product_id);
        }

        // ambil data
        $products = $query->orderBy('created_at', 'desc')->paginate(10);
        $categories = Category::orderBy('created_at', 'desc')->get();
        $productMasters = Product::orderBy('created_at', 'desc')->get();
        $data = [
            'products' => $products,
            'categories' => $categories,
            'productMasters' => $productMasters
        ];
        return view('e-commerce.all-product', $data);
    }

    public function getProduct($id)
    {
        $product = Product::with('category')->find($id);
        return response()->json($product);
    }


    
}
