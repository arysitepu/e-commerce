<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.products.product-view');
    }

    public function getProduct()
    {
        $products = Product::with('category')->orderBy('created_at','desc')->get();
        return response()->json($products);
    }

    public function create()
    {
        $categories = Category::orderBy('name','asc')->get();
        $data = [
            'categories' => $categories
        ];
        return view('admin.products.product-create', $data);
    }

    public function store(Request $request)
    {
        $request->merge([
            'price' => str_replace('.', '', $request->price),
        ]);

        $validator = Validator::make($request->all(), [
            'category_id' => 'required|numeric',
            'product_code' => 'required|unique:products,product_code|max:5',
            'name' => 'required',
            'price' => 'required|numeric|min:0',
            'description' => 'required',
            'stock' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:5048'
        ]);
        if($validator->fails()){
            return redirect()->back()->with('error_message', 'Error: Data gagal disimpan silahkan perbaiki inputan')->withErrors($validator)->withInput();
        }

        $category_id = $request->category_id;
        $product_code =  strtoupper($request->product_code);
        $name = $request->name;
        $price = $request->price;
        $description = $request->description;
        $stock = $request->stock;
        $fotoName = null;
        if($request->hasFile('image')){
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $fotoName = time() . '-'. $extension;
            //   $fotoName = time().'-'.$file->getClientOriginalName();
            $file->move(public_path('/assets/img/foto-product'), $fotoName);
        }

        $data = [
            'category_id' => $category_id,
            'product_code' => $product_code,
            'name' => $name,
            'price' => $price,
            'description' => $description,
            'stock' => $stock,
            'image' => $fotoName,
        ];
        Product::create($data);
        return redirect()->back()->with('success_message', 'Data save successfully'); 
    }

    public function edit($id)
    {
        $categories = Category::orderBy('name','asc')->get();
        $product = Product::with('category')->find($id);
        $data = [
            'categories' => $categories,
            'product' => $product
        ];
        return view('admin.products.product-edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->merge([
            'price' => str_replace('.', '', $request->price),
        ]);

        $validator = Validator::make($request->all(), [
            'category_id' => 'required|numeric',
            'name' => 'required',
            'price' => 'required|numeric|min:0',
            'description' => 'required',
            'stock' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:5048'
        ]);
        if($validator->fails()){
            return redirect()->back()->with('error_message', 'Error: Data gagal disimpan silahkan perbaiki inputan')->withErrors($validator)->withInput();
        }

        $category_id = $request->category_id;
        $product_code =  strtoupper($request->product_code);
        $name = $request->name;
        $price = $request->price;
        $description = $request->description;
        $stock = $request->stock;
        $product = Product::find($id);
        $fotoName = $product->image;
        if($request->hasFile('image')){

            $oldPhotoPath = public_path('/assets/img/foto-product/' . $product->image);
            if(File::exists($oldPhotoPath)) {
                File::delete($oldPhotoPath);
            }

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $fotoName = time() . '-' . $extension;
            //   $fotoName = time().'-'.$file->getClientOriginalName();
            $file->move(public_path('/assets/img/foto-product'), $fotoName);
        }
        $data = [
            'category_id' => $category_id,
            'product_code' => $product->product_code,
            'name' => $name,
            'price' => $price,
            'description' => $description,
            'stock' => $stock,
            'image' => $fotoName === null ? $product->image : $fotoName,
        ];
        Product::where('id', $id)->update($data);
        return redirect()->back()->with('success_message', 'Data save successfully'); 
    }

    public function show($id)
    {
         $product = Product::with('category')->find($id);
         $data = [
            'product' => $product 
         ];
         return view('admin.products.product-detail',$data);
    }


    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

         $photoPath = public_path('/assets/img/foto-product/' . $product->image);
            if (File::exists($photoPath)) {
                File::delete($photoPath);
            }

        $product->delete();

         return response()->json(['success_message' => 'Data deleted successfully'], 200);
    }



}
