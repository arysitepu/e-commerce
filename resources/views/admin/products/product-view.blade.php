@extends('admin.layouts.templates')
@section('content')
  <div class="container-fluid">
    <!-- Page Heading -->
        <h3 class="h3 mb-0 text-gray-800">Product</h3>

    <div class="row ml-2 mb-3 mt-3">
        <a href="/product-create" class="btn btn-outline-primary"><i class="fas fa-plus"></i> Add </a>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header font-weight-bold text-center">Data Product</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="product-table" class="table display" style="width:100%">
                           <thead>
                               <tr>
                                   <th>No</th>
                                   <th>Code</th>
                                   <th>Category</th>
                                   <th>Nama Product</th>
                                   <th>Price</th>
                                   <th>Stock</th>
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

         $('#product-table').DataTable({
            ajax: {
            url: '/products',
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
                  data : 'product_code'
                },
                {
                  data : 'category.name'
                },
                {
                  data : 'name'
                },
                {
                  data : 'price',
                  render: function(data, type, row) {
                      return 'Rp. ' + parseInt(data).toLocaleString('id-ID');
                    }
                },
                {
                  data : 'stock'
                },
                {
                  data : null,
                  render : function(data, type, row){
                      return `
                              <a class="btn btn-sm btn-outline-success btn-detail" href="/product-detail/${row.id}"> <i class="fas fa-info-circle"></i></a>
                              <a class="btn btn-sm btn-outline-primary" href="/product-edit/${row.id}"><i class="fas fa-edit"></i></a>
                              <button class="btn btn-sm btn-outline-danger btn-delete" data-id="${row.id}"><i class="fas fa-trash-alt"></i></button>
                              `
                  }
                }

             ]
         })


        //  DELETE DATA
         $(document).on('click', '.btn-delete', function () {
             const productId = $(this).data('id');
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
                         url: `/product-delete/${productId}`,
                         type: 'DELETE',
                         success: function (response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Data berhasil dihapus!',
                                timer: 2000,
                                showConfirmButton: false
                            });
                             $('#product-table').DataTable().ajax.reload(); // refresh table
                         },
                         error: function (xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Failed!',
                                    text: 'Gagal menghapus data.'
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