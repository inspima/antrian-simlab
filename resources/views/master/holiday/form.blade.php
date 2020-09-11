@extends('layouts.master')


@section('breadcrumb')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group pull-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">Hari Libur</li>
                        @if($data->id)
                            <li class="breadcrumb-item">Ubah</li>
                        @else
                            <li class="breadcrumb-item">Baru</li>
                        @endif
                    </ol>
                </div>
                @if($data->id)
                    <h4 class="page-title">Ubah</h4>
                @else
                    <h4 class="page-title">Baru</h4>
                @endif
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
                    <h4 class="mt-0 header-title">Master Hari Libur</h4>
                    <p class="text-muted m-b-30 font-14">Silahkan isi data dengan benar dan lengkap.</p>
                    <form id="form" method="POST" action="{{ ($data->id)?route($route."update", $data->id):route($route."store")}}">
                        @if($data->id)
                            {{ method_field('PUT') }}
                        @endif
                        @csrf
                        @if($data->id)
                        <div class="form-group ">
                            <label for="date" >Tanggal</label>
                            <input class="form-control col-sm-4 datepicker"  name="date" type="text" value="{{$data->date}}" >
                        </div>
                        @else
                        <div class="form-group ">
                            <label for="date" >Tanggal</label>
                            <input class="form-control col-sm-4 datepicker"  name="date" type="text" value="{{date('Y-m-d')}}" >
                        </div>
                        @endif
                        
                        <div class="form-group">
                            <label for="name">Deskripsi</label>
                            <textarea class="form-control col-sm-6"  name="description" style="resize: none"  rows="2" placeholder="Penjelasan Hari Libur" spellcheck="false">{{$data->description}}</textarea>
                        </div>
                        <hr>
                        <div class="row form-group">                            
                            <input type="hidden" name="id" value="{{$data->id}}">  
                            <div class="col-sm-12">
                                <button type="button" class="btn btn-blue-grey waves-effect waves-light" onclick="window.location.href ='{{route($route.'index')}}'"><i class="ion-arrow-left-b"></i> Kembali </button>
                                <button id="btn-submit" type="submit" class="btn btn-success waves-effect waves-light pull-right"><i class="ion-checkmark-round"></i> Simpan</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <!-- Select 2 -->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css"/>
    <style>
        .hide{
            display: none;
        }
    </style>
@endsection

@section('script')
    <!-- select2 js -->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>\
    <!-- Parsley js -->
    <script src="{{ URL::asset('assets/plugins/parsleyjs/parsley.min.js') }}"  type="text/javascript"></script>
@endsection

@section('script-bottom')
    <script type="text/javascript">
    initComponent();
    function initComponent(){
        $('.datepicker').datepicker({
            "autoclose": true,
            "format": 'yyyy-mm-dd',
            "orientation": "bottom auto"
        });
    }
    </script>

@endsection

