@extends('admin.layouts.templates')
@section('content')
<div class="container-fluid">
    <h3 class="h3 mb-0 text-gray-800">Categories</h3>
        <div class="row ml-2 mb-3 mt-3">
        <button type="button" data-toggle="modal" data-target="#exampleModal" class="btn btn-outline-primary"><i class="fas fa-plus"></i> Add </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header font-weight-bold text-center">Categories</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="category-table" class="table display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Category</th>
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
        <form id="categoryForm" method="POST">
           @csrf 
           <div class="row">
            <div class="col">
                <label for="">Name Category</label>
                <input type="text" class="form-control" id="category_name" name="category_name">
            </div>
           </div>
           <hr>
        <div class="row">
            <div class="col">
                <label for="">Description</label>
                <textarea id="description" name="description"></textarea>
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
<div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <form id="editCategoryForm">
          @csrf
          <input type="hidden" name="id" id="edit_id">
          <div class="row">
            <div class="col">
                <label for="">Name Category</label>
                <input type="text" class="form-control" id="edit_category_name" name="category_name">
            </div>
           </div>
           <hr>
        <div class="row">
            <div class="col">
                <label for="">Description</label>
                <textarea id="descriptionEdit" name="description"></textarea>
            </div>
        </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-outline-primary" id="updateCategoryBtn">Update</button>
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

        $('#category-table').DataTable({
            ajax: {
            url: '/categories',
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
                  data: 'name'
                },

                {
                    data : null,
                    render : function(data, type, row){
                        return `<button class="btn btn-sm btn-outline-primary btn-edit" data-toggle="modal" data-target="#editCategoryModal" data-id="${row.id}" ><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-outline-danger btn-delete" data-id="${row.id}"><i class="fas fa-trash-alt"></i></button>
                                `
                    }
                }

            ]
        })

        // SUMMERNOTE CREATE
        $('#description').summernote({
            height: 200,   // tinggi editor
            toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['view', ['codeview']]
            ]
        });

        // BATAS

        // CREATE DATA
         $('#categoryForm').submit(function(e) {
            e.preventDefault();
            let formData = {
            category_name: $('#category_name').val(),
            description: $('#description').val(),
            _token: $('input[name="_token"]').val()
            };
            $.ajax({
                url: '/categories/store',
                method: 'POST',
                data: formData,
                success: function(response) {
                     Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Category saved successfully',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        $('#categoryForm')[0].reset(); // reset form
                        $('#exampleModal').modal('hide'); // tutup modal
                       $('#category-table').DataTable().ajax.reload();
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
          $('#descriptionEdit').summernote({
            height: 200,   // tinggi editor
            toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['view', ['codeview']]
            ]
        });
          $(document).on('click', '.btn-edit', function () {
            const id = $(this).data('id');
            currentEditId = id;
             $.get(`/category/${id}`, function (data) {
                $('#edit_id').val(data.id);
                $('#edit_category_name').val(data.name);
                $('#descriptionEdit').summernote('code', data.description);
                
                $('#editCategoryModal').modal('show');
            });
          })
        // BATAS

        // UPDATE DATA
          $('#updateCategoryBtn').click(function () {
             let formData = {
            category_name: $('#edit_category_name').val(),
            description: $('#descriptionEdit').summernote('code'),
            _token: $('input[name="_token"]').val()
            };
             $.ajax({
                 url: `/update-category/${currentEditId}`,  // kirim ID di URL
                method: 'PATCH',                      // pakai method PUT untuk update
                data: formData,
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Category updated successfully',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        $('#editCategoryForm')[0].reset(); // reset form
                        $('#editCategoryModal').modal('hide'); // tutup modal
                        $('#category-table').DataTable().ajax.reload();
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
                    title: 'Berhasil!',
                    text: errMsg,
                    showConfirmButton: true
                }).then(() => {
                    $('#editCategoryForm')[0].reset(); // reset form
                    $('#editCategoryModal').modal('hide'); // tutup modal
                    $('#category-table').DataTable().ajax.reload();
                });
            }
             })
          })

        // BATAS

        // DELETE
          $(document).on('click', '.btn-delete', function () {
             const categoryId = $(this).data('id');
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
                            url: `/category-delete/${categoryId}`,
                            type: 'DELETE',
                            success: function (response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Data berhasil dihapus!',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                $('#category-table').DataTable().ajax.reload(); // refresh table
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