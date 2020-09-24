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
                 <h4 class="font-22 m-b-5 text-center">Sistem Antrian</h4>
                 <p class="text-center">Sign in untuk lanjut.</p>

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
                        <div class="col-sm-6">
                            <div class="custom-control custom-checkbox">
                               <input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="remember">Simpan login</label>
                            </div>
                        </div>
                        
                         <div class="col-sm-6 text-right">
                            <a href="pages-recoverpw-2" style="color: white"><i class="mdi mdi-lock"></i> Lupa password?</a>
                         </div>
                     </div>
                     <div class="form-group row m-t-20">
                        <div class="col-sm-12">
                           <button class="btn btn-block btn-info w-md waves-effect waves-light" type="submit">Log In</button>
                        </div>
                    </div>

                     <div class="form-group row m-t-20">
                         <div class="col-sm-12">
                            <a class="btn btn-block btn-warning w-md waves-effect waves-light" href="{{route('register')}}">Daftar</a>
                         </div>
                     </div>
                 </form>
                 <p class="text-center m-t-40">©{{date('Y')}}.ITD Unair.</p>
             </div>

         </div>  
     </div>
 </div>
@endsection

@section('script')

@endsection

