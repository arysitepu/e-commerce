@extends('e-commerce.layouts-commerce.template-commerce')
@section('content')

<section class="py-5 bg-secondary">
    <div class="container-fluid col-10">
         <div class="row justify-content-center mb-2">
             @if(session()->has('success_message'))
                <div class="mt-3 alert alert-success text-center">
                    {{session()->get('success_message')}}
                </div>
            @endif
            <div class="card col-md-8 col-12">
                <h4 class="text-center mt-2">INVOICE</h4>
                <hr>
                <div class="shadow">
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
                                <td>No handphone</td>
                                <td>{{$order->user->no_hp}}</td>
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
                                    @if($order->Alamat)
                                    {!!$order->Alamat!!}
                                    @else 
                                    <span class="text-danger">Alamat belum ada</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Jumlah Barang</td>
                                <td>{{$orderItemSum}} Pcs</td>
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
                        </table>
                    </div>
                </div>
            </div>

         </div>


         <div class="row justify-content-center mb-5">
                    <div class="card col-md-8 col-12">
                        <h4 class="text-center mt-2">Detail</h4>
                        <hr>
                        <div class="shadow">
                            <div class="table-responsive">
                                 <table class="table table-bordered">
                                    <tr>
                                        <td>No</td>
                                        <td>Nomor item</td>
                                        <td>Nama Item</td>
                                        <td>Harga Satuan</td>
                                        <td>Qty</td>
                                        <td>Total</td>
                                    </tr>
                                    @php  
                                    $no = 1;
                                    @endphp
                                    @foreach($orderItems as $item)
                                    <tr>
                                        <td>{{$no++}}</td>
                                        <td>{{$item->product->product_code}}</td>
                                        <td>{{$item->product->name}}</td>
                                        <td>Rp. {{number_format($item->product->price, 0, ',', '.')}}</td>
                                        <td>{{$item->quantity}}</td>
                                        <td>Rp. {{number_format($item->price, 0, ',', '.')}}</td>
                                    </tr>
                                    @endforeach
                                 </table>
                            </div>
                        </div>
                    </div>
             </div>

    </div>
</section>
@endsection