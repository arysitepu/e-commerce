@extends('admin.layouts.templates')
@section('content')
  <div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
      </div>
      <h3 class="h3 mb-0 text-gray-800">Report</h3>
      <hr>
    <div class="shadow">
      <div class="card-body">
        <form action="/report">
        <div class="row">
          <div class="col">
            <label for="">Start date</label>
            <input type="date" class="form-control" name="start_date">
          </div>
          <div class="col">
            <label for="">End date</label>
            <input type="date" class="form-control" name="end_date">
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col">
            <button type="submit" class="btn btn-outline-danger"> <i class="fas fa-file-pdf"></i> PDF  </button>
          </div>
        </div>
        </form>
      </div>
    </div>

</div>
@endsection