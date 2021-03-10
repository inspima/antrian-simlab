@extends('layouts.master-without-nav')

@section('content')
    <!-- Begin page -->
    <div class="accountbg"></div>
    <div class="wrapper-page">

        <div class="card" style="background-color: #005493;color:white">
            <div class="card-body">
                <h3 class="text-center m-0">
                    <a href="index" class="logo logo-admin"><img src="{{ URL::asset('assets/images/logo-web-itd.png') }}" width="90%" alt="logo"></a>
                </h3>
                <div class="p-3">
                    <h4 class=" font-18 m-b-5 text-center">Permintaan Reset Password</h4>

                    <form class="form-horizontal m-t-10" method="POST" action="{{ route('forget-password') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        @if (session('success-forget'))
                            <div class="alert alert-success alert-colored" role="alert">
                                <strong>Berhasil</strong>, {{ session('success-forget') }}
                            </div>
                        @endif
                        <div class="form-group ">
                            <label for="email">Email</label>
                            <input class="form-control" name="email" type="text" value="" placeholder="email@organisasi.com" required>
                            @if (session('error-forget'))
                                <span class="text-danger font-14" role="alert">
                                    <strong>{{ session('error-forget') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group row m-t-20">
                            <div class="col-6 text-left">
                                <a href="{{route('login')}}" class="btn btn-light w-md waves-effect waves-light">Kembali</a>
                            </div>
                            <div class="col-6 text-right">
                                <button class="btn btn-warning w-md waves-effect waves-light" type="submit">Kirim</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('script')

@endsection

