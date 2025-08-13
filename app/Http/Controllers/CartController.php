<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{

    public function index()
    {
        $userId = Auth::id();
        $order = Order::with('user', 'courier')->where('user_id', $userId)->first();
        $orderItems = OrderItem::with('product')->where('order_id', $order->id)->orderBy('created_at', 'desc')->get();
        $data = [
            'order' => $order,
            'orderItems' => $orderItems
        ];
        return view('e-commerce.cart', $data);
    }

    public function addCart(Request $request)
    {
        $userId = Auth::id();
        $productId = $request->product_id;
        $quantity = $request->quantity ?? 1;
        $order = Order::where('user_id', $userId)
                  ->where('status', 'pending')
                  ->first();
        if (!$order) {
             $datePart = date('dmy');
               $lastOrder = Order::whereNotNull('invoice_no')
                      ->orderBy('invoice_no', 'desc')
                      ->first();
             if ($lastOrder) {
                    // Ambil nomor urut terakhir dari invoice terakhir
                    $lastInvoiceNo = $lastOrder->invoice_no;  // contoh: INV1108250009
                    $lastNumber = (int)substr($lastInvoiceNo, -4);
                    $newNumber = $lastNumber + 1;

                    // Ambil tanggal hari ini buat invoice (bisa pakai tanggal invoice terakhir atau tanggal hari ini)
                    $datePart = date('dmy');
                } else {
                    // Kalau belum ada invoice, mulai dari 1
                    $newNumber = 1;
                    $datePart = date('dmy');
                }

                // Format nomor invoice baru
                $invoiceNo = 'INV' . $datePart . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
                
            // Kalau belum ada order 'pending', buat baru
            $order = Order::create([
                'user_id' => $userId,
                'status' => 'pending',
                'invoice_no' => $invoiceNo,
                'total_price' => 0,
            ]);
        }
         $product = Product::find($productId);
         if($product->stock === 0){
            return response()->json([
                'message' => 'Stok produk ini habis, tidak bisa menambahkan ke keranjang.'
            ], 400);
         }
         $priceProduct = $product->price;
         $orderItem = $order->orderItems()->where('product_id', $productId)->first();
         if ($orderItem) {
             // Kalau sudah ada, update quantity
             $orderItem->quantity += $quantity;
             $orderItem->price = $priceProduct * $orderItem->quantity;
            $orderItem->save();
        } else {
            // Kalau belum ada, buat baru order_item
            $order->orderItems()->create([
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => Product::find($productId)->price
            ]);
        }

        $totalPrice = $order->orderItems()->get()->reduce(function($carry, $item) {
            return $carry + ($item->quantity * $item->price);
        }, 0);

        $order->total_price = $totalPrice;
        $order->save();
         $cartCount = $order->orderItems()->sum('quantity');
         return response()->json(['cart_count' => $cartCount]);
    }

    public function updateQty(Request $request, $id)
    {
          $validator = Validator::make($request->all(), [
                'quantity' => 'required|numeric'
          ]);
          if($validator->fails()){
            return redirect()->back()->with('error_message', 'Error: Data gagal diupdate silahkan perbaiki inputan')
                ->withFragment('CartTable')->with('error_item_id', $id)->withErrors($validator)->withInput();
            }
         $item = OrderItem::find($id);
         $quantity = $request->input('quantity');
         $product = Product::find($item->product_id);
         if($product->stock < $quantity){
            return redirect()->back()->with('error_message', 'Error: Data gagal diupdate karna melebihi jumlah stock')
                ->withFragment('CartTable')->with('error_item_id', $id)->withErrors($validator)->withInput();
         }
         $price = $product->price * $quantity;
         OrderItem::where('id', $id)->update([
            'quantity' => $quantity,
            'price' => $price
         ]);
         return redirect()->back()->withFragment('CartTable')->with([
                            'success_message' => 'Data update successfully',
                            'updated_item_id' => $id
                        ]);
    }

    public function deleteItem($id)
    {
        $item = OrderItem::find($id);
        if (!$item) {
            return response()->json(['message' => 'News not found'], 404);
        }
        $item->delete();
        $totalPrice = OrderItem::where('order_id', $item->order_id)->sum('price');

        // Update ke tabel orders
        Order::where('id', $item->order_id)->update([
        'total_price' => $totalPrice
        ]);

        return response()->json([
        'success_message' => 'Data deleted successfully',
        'total_price' => $totalPrice,
        'total_price_formatted' => number_format($totalPrice, 0, ',', '.')
        ], 200);
        return response()->json(['success_message' => 'Data deleted successfully'], 200);
    }
}
