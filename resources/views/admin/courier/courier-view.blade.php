@extends('admin.layouts.templates')
@section('content')
<div class="container-fluid">
    <h3 class="h3 mb-0 text-gray-800">Couries</h3>
        <div class="row ml-2 mb-3 mt-3">
        <button type="button" data-toggle="modal" data-target="#exampleModal" class="btn btn-outline-primary"><i class="fas fa-plus"></i> Add </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header font-weight-bold text-center">Couries</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="courier-table" class="table display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Courier</th>
                                    <th>Shiping Cost</th>
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


{{-- CREATE MODAL --}}
 <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create Courier</h5>
        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="courierForm" method="POST">
           @csrf 
           <div class="row">
            <div class="col">
                <label for="">Name Courier</label>
                <input type="text" class="form-control" id="courier_name" name="courier_name">
            </div>
           </div>
           <hr>
           <div class="row">
            <div class="col">
                <label for="">Shiping Cost</label>
                <input type="text" class="form-control" id="shiping_cost" name="shiping_cost">
            </div>
           </div>
           <br>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-outline-primary"> <i class="fas fa-save"></i> Save</button>
        </form>
      </div>
    </div>
  </div>
</div>
{{-- BATAS --}}
@endsection
{{-- EDIT MODAL --}}
<div class="modal fade" id="editCourierModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Courier</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <form id="editCourierForm">
          @csrf
          <input type="hidden" name="id" id="edit_id">
          <div class="row">
            <div class="col">
                <label for="">Name Category</label>
                <input type="text" class="form-control" id="edit_courier_name" name="category_name">
            </div>
           </div>
           <hr>
           <div class="row">
            <div class="col">
                <label for="">Shiping Cost</label>
                <input type="text" class="form-control" id="edit_shiping_cost" name="shiping_cost">
            </div>
           </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-outline-primary" id="updateCourierBtn">Update</button>
      </div>
    </div>
  </div>
</div>
{{-- BATAS --}}
@push('scripts')
<script>
     $(document).ready(function () {
        let currentEditId = null;
         $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

         $('#courier-table').DataTable({
            ajax: {
            url: '/couriers',
            dataSrc: function (data) {
                return data;
                }
            },
            columns: [
                { data: null,
                render : function (data, type, row, meta){
                    return meta.row + 1
                }
                },
                {
                    data : 'courier_name'
                },
                {
                  data : 'shiping_cost',
                  render: function(data, type, row) {
                      return 'Rp. ' + parseInt(data).toLocaleString('id-ID');
                    }
                },
                {
                    data : null,
                    render : function(data, type, row){
                        return `<button class="btn btn-sm btn-outline-primary btn-edit" data-toggle="modal" data-target="#editCourierModal" data-id="${row.id}" ><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-outline-danger btn-delete" data-id="${row.id}"><i class="fas fa-trash-alt"></i></button>
                                `
                    }
                }
            ]
         })

        //  CREATE

         $('#shiping_cost').on('input', function () {
                let value = $(this).val();
                value = value.replace(/[^0-9]/g, '');
                value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                $(this).val(value);
            });

          $('#courierForm').submit(function(e) {
            e.preventDefault();
            let formData = {
            courier_name: $('#courier_name').val(),
            shiping_cost: $('#shiping_cost').val(),
            _token: $('input[name="_token"]').val()
            };
             $.ajax({
                url: '/courier-save',
                method: 'POST',
                data: formData,
                success: function(response) {
                     Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Courier saved successfully',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        $('#courierForm')[0].reset(); // reset form
                        $('#exampleModal').modal('hide'); // tutup modal
                       $('#courier-table').DataTable().ajax.reload();
                    });
                },
                 error: function(xhr) {
                    let errMsg = 'Failed';
                    if(xhr.responseJSON && xhr.responseJSON.errors){
                    errMsg = Object.values(xhr.responseJSON.errors).flat().join('\n');
                    } else if(xhr.responseJSON && xhr.responseJSON.message) {
                        errMsg = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Create data failed',
                        text: errMsg    
                    });
                 }
             })
          })
        // BATAS

        // EDIT 
        $('#edit_shiping_cost').on('input', function () {
            let value = $(this).val();
            value = value.replace(/[^0-9]/g, '');
            value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            $(this).val(value);
        });

          $(document).on('click', '.btn-edit', function () {
            const id = $(this).data('id');
            currentEditId = id;
            $.get(`/courier/${id}`, function (data) {
                $('#edit_id').val(data.id);
                $('#edit_courier_name').val(data.courier_name);
                $('#edit_shiping_cost').val(
                    parseInt(data.shiping_cost).toLocaleString('id-ID')
                );
                
                $('#editCourierModal').modal('show');
            });
          })
        // BATAS

        // UPDATE DATA
           $('#updateCourierBtn').click(function () {
            const formData = {
            courier_name: $('#edit_courier_name').val(),
            shiping_cost: $('#edit_shiping_cost').val(),
            _token: $('input[name="_token"]').val()
            };
            $.ajax({
                url: `/update-courier/${currentEditId}`,  // kirim ID di URL
                method: 'PATCH',                      // pakai method PUT untuk update
                data: formData,
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Courier updated successfully',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        $('#editCourierForm')[0].reset(); // reset form
                        $('#editCourierModal').modal('hide'); // tutup modal
                        $('#courier-table').DataTable().ajax.reload();
                    });
                },
                error: function(xhr) {
                    let errMsg = 'Update gagal';
                    if(xhr.responseJSON && xhr.responseJSON.errors){
                        errMsg = Object.values(xhr.responseJSON.errors).flat().join('\n');
                    } else if(xhr.responseJSON && xhr.responseJSON.message){
                        errMsg = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Berhasil!',
                        text: 'Courier update failed',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        $('#editCourierForm')[0].reset(); // reset form
                        $('#editCourierModal').modal('hide'); // tutup modal
                        $('#courier-table').DataTable().ajax.reload();
                    });
                }
            })

           })
        // BATAS

        // DELETE
            $(document).on('click', '.btn-delete', function () {
                const courierId = $(this).data('id');
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
                            url: `/courier-delete/${courierId}`,
                            type: 'DELETE',
                            success: function (response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Data berhasil dihapus!',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                $('#courier-table').DataTable().ajax.reload(); // refresh table
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