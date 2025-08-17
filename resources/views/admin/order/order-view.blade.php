@extends('admin.layouts.templates')
@section('content')
<div class="container-fluid">
     <h3 class="h3 mb-0 text-gray-800">Orders</h3>

      <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header font-weight-bold text-center">Data Order</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="order-admin-table" class="table display" style="width:100%">
                           <thead>
                               <tr>
                                   <th>No</th>
                                   <th>Invoice</th>
                                   <th>Pembeli</th>
                                   <th>Total Price</th>
                                   <th>Jumlah Pesanan</th>
                                   <th>Status</th>
                                   <th>Action</th>
                               </tr>
                           </thead>
                       </table>
                    </div>
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

         $('#order-admin-table').DataTable({
            ajax: {
            url: '/orders-admin',
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
                    data : 'invoice_no'
                },
                {
                    data : 'user.name'
                },
                {
                     data : 'total_price',
                    render: function(data, type, row) {
                        return 'Rp. ' + parseInt(data).toLocaleString('id-ID');
                        }
                },
                {
                    data : 'order_items_sum_quantity'
                },
                {
                data : 'status',
                render: function (data) {
                  let textColor = '';
                    switch (data.toLowerCase()) {
                      case 'pending':
                          textColor = 'text-warning';
                          break;
                      case 'paid':
                          textColor = 'text-primary';
                          break;
                      case 'shipping':
                          textColor = 'text-info';
                          break;
                      case 'completed':
                          textColor = 'text-success';
                          break;
                      case 'cancelled':
                          textColor = 'text-danger';
                          break;
                      default:
                          textColor = 'text-secondary';
                  }
                  return `<span class="${textColor}">${data}</span>`;
                  }
              },
              {
                data : null,
                  render : function(data, type, row){
                      return `
                              <a class="btn btn-sm btn-outline-success btn-detail" href="/order-detail/${row.id}"> <i class="fas fa-info-circle"></i></a>
                              `
                  }
              }
            ]
         })
     })
</script>
@endpush