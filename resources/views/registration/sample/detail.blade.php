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
                    <h4 class="mt-0 header-title">Detail Registrasi</h4>
                    <hr/>
                    <div class="form-group">
                        <label for="code">Kode Reg.</label>
                        <p class="text-muted m-b-30 font-14">{{$data->code}}</p>
                    </div>
                    <div class="form-group">
                        <label for="org">Nama Organisasi</label>
                        <p class="text-muted m-b-30 font-14">{{session('org_name')}}</p>
                    </div>
                    <div class="form-group ">
                        <label for="date" >Tanggal</label>
                        <p class="text-muted m-b-30 font-14">{{$data->date}}</p>
                    </div>
                    <div class="form-group">
                        <label for="name">Catatan</label>
                        <p class="text-muted m-b-30 font-14">{{$data->description}}</p>
                    </div>
                    <div class="form-group">
                        <label for="name">Tanggal Antrian</label>
                        <p class="text-muted m-b-30 font-14">{{Carbon\Carbon::parse($data->queue_date)->translatedFormat('l, d F Y')}}</p>
                    </div>
                    <div class="form-group">
                        <label for="name">Status</label><br/>
                        <span class="badge badge-success font-14">Terkirim</span>
                    </div>
                    <hr>
                    <h4 class="mt-0 header-title">Data Pasien</h4>
                    <hr>
                    <table class="table table-striped dt-responsive nowrap table-vertical">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th class="text-center">No. KTP</th>
                                <th class="text-center">Tgl Lahir</th>
                                <th class="text-center">Umur</th>
                                <th class="text-center">J.Kelamin</th>
                                <th>Alamat</th>
                                <th class="text-center">No Kontak</th>
                                <th class="text-center">Tes Ke</th>
                                <th class="text-center">Status Pemeriksaan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data->registration_patiens as $p)
                            <tr>
                                <td>{{$p->name}}</td>
                                <td class="text-center">{{$p->id_number}}</td>
                                <td class="text-center">{{Carbon\Carbon::parse($p->born_date)->translatedFormat('d F Y')}}</td>
                                <td class="text-center">{{$p->age}} Tahun</td>
                                <td class="text-center">{{$p->age}}</td>
                                <td>{{$p->address}}</td>
                                <td class="text-center">{{$p->mobile}}</td>
                                <td class="text-center">{{$p->test_loop}}</td>
                                <td class="text-center">
                                    @if ($p->sync_status=='0')
                                        <span class="badge badge-danger font-14">Belum Diproses</span>
                                    @elseif ($p->sync_status=='1')
                                        <span class="badge badge-info font-14">Proses Pengujian</span><br/>
                                        Kode Reg. : <br/>
                                        <b style="font-size: 0.9em">{{$p->simlab_reg_code}}</b>
                                    @elseif ($p->sync_status=='2')
                                        <span class="badge badge-success font-14">Sudah Selesai</span><br/>
                                        Kode Reg. : <br/>
                                        <b style="font-size: 0.9em">{{$p->simlab_reg_code}}</b><br/>
                                        <a target="_blank" style="color: white" class="btn btn-sm btn-primary waves-effect waves-light" href="<?=route('registration.sample.print-result',base64_encode(md5($p->id))) ?>"><i class="fa fa-print"></i> Cetak Hasil</a>
                                    @endif
                                </td>
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

