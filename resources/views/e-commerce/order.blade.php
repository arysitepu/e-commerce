@extends('e-commerce.layouts-commerce.template-commerce')
@section('content')
<section class="py-5">
      <div class="container-fluid col-10">
        <div class="row justify-content-center mb-2">
            <h3 class="text-center">Your Order</h3>
            <hr>
            <div class="table-responsive">
                <table id="order-table" class="table display" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Invoice</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
      </div>
</section>
@endsection
@push('scripts')
<script>
  $(document).ready(function () {
     $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

         $('#order-table').DataTable({
            ajax: {
            url: '/orders',
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
                              <a class="btn btn-sm btn-outline-success btn-detail" href="/detail-order/${row.id}"> <i class="fas fa-info-circle"></i></a>
                              `
                  }
                }
            ]
         })

  })
</script>
@endpush