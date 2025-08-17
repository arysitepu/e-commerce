@extends('admin.layouts.templates')
@section('content')
<div class="container-fluid">
     <h3>Update Product</h3>
    <div class="row ml-2 mb-3 mt-3">
        <a href="/product" class="btn btn-outline-primary"><i class="fas fa-arrow-left"></i> Back </a>
    </div>

    <div class="row">
         <div class="col-md-12">
            @if(session()->has('success_message'))
               <div class="mt-3 alert alert-success">
                   {{session()->get('success_message')}}
               </div>
               @endif
         @if(session()->has('error_message'))
           <div class="mt-3 alert alert-danger">
               {{session()->get('error_message')}}
           </div>
           @endif
        </div>
    </div>

    
        <div class="shadow">
            <div class="card-body">
                <form action="/product-update/{{$product->id}}" method="POST" enctype="multipart/form-data">
                    @csrf  
                    @method('PATCH')
                    <div class="row">
                        <div class="col">
                            <label for="">Category</label>
                            <select name="category_id" id="" class="form-control">
                                <option value="{{$product->category_id}}">{{$product->category->name}}</option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                            @if($errors->has('category_id'))
                            <span class="text-danger">{{$errors->first('category_id')}}</span>
                            @endif
                        </div>
                        <div class="col">
                            <label for="">Sparepart Code</label>
                            <input type="text" class="form-control" name="product_code" value="{{$product->product_code}}" disabled>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <label for="">Sparepart name</label>
                            <input type="text" class="form-control" name="name" value="{{$product->name}}">
                            @if($errors->has('name'))
                            <span class="text-danger">{{$errors->first('name')}}</span>
                            @endif
                        </div>
                        <div class="col">
                            <label for="">Price</label>
                            <input type="text" class="form-control" id="price" name="price" value="{{number_format($product->price, 0, ',', '.')}}">
                            @if($errors->has('price'))
                            <span class="text-danger">{{$errors->first('price')}}</span>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <label for="">Description</label>
                            <textarea id="summernote" name="description">{{$product->description}}</textarea>
                            @if($errors->has('description'))
                            <span class="text-danger">{{$errors->first('description')}}</span>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <label for="">Stock</label>
                            <input type="text" class="form-control" name="stock" value="{{$product->stock}}">
                            @if($errors->has('stock'))
                            <span class="text-danger">{{$errors->first('stock')}}</span>
                            @endif
                        </div>
                        <div class="col">
                            <label for="">Sparepart Image</label>
                            <input type="file" class="form-control" name="image">
                            @if($errors->has('image'))
                            <span class="text-danger">{{$errors->first('image')}}</span>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <img src="/assets/img/foto-product/{{$product->image}}" alt="" class="img-thumbnail w-25">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <button type="submit" class="btn btn-outline-primary"> <i class="fas fa-save"></i> Save </button>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
</div>

@endsection
@push('scripts')
@if(session('success_message'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: 'Data berhasil disimpan',
        timer: 2000,
        showConfirmButton: false
    });
</script>
@endif

@if(session('error_message'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Failed!',
        text: 'Data gagal disimpan silahkan check inputan anda',
        timer: 2000,
        showConfirmButton: false
    });
</script>
@endif

<script>
     $(document).ready(function() {
            $('#summernote').summernote({
                height: 200,   // tinggi editor
                toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['view', ['codeview']]
                ]
            });

             $('#price').on('input', function () {
                let value = $(this).val();
                // Hapus karakter selain angka
                value = value.replace(/[^0-9]/g, '');
                // Format ke ribuan
                value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                $(this).val(value);
            });
    });
</script>
@endpush