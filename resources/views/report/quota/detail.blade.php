@extends('layouts.master')


@section('breadcrumb')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group pull-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">Report</a></li>
                        <li class="breadcrumb-item active">Quota</li>
                        <li class="breadcrumb-item">Detail</li>
                    </ol>
                </div>
                <h4 class="page-title">Detail</h4>
            </div>
        </div>
    </div>
    <!-- end page title end breadcrumb -->
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card m-b-20">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Informasi Quota Harian</h4>
                    <hr/>
                    <div class="form-group">
                        <label for="code">Kode </label>                        
                        <p class="text-muted m-b-30 font-14">{{$data->code}}</p>
                    </div>
                    <div class="form-group ">
                        <label for="date" >Tanggal</label>
                        <p class="text-muted m-b-30 font-14">{{Carbon\Carbon::parse($data->date)->translatedFormat('l, d F Y')}}</p>
                    </div>
                    <div class="form-group">
                        <label for="name">Quota</label>                        
                        <p class="text-muted m-b-30 font-14">{{$data->quota}}</p>
                    </div>
                    <div class="form-group">
                        <label for="name">Terisi</label>                        
                        <p class="text-muted m-b-30 font-14">{{$data->filled}}</p>
                    </div>
                    <div class="form-group">
                        <label for="name">Sisa</label>                        
                        <p class="text-muted m-b-30 font-14">{{$data->quota-$data->filled}}</p>
                    </div>
                    <hr>
                    <h4 class="mt-0 header-title">Data Registrasi</h4>
                    <hr>
                    <table class="table table-striped dt-responsive nowrap table-vertical">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th class="text-center">Instansi</th>
                                <th class="text-center">Jumlah Sample</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data->registration as $r)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td class="text-center">{{$r->organization->name}}</td>
                                <td class="text-center">{{count($r->registration_patiens)}}</td>
                            </tr>
                            @endforeach 
                        </tbody>
                    </table>                   
                    <hr>
                    <div class="row form-group">
                        <div class="col-sm-12">
                            <button type="button" class="btn btn-blue-grey waves-effect waves-light" onclick="window.location.href ='{{route($route.'index')}}'"><i class="ion-arrow-left-b"></i> Kembali </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    
@endsection

@section('script')
    
@endsection

@section('script-bottom')

@endsection

