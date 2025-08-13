@extends('admin.layouts.templates')
@section('content')
<div class="container-fluid">
     <h3 class="h3 mb-0 text-gray-800">User Detail</h3>
     <div class="row ml-2 mb-3 mt-3">
        <a href="/user" class="btn btn-outline-primary"> <i class="fas fa-arrow-left"></i> Back </a>
    </div>

    <div class="shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <td>Name</td>
                        <td>{{$userDetail->name}}</td>
                    </tr>
                    <tr>
                        <td>Username</td>
                        <td>{{$userDetail->username}}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>{{$userDetail->email}}</td>
                    </tr>
                    <tr>
                        <td>No Handphone (WA)</td>
                        <td>{{$userDetail->no_hp}}</td>
                    </tr>
                    <tr>
                        <td>Role</td>
                        <td>
                            @if($userDetail->role === 1)
                              Admin
                            @elseif($userDetail->role === 2)
                              Pelanggan
                            @else 
                              - 
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection