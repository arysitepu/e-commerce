@extends('admin.layouts.templates')
@section('content')
<div class="container-fluid">
    <h3 class="h3 mb-0 text-gray-800">Users</h3>
        <div class="row ml-2 mb-3 mt-3">
        <button type="button" data-toggle="modal" data-target="#exampleModal" class="btn btn-outline-primary"><i class="fas fa-plus"></i> Add </button>
    </div>
       @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header font-weight-bold text-center">Users</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="user-table" class="table display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Role</th>
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
        <h5 class="modal-title" id="exampleModalLabel">Create Category</h5>
        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="userForm" method="POST">
           @csrf 
           <div class="row">
            <div class="col">
                <label for="">Name</label>
                <input type="text" class="form-control" id="name" name="category_name">
            </div>
            <div class="col">
                <label for="">Username</label>
                <input type="text" name="" id="username" class="form-control">
            </div>
           </div>
           <hr>
        <div class="row">
            <div class="col">
                <label for="">Email</label>
                <input type="text" name="" id="email" class="form-control">
            </div>
            <div class="col">
                <label for="">No Handphone (Whatsapp)</label>
                <input type="text" name="" id="no_hp" class="form-control">
            </div>
        </div>
        <hr>
        <div class="row mb-3">
            <div class="col">
                <label for="">Role</label>
                <select name="" id="role" class="form-control">
                    <option value="">Silahkan Pilih</option>
                    <option value="1">Admin</option>
                    <option value="2">Pelanggan</option>
                </select>
            </div>
            <div class="col">
                <label for="">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
        </div>
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
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <form id="editUserForm">
          @csrf
            <input type="hidden" name="id" id="edit_id">
            <div class="row">
                <div class="col">
                    <label for="">Name</label>
                    <input type="text" class="form-control" id="edit_name" name="category_name">
                </div>
                <div class="col">
                    <label for="">No Handphone (Whatsapp)</label>
                    <input type="text" name="" id="edit_no_hp" class="form-control">
                </div>
            </div>
            <hr>
            <div class="row mb-3">
                <div class="col">
                    <label for="">Role</label>
                    <select name="" id="edit_role" class="form-control">
                        <option value="">Silahkan Pilih</option>
                        <option value="1">Admin</option>
                        <option value="2">Pelanggan</option>
                    </select>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-outline-primary" id="updateUserBtn">Update</button>
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

        $('#user-table').DataTable({
            ajax: {
            url: '/users',
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
                    data: 'name'
                },
                {
                    data: 'username'
                },
                {
                    data: 'role',
                    render: function(data, type, row){
                        if(data == 1) return 'Admin';
                        if(data == 2) return 'Pelanggan'
                    }
                },
                {
                    
                data : null,
                    render : function(data, type, row){
                        return `
                                <a href="/user-detail/${row.id}" class="btn btn-sm btn-outline-primary btn-detail"><i class="fas fa-info-circle"></i></a>
                                <button class="btn btn-sm btn-outline-primary btn-edit" data-toggle="modal" data-target="#editUserModal" data-id="${row.id}" ><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-outline-danger btn-delete" data-id="${row.id}"><i class="fas fa-trash-alt"></i></button>
                                `
                    }
                    
                }
            ]
        })

        // CREATE
        $('#userForm').submit(function(e) {
             e.preventDefault();
              let formData = {
                _token: $('input[name="_token"]').val(),
                name: $('#name').val(),
                username: $('#username').val(),
                email: $('#email').val(),
                no_hp: $('#no_hp').val(),
                role: $('#role').val(),
                password: $('#password').val()
            };

            $.ajax({
                url: '/user-save',
                method: 'POST',
                data: formData,
                success: function(response) {
                     Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'User saved successfully',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        $('#userForm')[0].reset(); // reset form
                        $('#exampleModal').modal('hide'); // tutup modal
                       $('#user-table').DataTable().ajax.reload();
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
          $(document).on('click', '.btn-edit', function () {
             const id = $(this).data('id');
             currentEditId = id;
              $.get(`/user/${id}`, function (data) {
                $('#edit_id').val(data.id);
                $('#edit_name').val(data.name);
                $('#edit_username').val(data.username);
                $('#edit_email').val(data.email);
                $('#edit_no_hp').val(data.no_hp);
                $('#edit_no_hp').val(data.no_hp);
                $('#edit_role').val(data.role);
              })
          })
        // BATAS

        // UPDATE DATA
           $('#updateUserBtn').click(function () {
                 let formData = {
                    _token: $('input[name="_token"]').val(),
                    name: $('#edit_name').val(),
                    no_hp: $('#edit_no_hp').val(),
                    role: $('#edit_role').val()
                };
                    console.log(formData);

                 $.ajax({
                    url: `/user-update/${currentEditId}`,  // kirim ID di URL
                    method: 'PATCH',                      // pakai method PUT untuk update
                    data: formData,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'User updated successfully',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            $('#editUserForm')[0].reset(); // reset form
                            $('#editUserModal').modal('hide'); // tutup modal
                        $('#user-table').DataTable().ajax.reload();
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
                            title: 'Updated data failed',
                            text: errMsg    
                        });
                    }
                 })
           })
        // BATAS

        // DELETE
            $(document).on('click', '.btn-delete', function () {
             const userId = $(this).data('id');
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
                            url: `/user-delete/${userId}`,
                            type: 'DELETE',
                            success: function (response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Data berhasil dihapus!',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                $('#user-table').DataTable().ajax.reload(); // refresh table
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