<!DOCTYPE html>
<html>
<head>
    <title>HASIL PEMERIKSAAN {{$reg->code}}</title>
    <style type="text/css">
        @page {
            margin: 20px;
        }

        body {
            font-family: "Trebuchet MS";
            font-size: 14px;
        }

        h2, h3 {
            margin: 3px 0px;
        }

        p {
            margin: 3px;
        }

        hr {
            margin: 3px;
        }

        .row {
            width: 100%;
            display: inline-block;
        }

        .col-20 {
            width: 20%;
            float: left;
        }

        .col-30 {
            width: 30%;
            float: left;
        }

        .col-33 {
            width: 33%;
            float: left;
        }

        .col-40 {
            width: 40%;
            float: left;
        }

        .col-50 {
            width: 50%;
            float: left;
        }

        .col-60 {
            width: 60%;
            float: left;
        }

        .col-80 {
            width: 80%;
            float: left
        }

        .col-2 {
            width: 200px;
            float: left;
        }

        .col-2 > p {
            margin: 5px
        }

        .col-8 {
            width: 800px;
            float: left
        }

        .col-8 > p {
            margin: 5px
        }

        .m-all-5 {
            margin: 5px
        }

        .ttd-area {
            width: 300px;
            text-align: center;
        }

        .ttd-area > p:nth-child(2) {
            margin-top: 70px
        }

        .tbl {
            width: 100%;
            border-collapse: collapse;
        }

        .tbl tr, .tbl td, .tbl th {
        }

        .tbl th {
            text-align: center;
        }

        .tbl-total {
            width: 100%;
            border: 1px solid black
        }

        .tbl-head-border {
            width: 100%;
            border-bottom: 1px solid black;
            border-collapse: collapse;
        }

        .tbl-head-border tr, .tbl-head-border td {
            border: none
        }

        .tbl-head-border th {
            border: 1px solid black;
            text-align: center;
            font-size: 1.2em
        }

        .tbl tr td.border {
            border: 1px solid black;
            font-size: 1em;
            font-weight: normal
        }
        .tbl tr td.border-bottom {
            border-bottom: 1px solid grey;
            font-size: 1em;
            font-weight: normal;
            padding: 6px;
        }


        .tbl-total {
            width: 100%;
            border: 1px solid black
        }

        .no-margin {
            margin: 0
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
<p align="center">
    <img src="assets/images/header.png"/>
</p>


<table class="tbl">
    <tr>
        <td style="text-align: center;">
            <h2 style="text-align: center;padding: 5px">HASIL PEMERIKSAAN LABORATORIUM</h2>
        </td>
    </tr>
</table>
<br/>
<table class="tbl">
    <tr>
        <td style="padding: 15px 10px">
            <table class="tbl">
                <tr>
                    <td class="border-bottom" style="width: 20%;border-"><b>Nama Pasien</b></td>
                    <td class="border-bottom" style="width: 30%"> : {{ $reg_simlab->nama_pasien }}</td>
                    <td class="border-bottom" style="width: 20%"><b>Umur</b></td>
                    <td class="border-bottom" style="width: 30%"> : {{ is_numeric($reg_simlab->umur) ? "" . $reg_simlab->umur . " th " : $reg_simlab->umur }}</td>
                </tr>
                <tr>
                    <td class="border-bottom"><b>Alamat Pasien</b></td>
                    <td class="border-bottom"> : {{ $reg_simlab->alamat_pasien }}</td>
                    <td class="border-bottom"><b>Telephone</b></td>
                    <td class="border-bottom"> : {{ $reg_simlab->telephone }} / {{ $reg_simlab->hp }}</td>
                </tr>
                <tr>
                    <td class="border-bottom"><b>Dokter Pengirim</b></td>
                    <td class="border-bottom"> : {{ $reg_simlab->gelar_depan }} {{ $reg_simlab->nama_dokter }} {{ $reg_simlab->gelar_belakang }}</td>
                    <td class="border-bottom"><b>No.Registrasi</b></td>
                    <td class="border-bottom"> : {{ $reg_simlab->no_registrasi }}</td>

                </tr>
                <tr>
                    <td class="border-bottom"><b>Instansi Pengirim</b></td>
                    <td class="border-bottom"> : {{ $reg_simlab->nama_instansi }}</td>

                    <td class="border-bottom"><b>Waktu Registrasi</b></td>
                    <td class="border-bottom"> : {{ $reg_simlab->waktu_registrasi }}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<hr/>
<br/>
<table class="tbl">
    <thead>
    <tr>
        <!--<th style="text-align: center;width: 10%">No</th>-->
        <th style="text-align: center;width: 40%;font-size:1.1em;border: 1px solid grey;">Jenis Pemeriksaan</th>
        <!--<th style="text-align: center;width: 10%">Bahan/Sample</th>-->
        <th style="text-align: center;width: 30%;font-size:1.1em;border: 1px solid grey;">Hasil</th>
        <th style="text-align: center;width: 30%;font-size:1.1em;border: 1px solid grey;">Nilai Normal</th>
        <!--<th style="text-align: center;width: 20%">Keterangan </th>-->
    </tr>
    </thead>
    <tbody id="pemeriksaan-pembayaran-data-table ">
    @foreach($reg_patient_simlabs as $no=>$d)
        <tr>
            <td style="text-align: center;padding-left:5%;border: 1px solid grey;font-weight: normal">{{ $d->nama_pengujian }}</td>
            @php
                foreach ($d->data_sample as $ds) {
                    if ($ds->id_pemeriksaan_sample != '') {
                        echo '- ' . $ds->nama_sample . '<br/>';
                    }
                }
            @endphp
            </td>
            <td style="text-align: center;border: 1px solid grey;font-weight: normal">{!! $d->hasil_pengujian !!}</td>
            <td style="text-align: center;border: 1px solid grey;font-weight: normal">{{ $d->nilai_normal }}</td>
        </tr>
        @if(count($d->data_child)>0)
            @foreach($d->data_child as $no_child=>$dc)
                <tr>
                    <td style="text-align: left;padding-left:5%;border: 1px solid grey;">- {{ $dc->nama_pengujian  }}</td>
                    <td style="text-align: center;border: 1px solid grey">
                        {{ strip_tags($dc->hasil_pengujian)  }}
                    </td>
                    <td style="text-align: center;border: 1px solid grey;">{{ $dc->nilai_normal }}</td>
                </tr>
            @endforeach
        @endif
    @endforeach


    </tbody>
</table>
<br/>
<table class="tbl " style="width: 100%;height: 200px;">
    <tfoot>
    <tr>
        <td style="border: none"></td>
        <td style="border: none">
        </td>
    </tr>
    <tr>
        <td style="text-align: left;width: 60%;padding-left:10px">
            <br/>
            <div class="pull-left">
                <div class="pull-right">
                    <p style="text-align: left">
                        Catatan : <br/> <b>{{ $d->keterangan_pemeriksaan }}</b>


                        <br/>
                        <br/>
                        {!! \Milon\Barcode\DNS2D::getBarcodeHTML(route('validation-result', base64_encode(md5($reg_patient->id))), 'QRCODE',3,3) !!}
                        <br/>
                        <br/>
                    </p>
                    <table>
                        <tr>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                Waktu Cetak : <b>{{ Carbon\Carbon::parse(date('Y-m-d'))->formatLocalized('%d %B %Y').' ' }}
                                    {{ date('H:i:s') }}
                                </b>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </td>
        <td style="text-align: right;padding-left:10%;width: 40%">
            <br/>
            <div class="pull-left">

                <div style="text-align: center">
                    Surabaya {{ \App\Helpers\TextformattingHelper::getDateIndo(date('Y-m-d')) }}<br/>
                    <b>Manajer Teknis </b>
                    <br/>
                    <br/>
                    <img width=250" src="assets/images/nrt-ttd.png"/>
                    <br/>
                    ({{ $user_pj->gelar_depan . ' ' . $user_pj->nama_pegawai . ' ' . $user_pj->gelar_belakang }})
                </div>
            </div>
        </td>
    </tr>
    </tfoot>
</table>
</body>
</html>
