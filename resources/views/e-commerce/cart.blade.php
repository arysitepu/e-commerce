@extends('e-commerce.layouts-commerce.template-commerce')
@section('content')
@if($order && $order->status == 'pending')
 <section class="py-5 bg-secondary">
    <div class="container-fluid col-10">
        <div class="row justify-content-center">
            <div class="alert alert-info col-12 col-md-8 text-center"> Silahkan Click checkout untuk mengatur kurir, alaman pengantaran, dan metode pembayaran</div>
            <div class="card col-md-8 col-12">
                <div class="shadow">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <td>Tanggal</td>
                                    <td>{{date("d-m-Y",strtotime($order->created_at))}}</td>
                                </tr>
                                <tr>
                                    <td>Invoice</td>
                                    <td>{{$order->invoice_no}}</td>
                                </tr>
                                <tr>
                                    <td>Nama</td>
                                    <td>{{$order->user->name}}</td>
                                </tr>
                                <tr>
                                    <td>Courier</td>
                                    <td>
                                        @if($order->courier_id)
                                        {{$order->courier->courier_name}}
                                        @else 
                                       <span class="text-danger">Kurir belum di pilih</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td>
                                        @if($order->alamat)
                                        {{$order->alamat}}
                                        @else 
                                       <span class="text-danger">Alamat belum ada</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Total Harga</td>
                                    <td>Rp. {{number_format($order->total_price, 0, ',', '.')}}</td>
                                </tr>
                                <tr>
                                    <td>Pajak 11%</td>
                                     <td>Rp. {{ number_format($order->total_price * 0.11, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td>Ongkir</td>
                                     <td>
                                        @if($order->courier_id)
                                        Rp. {{ number_format($order->courier->shiping_cost) }}
                                        @else 
                                        <span class="text-danger">Kurir belum di pilih</span>
                                        @endif
                                     </td>
                                </tr>
                                <tr>
                                    <td>Total Bayar</td>
                                    <td>
                                         @php
                                            $pajak = $order->total_price * 0.11;
                                            $ongkir = $order->courier_id ? $order->courier->shiping_cost : 0;
                                            $totalBayar = $order->total_price + $pajak + $ongkir;
                                        @endphp
                                       <span class="text-success">Rp. {{ number_format($totalBayar, 0, ',', '.') }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>
                                       <span class="text-warning">{{$order->status}}</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

         <div class="row justify-content-center mb-2">
            @foreach($orderItems as $item)
            <div class="card mt-3 col-md-4 col-12">
                <div class="shadow">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <img src="/assets/img/foto-product/{{$item->product->image}}" alt="" class="img-thumbnail w-50">
                        </div>
                        <hr>
                        <div class="row justify-content-center">
                            <div class="mb-3">
                                <button class="btn btn-outline-danger btn-delete" data-id="{{$item->id}}"> Delete </button>
                            </div>
                            
                            <div class="table-responsive" id="CartTable">
                                <table class="table table-bordered">
                                    @if(session('success_message') && session('updated_item_id') == $item->id)
                                        <div class="mt-3 alert alert-success">
                                            {{session()->get('success_message')}}
                                        </div>
                                        @endif
                                @if(session('error_message') && session('error_item_id') == $item->id)
                                    <div class="mt-3 alert alert-danger">
                                        {{session()->get('error_message')}}
                                    </div>
                                    @endif
                                    <tr>
                                        <td>Category</td>
                                        <td>{{$item->product->category->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Product Code</td>
                                        <td>{{$item->product->product_code}}</td>
                                    </tr>
                                    <tr>
                                        <td>Product</td>
                                        <td> <span class="text-danger">{{$item->product->name}}</span></td>
                                    </tr>
                                    <tr>
                                        <td>Jumlah</td>
                                        <td> 
                                            <form action="/update-qty/{{$item->id}}" method="POST">
                                             @csrf
                                             @method('PATCH')
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{$item->quantity}}" name="quantity">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-primary" type="submit" id="button-addon2">Update Qty</button>
                                                </div>
                                            </div>
                                            @if(session('error_item_id') == $item->id && $errors->has('quantity'))
                                            <span class="text-danger">{{$errors->first('quantity')}}</span>
                                            @endif
                                            </form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Price</td>
                                        <td> Rp. {{ number_format($item->price, 0, ',', '.') }} </td>
                                    </tr>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

         <div class="row justify-content-center mb-5">
            <a href="/checkout/{{$order->id}}" class="btn btn-primary col-md-8 col-12"> Checkout </a>
         </div>

    </div>
 </section>
@else  
<section class="py-5 d-flex justify-content-center align-items-center bg-secondary" style="min-height: 100vh;">
    <div class="container text-center">
        <div class="alert alert-info">
            MAU NGAPAIN HAYOOO
        </div>
    </div>
</section>
@endif
@endsection
@push('scripts')
<script>
      $(document).ready(function () {
         $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // DELETE DATA
        $(document).on('click', '.btn-delete', function () {
            const itemId = $(this).data('id');
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: "Data ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                 if (result.isConfirmed) {
                     $.ajax({
                         url: `/item-delete/${itemId}`,
                         type: 'DELETE',
                         success: function (response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Data berhasil dihapus!',
                                timer: 2000,
                                showConfirmButton: false
                            });
                              location.reload();
                         },
                         error: function (xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: 'Gagal menghapus data.'
                                });
                                console.error(xhr.responseText);
                            }
                     })
                 }
            })
        });
      })
</script>
@endpush