@extends('admin.layouts.templates')
@section('content')
<div class="container-fluid">
     <h3>Detail Product</h3>
    <div class="row ml-2 mb-3 mt-3">
        <a href="/product" class="btn btn-outline-primary"><i class="fas fa-arrow-left"></i> Back </a>
    </div>

    <div class="shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr class="text-center">
                        <td colspan="2">
                              @if($product->image !== null)
                              <img src="/assets/img/foto-product/{{$product->image}}" alt="" class="img-thumbnail w-25">
                              @else 
                              <span class="text-danger">Gambar belum di upload</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Category</td>
                        <td>{{$product->category->name}}</td>
                    </tr>
                    <tr>
                        <td>Sparepart Code</td>
                        <td>{{$product->product_code}}</td>
                    </tr>
                    <tr>
                        <td>Sparepart Name</td>
                        <td>{{$product->name}}</td>
                    </tr>
                    <tr>
                        <td>Price</td>
                        <td>Rp. {{number_format($product->price, 0, ',', '.')}}</td>
                    </tr>
                    <tr>
                        <td>Stock</td>
                        <td>{{$product->stock}}</td>
                    </tr>
                    <tr>
                        <td>Description</td>
                        <td>{!!$product->description!!}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection