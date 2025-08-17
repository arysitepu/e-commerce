<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return view('admin.order.order-view');
    }

    public function getOrder()
    {
        $orders = Order::with('user')->withSum('orderItems', 'quantity')->orderBy('created_at','desc')->get();
        return response()->json($orders);
    }

    public function show($id)
    {
        $order = Order::with('user', 'courier')->withSum('orderItems as total_qty', 'quantity')->find($id);
        $data = [
            'order' => $order,
        ];
        return view('admin.order.order-detail', $data);
    }

    public function getOrderDetail($id)
    {
        $orderItems = OrderItem::with('product')->where('order_id', $id)->orderBy('created_at')->get();
        return response()->json($orderItems);
    }

    public function shipping($id)
    {
        $order = Order::with('user', 'courier')->find($id);
        if(!$order){
            return response()->json([
                'errors' =>  'Data not found'
            ], 404);
        }
        $order->status = 'shipped';
        $order->save();
        return response()->json([
            'message' => 'Sparepart Shipping successfully!'
        ]);
    }

    public function complete($id)
    {
        $order = Order::with('user', 'courier')->find($id);
        if(!$order){
            return response()->json([
                'errors' =>  'Data not found'
            ], 404);
        }
        $order->status = 'completed';
        $order->save();
        return response()->json([
            'message' => 'Order Completed!'
        ]);
    }

    public function cancel($id)
    {
        $order = Order::with('user', 'courier')->find($id);
        if(!$order){
            return response()->json([
                'errors' =>  'Data not found'
            ], 404);
        }
        $orderitems = OrderItem::where('order_id', $order->id)->get();
        foreach($orderitems as $item){
            $product = Product::find($item->product_id);
            $stock = $item->quantity + $product->stock;
            $product->stock = $stock;
            $product->save();
        }
        $order->status = 'cancelled';
        $order->save();
        return response()->json([
            'message' => 'Cancelled data successfully!'
        ]);
    }
}
