@extends('layouts.master-without-nav')

@section('content')
    <!-- Begin page -->
        <div class="accountbg"></div>
        <div class="wrapper-page"  >

            <div class="card"  style="background-color: #005493;color:white">
                <div class="card-body" >
                    <h3 class="text-center m-0">
                        <a href="index" class="logo logo-admin"><img src="{{ URL::asset('assets/images/logo-web-itd.png') }}" width="90%" alt="logo"></a>
                    </h3>
                    <div class="p-3">
                        <h4 class=" font-18 m-b-5 text-center">Registrasi Instansi</h4>
                        <p class="text-center">Silahkan lengkapi data.</p>

                        <form class="form-horizontal m-t-10" method="POST" action="{{ route('register') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group ">
                                <label for="type" >Tipe Organisasi</label>
                                <select class="form-control" name="type">
                                    <option value="Rumah Sakit" >Rumah Sakit</option>
                                    <option value="Instansi Pemerintah">Instansi Pemerintah</option>
                                    <option value="Perusahaan">Perusahaan</option>
                                    <option value="Individu" >Individu</option>
                                </select>
                            </div>
                            <div class="form-group ">
                                <label for="name" >Nama</label>
                                <input class="form-control"  name="name" type="text" value="" placeholder="Nama Organisasi/Perorangan" required>
                            </div>
                            <div class="form-group">
                                <label for="address">Alamat</label>
                                <textarea class="form-control"  name="address" style="resize: none"  rows="2" placeholder="Alamat" spellcheck="false" required></textarea>
                            </div>
                            <div class="form-group ">
                                <label for="phone" >Telepon</label>
                                <input class="form-control"  name="phone" type="text" value="" placeholder="031-9114412">
                            </div>
                            <div class="form-group ">
                                <label for="phone" >Nomor Whatsapp (<span class="text-info font-12" >digunakan untuk notifikasi</span>)</label>
                                <i></i>
                                <input class="form-control"  name="whatsapp" type="text" value="" placeholder="08123456789" required>
                            </div>
                            <div class="form-group ">
                                <label for="email" >Email (<span class="text-info font-12" >digunakan untuk konfirmasi</span>)</label>
                                <input class="form-control"  name="email" type="text" value="" placeholder="email@organisasi.com" required>
                            </div>
                            <div class="form-group ">
                                <label for="contact_name" >Nama Kontak</label>
                                <input class="form-control"  name="contact_name" type="text" value="" placeholder="Nama PIC" required>
                            </div>

                            <div class="form-group row m-t-20">
                                <div class="col-6 text-left">
                                    <a href="{{route('login')}}" class="btn btn-light w-md waves-effect waves-light">Kembali</a>
                                </div>
                                <div class="col-6 text-right">
                                    <button class="btn btn-warning w-md waves-effect waves-light" type="submit">Daftar</button>
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

