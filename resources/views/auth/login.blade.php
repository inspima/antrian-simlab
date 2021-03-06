@extends('layouts.master-without-nav')

@section('content')
 <!-- Begin page -->
 <div class="accountbg" style="background: url('assets/images/bg-vector.png');background-size: contain;background-position: 85% 50%;background-repeat:no-repeat"></div>
 <div class="wrapper-page account-page-full " style="color: white;background-color: #005493">
     <div class="card" style="background-color: #005493">
         <div class="card-body">
             <h3 class="text-center m-0">
                 <a href="./" class="logo logo-admin"><img src="{{ URL::asset('assets/images/logo-web-itd.png') }}" width="400" alt="logo"></a>
             </h3>
             <div class="px-3">
                 <h4 class="font-22 m-b-5 text-center">{{ getenv('APP_NAME') }}</h4>
                 <p class="text-center">Masukkan akun anda.</p>

                 <form class="form-horizontal m-t-10" method="POST" action="{{ route('login') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                     <div class="form-group">
                        <label for="username">Email</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus id="username" placeholder="Enter Email">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                     </div>

                     <div class="form-group">
                        <label for="userpassword">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" id="password" placeholder="Enter password" >
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                     </div>


                     <div class="form-group m-t-10 mb-0 row">
                        <div class="col-sm-12">
                             Lupa password? klik <a href="{{route('forget-password')}}" style="color: orange">disini</a>
                         </div>
                     </div>
                     <div class="form-group row m-t-20">
                         <div class="col-sm-12 m-t-5">
                             <a class="btn btn-block btn-blue-grey w-md waves-effect waves-light" target="_blank" href="{{asset('assets/files/TUTORIAL_REGISTRASI_ITD_2021.pdf')}}">Baca Panduan</a>
                         </div>
                     </div>
                     <div class="form-group row m-t-5">
                        <div class="col-sm-6 m-t-5">
                           <button class="btn btn-block btn-primary w-md waves-effect waves-light" type="submit">Log In</button>
                        </div>
                        <div class="col-sm-6 m-t-5">
                           <a class="btn btn-block btn-warning w-md waves-effect waves-light" href="{{route('register')}}">Daftar</a>
                        </div>
                    </div>
                 </form>
                 <p class="text-center" style="margin-top: 100px">©{{date('Y')}}. ITD Unair.</p>
             </div>

         </div>
     </div>
 </div>
@endsection

@section('script')

@endsection

