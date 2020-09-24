@extends('layouts.master')


@section('breadcrumb')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group pull-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">Registrasi</a></li>
                        <li class="breadcrumb-item active">Sampel</li>
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
                    <h4 class="mt-0 header-title">Form Registrasi</h4>
                    <p class="text-muted m-b-30 font-14">Silahkan isi data dengan benar dan lengkap.</p>
                    <form id="form" method="POST" action="{{ ($data->id)?route($route."update", $data->id):route($route."store")}}">
                        @if($data->id)
                            {{ method_field('PUT') }}
                        @endif
                        @csrf
                        @if($data->id)
                            <div class="form-group">
                                <label for="code">Kode Reg.</label>
                                <input id="code" name="code" type="text" class="form-control col-sm-4" value="{{$data->code}}" readonly>
                            </div>
                        @else
                            <div class="form-group">
                                <label for="code">Kode Reg.</label>
                                <input id="code" name="code" type="text" class="form-control col-sm-4" value="{{$generate_code}}" readonly>
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="org">Nama Organisasi</label>
                            <input type="text" name="org" class="form-control col-sm-4" value="{{session('org_name')}}" disabled>
                        </div>
                        <div class="form-group ">
                            <label for="date" >Tanggal</label>
                            <input class="form-control col-sm-4"  name="date" type="text" value="{{date('Y-m-d')}}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="name">Catatan</label>
                            <textarea class="form-control col-sm-6"  name="description" style="resize: none"  rows="2" placeholder="Tambahan catatan registrasi" spellcheck="false">{{$data->description}}</textarea>
                        </div>
                        <hr>
                        <h4 class="mt-0 header-title">Data Pasien</h4>
                        <p class="text-primary m-b-30 font-14">Jumlah maksimal pasien yang bisa anda kirim adalah <b>{{$quota}}</b>.</p>
                    
                        <div id="patient-template" class="row form-group hide">
                            <div class="col-sm-1">
                                <button type="button" class="btn btn-sm btn-danger waves-effect" onclick="removePatient(this)"><i class="ion-close-circled"></i> Hapus</button>
                            </div>
                            <div class="col-sm-2">
                                <input type="text" id="name" name="name[]" required class="form-control" placeholder="Nama Lengkap">
                            </div>
                            <div class="col-sm-2">
                                <input type="number" id="nik" name="nik[]" required class="form-control" placeholder="NIK (KTP)">
                            </div>
                            <div class="col-sm-2">
                                <input type="text" id="born_date"  name="born_date[]" required class="form-control datepicker" value="{{'1980-'.date('m-d')}}" placeholder="Tanggal Lahir">
                            </div>
                            <div class="col-sm-3">
                                <textarea id="address" name="address[]" required class="form-control"  rows="3" placeholder="Alamat Lengkap" style="resize: none" spellcheck="false"></textarea>
                            </div>
                            <div class="col-sm-2">
                                <input type="text" id="no_hp" name="no_hp[]" class="form-control" placeholder="No HP">
                            </div>
                        </div>
                        <div id="patient-section">
                            @if ($data->id)
                            @foreach ($data->registration_patiens as $p)
                                @if ($loop->index==0)
                                    <div class="row form-group patient-form">
                                        <div class="col-sm-1">
                                            <button type="button" class="btn btn-sm btn-primary waves-effect" onclick="addPatient()"><i class="ion-plus-circled"></i> Pasien </button>
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="text" name="name[]" required class="form-control" placeholder="Nama Lengkap" value="{{$p->name}}">
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="number" name="nik[]" required class="form-control" placeholder="NIK (KTP)" value="{{$p->id_number}}">
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="text" name="born_date[]" required class="form-control datepicker" value="{{$p->born_date}}" placeholder="Tanggal Lahir">
                                        </div>
                                        <div class="col-sm-3">
                                            <textarea  name="address[]" required class="form-control"  rows="3" placeholder="Alamat Lengkap" style="resize: none" spellcheck="false">{{$p->address}}</textarea>
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="text" name="no_hp[]" class="form-control" placeholder="No HP" value="{{$p->mobile}}">
                                        </div>
                                    </div>
                                @else
                                    <div class="row form-group patient-form">
                                        <div class="col-sm-1">
                                            <button type="button" class="btn btn-sm btn-danger waves-effect" onclick="removePatient(this)"><i class="ion-close-circled"></i> Hapus</button>
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="text" name="name[]" required class="form-control" placeholder="Nama Lengkap" value="{{$p->name}}">
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="number" name="nik[]" required class="form-control" placeholder="NIK (KTP)" value="{{$p->id_number}}">
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="text" name="born_date[]" required class="form-control datepicker" value="{{$p->born_date}}" placeholder="Tanggal Lahir">
                                        </div>
                                        <div class="col-sm-3">
                                            <textarea  name="address[]" required class="form-control"  rows="3" placeholder="Alamat Lengkap" style="resize: none" spellcheck="false">{{$p->address}}</textarea>
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="text" name="no_hp[]" class="form-control" placeholder="No HP" value="{{$p->mobile}}">
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            @else
                                <div class="row form-group patient-form">
                                    <div class="col-sm-1">
                                        <button type="button" class="btn btn-sm btn-primary waves-effect" onclick="addPatient()"><i class="ion-plus-circled"></i> Pasien </button>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" name="name[]" required class="form-control" placeholder="Nama Lengkap">
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="number" name="nik[]" required class="form-control" placeholder="NIK (KTP)">
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" name="born_date[]" required class="form-control datepicker" value="{{'1980-'.date('m-d')}}" placeholder="Tanggal Lahir">
                                    </div>
                                    <div class="col-sm-3">
                                        <textarea  name="address[]" required class="form-control"  rows="3" placeholder="Alamat Lengkap" style="resize: none" spellcheck="false"></textarea>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" name="no_hp[]" class="form-control" placeholder="No HP">
                                    </div>
                                </div>
                            @endif                            
                        </div>
                        <hr>
                        <div class="row form-group">
                            <input type="hidden" id="max_data" name="max_data" value="{{$quota}}">
                            <input type="hidden" id="jumlah_data" name="jumlah_data" value="@if($data->id){{count($data->registration_patiens)}}@else{{'1'}}@endif">
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
    function removePatient(element){
        $(element).parent().parent().remove();
        var jumlah_data=$('.patient-form').length;
        $('#jumlah_data').val(jumlah_data);
        console.log(jumlah_data);
    }
    function addPatient(){
        if(($('.patient-form').length+1)<=$('#max_data').val()){            
            var patienFormHtml=$("#patient-template").clone();
            patienFormHtml.find('#name').removeAttr('id');
            patienFormHtml.find('#nik').removeAttr('id');
            patienFormHtml.find('#born_date').removeAttr('id');
            patienFormHtml.find('#address').removeAttr('id');
            $('#patient-section').append(patienFormHtml.removeClass('hide').addClass('patient-form'));  
            var jumlah_data=$('.patient-form').length;                  
            $('#jumlah_data').val(jumlah_data);
            console.log(jumlah_data);
            initComponent();
        }else{
            Swal.fire({
                type: "error",
                icon: 'error',
                title: 'Maaf',
                text: 'Jumlah melebihi kuota',
            })
        }
    }
    $('#btn-submit').click(function(e){
        $('#name').removeAttr('required');
        $('#nik').removeAttr('required');
        $('#born_date').removeAttr('required');
        $('#address').removeAttr('required');
        $('#name').removeAttr('name');
        $('#nik').removeAttr('name');
        $('#born_date').removeAttr('name');
        $('#address').removeAttr('name');
        $('#no_hp').removeAttr('name');
        return true;
    })
    </script>

@endsection

