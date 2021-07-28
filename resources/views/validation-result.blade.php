<!DOCTYPE html>
<html>
<head>
    <title>VALIDASI HASIL PEMERIKSAAN {{$reg->code}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

    <link href="{{ URL::asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('assets/css/style.css') }}" rel="stylesheet" type="text/css">
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
                        <b class="text-success">Valid</b>
                    </dd>
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
