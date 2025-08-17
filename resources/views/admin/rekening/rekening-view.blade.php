@extends('admin.layouts.templates')
@section('content')
<div class="container-fluid">
    <h3 class="h3 mb-0 text-gray-800">Rekening</h3>
        <div class="row ml-2 mb-3 mt-3">
        <button type="button" data-toggle="modal" data-target="#exampleModal" class="btn btn-outline-primary"><i class="fas fa-plus"></i> Add </button>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header font-weight-bold text-center">Rekenings</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="rekening-table" class="table display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Code</th>
                                    <th>Bank</th>
                                    <th>No Rek</th>
                                    <th>Atas Nama</th>
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
        <h5 class="modal-title" id="exampleModalLabel">Create Rekening</h5>
        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="rekeningForm" method="POST">
           @csrf 
           <div class="row">
            <div class="col">
                <select id="bank_id" class="form-control">
                    <option value="">Silahkan pilih bank</option>
                    @foreach($banks as $bank)
                    <option value="{{$bank->id}}">{{$bank->nama}}</option>
                    @endforeach
                </select>
            </div>
           </div>
           <hr>
           <div class="row">
            <div class="col">
                <label for="">Nomor Rekening</label>
                <input type="text" class="form-control" id="no_rek">
            </div>
           </div>
           <hr>
            <div class="row">
            <div class="col">
                <label for="">Nama Rekening</label>
                <input type="text" class="form-control" id="nama_rek">
            </div>
           </div>
           <hr>
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
<div class="modal fade" id="editRekeningModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Rekening</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <form id="editRekeningForm">
          @csrf
          <input type="hidden" name="id" id="edit_id">
          <div class="row">
            <div class="col">
                <select id="edit_bank_id" class="form-control">
                    <option value="">Silahkan pilih bank</option>
                    @foreach($banks as $bank)
                    <option value="{{$bank->id}}">{{$bank->nama}}</option>
                    @endforeach
                </select>
            </div>
           </div>
           <hr>
           <div class="row">
            <div class="col">
                <label for="">Nomor Rekening</label>
                <input type="text" class="form-control" id="edit_no_rek">
            </div>
           </div>
           <hr>
            <div class="row">
            <div class="col">
                <label for="">Nama Rekening</label>
                <input type="text" class="form-control" id="edit_nama_rek">
            </div>
           </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-outline-primary" id="updateRekeningBtn">Update</button>
      </div>
    </div>
  </div>
</div>
@push('scripts')
<script>
     $(document).ready(function () {
        let currentEditId = null;
         $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#rekening-table').DataTable({
            ajax: {
            url: '/rekenings',
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
                    data : 'bank.code'
                },
                {
                    data : 'bank.nama'
                },
                {
                    data : 'no_rek'
                },
                {
                    data : 'nama_rek'
                },
                {
                    data : null,
                    render : function(data, type, row){
                        return `<button class="btn btn-sm btn-outline-primary btn-edit" data-toggle="modal" data-target="#editRekeningModal" data-id="${row.id}" ><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-outline-danger btn-delete" data-id="${row.id}"><i class="fas fa-trash-alt"></i></button>
                                `
                    }
                }
            ]
        })

        // CREATE
          $('#rekeningForm').submit(function(e) {
            e.preventDefault();
            let formData = {
            bank_id: $('#bank_id').val(),
            no_rek: $('#no_rek').val(),
            nama_rek: $('#nama_rek').val(),
            _token: $('input[name="_token"]').val()
            };
             $.ajax({
                url: '/rekening-save',
                method: 'POST',
                data: formData,
                success: function(response) {
                     Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Rekening saved successfully',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        $('#rekeningForm')[0].reset(); // reset form
                        $('#exampleModal').modal('hide'); // tutup modal
                       $('#rekening-table').DataTable().ajax.reload();
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

        // EDIT FORM
          $(document).on('click', '.btn-edit', function () {
             const id = $(this).data('id');
             currentEditId = id;
              $.get(`/rekening/${id}`, function (data) {
                $('#edit_id').val(data.id);
                $('#edit_bank_id').val(data.bank_id);
                $('#edit_no_rek').val(data.no_rek);
                $('#edit_nama_rek').val(data.nama_rek);
                
                $('#editRekeningModal').modal('show');
            });
          })
        // BATAS

        // UPDATE
           $('#updateRekeningBtn').click(function () {
            let formData = {
            bank_id: $('#edit_bank_id').val(),
            no_rek: $('#edit_no_rek').val(),
            nama_rek: $('#edit_nama_rek').val(),
            _token: $('input[name="_token"]').val()
            };
             $.ajax({
                url: `/update-rekening/${currentEditId}`,  // kirim ID di URL
                method: 'PATCH',                      // pakai method PUT untuk update
                data: formData,
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Rekening updated successfully',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        $('#editRekeningForm')[0].reset(); // reset form
                        $('#editRekeningModal').modal('hide'); // tutup modal
                        $('#rekening-table').DataTable().ajax.reload();
                    });
                },
                error: function(xhr) {
                    let errMsg = 'Failed';
                    if(xhr.responseJSON && xhr.responseJSON.errors){
                        errMsg = Object.values(xhr.responseJSON.errors).flat().join('\n');
                    } else if(xhr.responseJSON && xhr.responseJSON.message){
                        errMsg = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed!',
                        text: errMsg,
                        showConfirmButton: true
                    }).then(() => {
                        $('#editRekeningForm')[0].reset(); // reset form
                        $('#editRekeningModal').modal('hide'); // tutup modal
                        $('#rekening-table').DataTable().ajax.reload();
                    });
                }
             })
           })
        // BATAS

        // DELETE
            $(document).on('click', '.btn-delete', function () {
                const rekeningId = $(this).data('id');
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
                            url: `/rekening-delete/${rekeningId}`,
                            type: 'DELETE',
                            success: function (response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Data berhasil dihapus!',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                $('#rekening-table').DataTable().ajax.reload(); // refresh table
                            },
                             error: function (xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Failed!',
                                    text: 'Delete data Failed'
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