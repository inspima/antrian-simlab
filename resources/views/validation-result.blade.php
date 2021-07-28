<!DOCTYPE html>
<html>
<head>
    <title>VALIDASI HASIL PEMERIKSAAN {{$reg->code}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

    <link href="{{ URL::asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('assets/css/style.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ URL::asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</head>
<body>


<div class="row p-3">
    <div class="col-sm-12 m-2">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <a href="./" class="logo logo-admin"><img src="{{ URL::asset('assets/images/logo-web-itd.png') }}" width="300" alt="logo"></a>
            </div>                <!-- /.box-header -->
            <div class="card-body">
                <dl>
                    <dt>Nama Pasien</dt>
                    <dd>{{ $reg_simlab->nama_pasien }}</dd>
                </dl>
                <dl>
                    <dt>No.Registrasi</dt>
                    <dd>{{ substr($reg_simlab->no_registrasi,0,strlen($reg_simlab->no_registrasi)-4).'XXXX' }}</dd>
                </dl>
                <dl>
                    <dt>Waktu Registrasi</dt>
                    <dd>{{ $reg_simlab->waktu_registrasi }}</dd>
                </dl>
                <dl>
                    <dt>Keterangan</dt>
                    <dd>
                        <b class="text-success">Hasil telah divalidasi</b>
                    </dd>
                </dl>
                <dl>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="ion-clipboard"></i> Preview Hasil
                    </button>
                    <div id="myModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content ">
                                <div class="modal-header bg-dark text-white">
                                    <h5 class="modal-title mt-0" id="myModalLabel">Hasil Pemeriksaan Laboratorium</h5>
                                    <button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body">

                                    <table class="table table-condensed">
                                        <tr class="bg-blue-grey">
                                            <td colspan="2" class="text-center text-white"><b>BIODATA</b></td>
                                        </tr>
                                        <tr>
                                            <td class="border-bottom" style="width: 40%"><b>Nama Pasien</b></td>
                                            <td class="border-bottom" style="width: 60%"> : {{ $reg_simlab->nama_pasien }}</td>
                                        </tr>
                                        <tr>
                                            <td class="border-bottom"><b>Umur</b></td>
                                            <td class="border-bottom"> : {{ is_numeric($reg_simlab->umur) ? "" . $reg_simlab->umur . " th " : $reg_simlab->umur }}</td>
                                        </tr>
                                        <tr>
                                            <td class="border-bottom"><b>Alamat Pasien</b></td>
                                            <td class="border-bottom"> : {{ $reg_simlab->alamat_pasien }}</td>
                                        </tr>
                                        <tr>
                                            <td class="border-bottom"><b>Telephone</b></td>
                                            <td class="border-bottom"> : {{ $reg_simlab->telephone }} / {{ $reg_simlab->hp }}</td>
                                        </tr>
                                        <tr>
                                            <td class="border-bottom"><b>Dokter Pengirim</b></td>
                                            <td class="border-bottom"> : {{ $reg_simlab->gelar_depan }} {{ $reg_simlab->nama_dokter }} {{ $reg_simlab->gelar_belakang }}</td>
                                        </tr>
                                        <tr>
                                            <td class="border-bottom"><b>No.Registrasi</b></td>
                                            <td class="border-bottom"> : {{ $reg_simlab->no_registrasi }}</td>

                                        </tr>
                                        <tr>
                                            <td class="border-bottom"><b>Instansi Pengirim</b></td>
                                            <td class="border-bottom"> : {{ $reg_simlab->nama_instansi }}</td>
                                        </tr>
                                        <tr>

                                            <td class="border-bottom"><b>Waktu Registrasi</b></td>
                                            <td class="border-bottom"> : {{ $reg_simlab->waktu_registrasi }}</td>
                                        </tr>
                                        <tr class="bg-blue-grey">
                                            <td colspan="2" class="text-center text-white"><b>PEMERIKSAAN</b></td>
                                        </tr>
                                        @foreach($reg_patient_simlabs as $no=>$d)
                                            <tr>
                                                <td><b>Jenis Pemeriksaan</b></td>
                                                <td>{{ $d->nama_pengujian }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>Hasil</b></td>
                                                <td>{!! $d->hasil_pengujian !!}</td>
                                            </tr>
                                            <tr>
                                                <td><b>Nilai Normal</b></td>
                                                <td>{{ $d->nilai_normal }}</td>
                                            </tr>
                                            @if(count($d->data_child)>0)
                                                @foreach($d->data_child as $no_child=>$dc)
                                                    <tr>
                                                        <td><b>Jenis Pemeriksaan</b></td>
                                                        <td>- {{ $dc->nama_pengujian  }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Hasil</b></td>
                                                        <td>
                                                            {{ strip_tags($dc->hasil_pengujian)  }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Nilai Normal</b></td>
                                                        <td>{{ $dc->nilai_normal }}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                </dl>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>

</body>
</html>
