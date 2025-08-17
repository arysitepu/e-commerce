@extends('e-commerce.layouts-commerce.template-commerce')
@section('content')
 <section class="py-5">
            <div class="container px-4 px-lg-5">
                <div class="row justify-content-center mb-3">
                    <div class="alert alert-info col-md-10 text-center"> <h4>All product</h4> </div>
                </div>
                 <div class="row justify-content-center mb-5">
                    <button  class="btn btn-outline-primary col-md-10" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    <i class="fas fa-search"></i> Find Product
                    </button>
                    <div class="collapse col-md-10 mt-3" id="collapseExample">
                        <div class="card card-body">
                            <form action="">
                            <div class="row">
                                <div class="col">
                                    <label for="">Category</label>
                                    <select class="form-select" name="category_id">
                                        <option value="">Silahkan Pilih</option>
                                        @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="">Products</label>
                                    <select class="form-select" name="product_id">
                                        <option value="">Silahkan Pilih</option>
                                        @foreach($productMasters as $productMaster)
                                        <option value="{{$productMaster->id}}">{{$productMaster->product_code}} - {{$productMaster->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col">
                                    <button type="submit" class="btn btn-outline-primary col-12 mb-2"> <i class="fas fa-search"></i> Search </button>
                                    <a href="/product-all" class="btn btn-outline-info col-12"> <i class="fas fa-sync"></i> Reset </a>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    <!-- YANG DI PAKEK -->
                    @foreach($products as $product)
                    <div class="col-6 mb-5">
                        <div class="card shadow h-100">
                            <!-- Sale badge-->
                            <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>
                            <!-- Product image-->
                            <img class="card-img-top" src="/assets/img/foto-product/{{$product->image}}" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">{{$product->name}}</h5>
                                    Rp. {{number_format($product->price, 0, ',', '.')}}
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><button data-bs-toggle="modal" data-bs-target="#detailProduct" class="detail-product btn btn-outline-primary mb-2" id="detail-product" data-id="{{ $product->id }}">Detail</button></div>
                                <div class="text-center"><button class="add-to-cart btn btn-outline-dark mt-auto" id="add-to-cart" data-product-id="{{ $product->id }}">Add to cart</button></div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <!-- BATAS -->
                </div>
            </div>
        </section>
@endsection

<div class="modal fade" id="detailProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detail Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <td colspan="2">
                        <img id="product_image" alt="" class="card-img-top">
                    </td>
                </tr>
                <tr>
                    <td>Category</td>
                    <td>
                        <span id="category_name"></span>
                    </td>
                </tr>
                <tr>
                    <td>Product code</td>
                    <td>
                        <span id="product_code"></span>
                    </td>
                </tr>
                <tr>
                    <td>Product name</td>
                    <td>
                        <span id="product_name"></span>
                    </td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td>
                        <span id="price"></span>
                    </td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td>
                        <span id="description"></span>
                    </td>
                </tr>
            </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
@push('scripts')
<script>
    $(document).on('click', '.detail-product', function () {
         const id = $(this).data('id');
         currentEditId = id;
         $.get(`/product/${id}`, function (data) {
            $('#category_name').text(data.category.name);
            $('#product_code').text(data.product_code);
            $('#product_name').text(data.name);
            $('#description').html(data.description);
           $('#price').text(
                new Intl.NumberFormat('id-ID', { 
                    style: 'currency', 
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(data.price)
            );
            // GAMBAR
             $('#product_image').attr('src', '/assets/img/foto-product/' + data.image);
            // BATAS
            $('#detailProduct').modal('show');
         })
    })
</script>
@endpush