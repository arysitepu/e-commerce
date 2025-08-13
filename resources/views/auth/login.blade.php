@extends('auth.layouts-auth.template-auth')
@section('content')
<div class="container">
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Silahkan Login</h1>
                                    </div>
                                    @if(session()->has('error_message'))
                                    <div class="alert alert-danger">
                                        {{session()->get('error_message')}}
                                    </div>
                                    @endif

                                        @if(session()->has('success_message'))
                                    <div class="alert alert-success">
                                        {{session()->get('success_message')}}
                                    </div>
                                    @endif
                                    <form class="user" method="POST" action="/login-process">
                                        @csrf
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                aria-describedby="emailHelp"
                                                placeholder="Username" name="username">
                                                @if($errors->has('username'))
                                                <span class="text-danger">{{$errors->first('username')}}</span>
                                                @endif
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Password" name="password">
                                                @if($errors->has('password'))
                                                <span class="text-danger">{{$errors->first('password')}}</span>
                                                @endif
                                        </div>
                                       
                                        <button type="submit" class="btn btn-primary btn-user btn-block mb-2">
                                            Login
                                        </button>
                                        <div class="text-center">
                                            <a class="small" href="/registrasi">Doesn't have account?. Register here!</a>
                                        </div>
                                        
                                    </form>
                                   
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
@endsection