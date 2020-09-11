@extends('layouts.master')


@section('breadcrumb')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group pull-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">Konfigurasi</a></li>
                        <li class="breadcrumb-item active">Kuota</li>
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
                    <h4 class="mt-0 header-title">Konfigurasi Quota</h4>
                    <p class="text-muted m-b-30 font-14">Silahkan isi data dengan benar dan lengkap.</p>
                    <form id="form" method="POST" action="{{ ($data->id)?route($route."update", $data->id):route($route."store")}}">
                        @if($data->id)
                            {{ method_field('PUT') }}
                        @endif
                        @csrf
                        @if($type=='default')
                            <input type="hidden" name="quota_type" value="default">  
                            @if($data->id==1)
                                <div class="form-group ">
                                    <label for="type" >Kuota Harian</label>
                                </div>
                            @endif
                            @if($data->id==2)
                                <div class="form-group ">
                                    <label for="type" >Kuota Organisasi</label>
                                </div>
                            @endif                        
                            <div class="form-group ">
                                <label for="quota" >Jumlah</label>
                                <input class="form-control col-sm-4"  name="quota" type="number" value="{{$data->quota}}" >
                            </div>
                          
                        @else
                            <input type="hidden" name="quota_type" value="organization">
                            <div class="form-group ">
                                <label for="quota" >Organisasi</label>
                                <div class="col-sm-6 px-0">
                                    <select id="organization_id" name="organization_id" class="select2 form-control" data-placeholder="Cari Oganisasi" required>                            
                                        @if($data->organization)
                                            <option value="{{$data->organization->id}}">{{$data->organization->name}}</option>
                                        @endif                        
                                    </select>
                                </div>
                            </div>
                                        
                            <div class="form-group ">
                                <label for="quota" >Jumlah</label>
                                <input class="form-control col-sm-2"  name="quota" type="number" value="{{$data->quota}}" >
                            </div>
                        @endif
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
        $("#organization_id").select2({
            ajax: {
                url: "{{ route('master.organization.select2') }}",
                cache: false,
                dataType: 'json',
                data: function (params) {
                    var query = {
                        q: params.term,
                    }
                    return query;
                }
            },
            minimumInputLength: 1,
        });
    }
    </script>

@endsection

