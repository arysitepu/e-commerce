@extends('e-commerce.layouts-commerce.template-commerce')
@section('content')
@if($order->status == 'pending')
<section class="py-5 bg-secondary">
    <div class="container-fluid col-10">
         <div class="row justify-content-center mb-2">
             <div class="alert alert-info col-12 text-center"> Silahkan Atur kurir, alaman pengantaran, dan metode pembayaran</div>
             @if(session()->has('error_message'))
                <div class="mt-3 alert alert-danger">
                    {{session()->get('error_message')}}
                </div>
            @endif
             <div class="card col-md-8 col-12">
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
                                <form action="/checkout-update/{{$order->id}}" method="POST">
                                    @csrf 
                                    @method('PATCH')
                                <tr>
                                    <td>Courier</td>
                                    <td>
                                        <select name="courier_id" id="" class="form-control">
                                            <option value="">Silahkan pilih kurir</option>
                                            @foreach($couriers as $courier)
                                            <option value="{{$courier->id}}">{{$courier->courier_name}}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('courier_id'))
                                            <span class="text-danger">{{$errors->first('courier_id')}}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td>
                                        <textarea name="alamat" id="alamat"></textarea>
                                        @if($errors->has('alamat'))
                                            <span class="text-danger">{{$errors->first('alamat')}}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Metode Pembayaran</td>
                                    <td>
                                         <select name="payment_method" id="" class="form-control">
                                            <option value="">Silahkan pilih metode pembayaran</option>
                                            <option value="transfer">Transfer</option>
                                            <option value="cod">COD</option>
                                         </select>
                                         @if($errors->has('payment_method'))
                                            <span class="text-danger">{{$errors->first('payment_method')}}</span>
                                        @endif
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

         
        <div class="row justify-content-center mb-5">
            <button type="submit" class="btn btn-success">Buat pesanan</button>
        </div>
         </form>

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
        $('#alamat').summernote({
            height: 200,   // tinggi editor
            toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['para', ['ul', 'ol', 'paragraph']],
            ]
        });
    })
</script>
@endpush