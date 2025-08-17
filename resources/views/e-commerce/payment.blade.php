@extends('e-commerce.layouts-commerce.template-commerce')
@section('content')
@if($order->status == 'pending')
<section class="py-5 bg-secondary">
    <div class="container-fluid col-10">
         <div class="row justify-content-center mb-2">
            <div class="alert alert-info col-12 col-md-8 text-center"> Silahkan Upload bukti pembayaran anda jika sudah melakukan pembayaran</div>
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

              <div class="card col-md-8 col-12">
                <div class="shadow">
                    <div class="table-responsive">
                          <table class="table table-bordered">
                            @if($order->payment_method == 'transfer')
                            <tr>
                                <td class="text-danger">Silahkan Transfer</td>
                                <td class="">
                                    <ul class="list-group list-group-flush">
                                        @foreach($rekenings as $rekening)
                                        <li class="list-group-item">{{$rekening->no_rek}} - {{$rekening->bank->nama}} - A/N {{$rekening->nama_rek}}</li>
                                        @endforeach
                                    </ul>
                                    <span class="text-primary">Silahkan pilih salah satu rekening</span>
                                </td>
                            </tr>
                            @endif
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
                                    <td>Jumlah barang</td>
                                    <td>{{$orderItemSum}}</td>
                                </tr>
                            <form action="/upload-bayar/{{$order->id}}" method="POST" enctype="multipart/form-data">
                             @csrf
                             @method('PATCH')
                            <tr>
                                <td>Silahkan upload bukti pembayaran</td>
                                <td>
                                    <input type="file" class="form-control" name="bukti_bayar">
                                    @if($errors->has('bukti_bayar'))
                                    <span class="text-danger">{{$errors->first('bukti_bayar')}}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <Button type="submit" class="btn btn-outline-primary col-12"> Bayar </Button>
                                </td>
                            </tr>
                            </form>
                          </table>
                    </div>
                </div>
              </div>

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