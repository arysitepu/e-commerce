@extends('admin.layouts.templates')
@section('content')
<div class="container-fluid">
     <h3 class="h3 mb-0 text-gray-800">Order</h3>

     <a href="/order-admin" class="btn btn-outline-primary mb-3 mt-3"> <i class="fas fa-arrow-left"></i> Back </a>

        <div class="shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <td>Invoice</td>
                            <td>{{$order->invoice_no}}</td>
                        </tr>
                        <tr>
                            <td>Pembeli</td>
                            <td>{{$order->user->name}}</td>
                        </tr>
                        <tr>
                            <td>Payment Method</td>
                            <td>{{$order->payment_method}}</td>
                        </tr>
                        <tr>
                            <td>Courier</td>
                            <td>{{$order->courier->courier_name}}</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>{!!$order->Alamat!!}</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>
                                @if($order->status == 'pending')
                                <span class="text-warning">{{$order->status}}</span>
                                @elseif($order->status == 'paid')
                                <span class="text-primary">{{$order->status}}</span>
                                @elseif($order->status == 'shipped')
                                <span class="text-info">{{$order->status}}</span>
                                @elseif($order->status == 'completed')
                                <span class="text-success">{{$order->status}}</span>
                                @else 
                                <span class="text-danger">{{$order->status}}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Jumlah Barang</td>
                            <td>{{$order->total_qty}}</td>
                        </tr>
                        <tr>
                            <td>Total Price</td>
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
                                Rp. {{ number_format($order->courier->shiping_cost, 0, ',', '.') }}
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
                            <td>Bukti Pembayaran</td>
                            <td>
                                @if($order->bukti_bayar !== null)
                                <img src="/assets/img/bukti-bayar/{{$order->bukti_bayar}}" alt="" class="img-thumbnail w-50">
                                @else 
                                <span class="text-danger">Bukti Pembayaran tidak ada</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                @if($order->status === 'paid')
                                <button class="btn btn-outline-info btnShipped" data-id="{{$order->id}}"> Shipped</button>
                                <button class="btn btn-outline-danger btnCancel" data-id="{{$order->id}}"> Cancel</button>
                                @elseif($order->status === 'shipped')
                                <button class="btn btn-outline-success btnComplete" data-id="{{$order->id}}">Complete</button>
                                @else
                                    @if($order->status == 'cancelled')
                                    <span class="text-danger">Transaction Cancelled</span>
                                    @else 
                                    <span class="text-success">Transaction Done</span>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <br>
        <hr>
        <div class="shadow">
            <div class="card">
                <div class="card-header text-center">Detail</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="order-item-table" class="table display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Item</th>
                                    <th>Nama Item</th>
                                    <th>Harga Satuan</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
     
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

         $('#order-item-table').DataTable({
            ajax: {
            url: '{{ route('order.items', $order->id) }}',
            dataSrc: function (data) {
                return data;
                }
            },
            columns: [
                { 
                    data: null,
                        render : function (data, type, row, meta){
                            return meta.row + 1
                        }
                },
                {
                    data : 'product.product_code'
                },
                {
                    data : 'product.name'
                },
                {
                    data : 'product.price',
                    render: function(data, type, row) {
                        return 'Rp. ' + parseInt(data).toLocaleString('id-ID');
                        }
                },
                {
                    data : 'quantity'
                },
                {
                    data : 'price',
                    render: function(data, type, row) {
                        return 'Rp. ' + parseInt(data).toLocaleString('id-ID');
                        }
                },
            ]

         })

        //  SHIPPED
         $(document).on('click', '.btnShipped', function () {
             const shippedId = $(this).data('id');
              Swal.fire({
                title: 'Data akan di lakukan proses shiping',
                text: "Silahkan check data terlebih dahulu",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                 if (result.isConfirmed) {
                    $.ajax({
                         url: `/order-shipped/${shippedId}`,
                         type: 'PATCH',
                         success: function (response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Data sudah di shipping!',
                                timer: 2000,
                                showConfirmButton: false
                            });
                             location.reload();
                         },
                         error: function (xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Failed!',
                                    text: 'Shipping data gagal.'
                                });
                                console.error(xhr.responseText);
                            }
                    })
                 }
            })
         })
        // BATAS

        // COMPLETE
         $(document).on('click', '.btnComplete', function () {
             const completeId = $(this).data('id');
              Swal.fire({
                title: 'Selesaikan pesanan ini?.',
                text: "Silahkan check data terlebih dahulu sebelum menyelesaikan pesanan!.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                 if (result.isConfirmed) {
                    $.ajax({
                         url: `/order-complete/${completeId}`,
                         type: 'PATCH',
                         success: function (response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Pesanan berhasil diselesaikan!.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                             location.reload();
                         },
                         error: function (xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Failed!',
                                    text: 'Gagal menyelesaikan pesanan.'
                                });
                                console.error(xhr.responseText);
                            }
                    })
                 }
            })
         })
        // BATAS

        // CANCEL
         $(document).on('click', '.btnCancel', function () {
             const cancelId = $(this).data('id');
              Swal.fire({
                title: 'Apakah anda yakin?.',
                text: "Apakah anda yakin ingin membatalkan pesanan ini",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                 if (result.isConfirmed) {
                    $.ajax({
                         url: `/order-cancel/${cancelId}`,
                         type: 'PATCH',
                         success: function (response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Pesanan berhasil dibatalkan!.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                             location.reload();
                         },
                         error: function (xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Failed!',
                                    text: 'Gagal membatalkan pesanan.'
                                });
                                console.error(xhr.responseText);
                            }
                    })
                 }
            })
         })
        // BATAS
    })
</script>
@endpush