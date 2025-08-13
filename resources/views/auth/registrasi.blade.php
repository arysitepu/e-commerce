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

            <div class="col-xl-12 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Registrasi</h1>
                                    </div>
                                    @if(session()->has('success_message'))
                                    <div class="alert alert-success">
                                        {{session()->get('success_message')}}
                                    </div>
                                    @endif
                                    @if(session()->has('error_message'))
                                        <div class="alert alert-danger">
                                            {{session()->get('error_message')}}
                                        </div>
                                    @endif
                                    <form class="user" method="POST" action="/registrasi-save">
                                        @csrf
                                         <div class="form-group row">
                                                <div class="col-sm-6 mb-3 mb-sm-0">
                                                    <input type="text" class="form-control form-control-user" id="exampleFirstName"
                                                        placeholder="Name" name="name">
                                                         @if($errors->has('name'))
                                                        <span class="text-danger">{{$errors->first('name')}}</span>
                                                        @endif
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control form-control-user" id="exampleLastName"
                                                        placeholder="Username" name="username">
                                                        @if($errors->has('username'))
                                                        <span class="text-danger">{{$errors->first('username')}}</span>
                                                        @endif
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-6 mb-3 mb-sm-0">
                                                    <input type="email" class="form-control form-control-user" id="exampleInputEmail"
                                                    placeholder="Email Address" name="email">
                                                    @if($errors->has('email'))
                                                    <span class="text-danger">{{$errors->first('email')}}</span>
                                                    @endif
                                                </div>

                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control form-control-user" id="exampleLastName"
                                                        placeholder="No Handphone (Whatsapp)" name="no_hp">
                                                        @if($errors->has('no_hp'))
                                                        <span class="text-danger">{{$errors->first('no_hp')}}</span>
                                                        @endif
                                                </div>

                                            </div>
                                            <div class="form-group">
                                                    <input type="password" class="form-control form-control-user"
                                                        id="exampleInputPassword" placeholder="Password" name="password">
                                                        @if($errors->has('password'))
                                                        <span class="text-danger">{{$errors->first('password')}}</span>
                                                        @endif
                                            </div>
                                       
                                        <button type="submit" class="btn btn-primary btn-user btn-block mb-2">
                                            Register
                                        </button>
                                        <div class="text-center">
                                            <a class="small" href="/login">Already have an account? Login!</a>
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