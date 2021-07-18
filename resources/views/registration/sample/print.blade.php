<!DOCTYPE html>
<html>
<head>
    <title>Bukti Antrian {{$reg->code}}</title>
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
@foreach($patiens as $index=>$patien)
    <p align="center">
        <img src="assets/images/header-no-nomer.png"/>
    </p>

    <table class="tbl">
        <tr>
            <td style="text-align: center;">
                <h2 style="text-align: center;padding: 5px">BUKTI REGISTRASI</h2>
            </td>
        </tr>
        <tr>
            <td style="border: 1px solid black;">
                <p style="text-align: center;font-size: 1.1em;margin-top: 20px">
                    Kode Registrasi<br/>
                    <b style="font-size: 1.2em;font-weight: bold">{{$reg->code}}</b><br/>
                    Kode Antrian<br/>
                    <b style="font-size: 1.2em;font-weight: bold">{{$reg->queue_code}}</b><br/>
                    Nama<br/>
                    <b style="font-size: 1.2em;font-weight: bold">{{$patien->name}}</b><br/>
                    <br/>
                    <img src="data:image/png;base64,{{DNS1D::getBarcodePNG(preg_replace('/[^0-9]/', '', $reg->code), 'C39')}} " alt="barcode" width="250" height="50"/>
                    <br/>
                    Silahkan datang untuk pengambilan Sample Swab pada waktu yang ditentukan<br/>
                    Hari, Tanggal <br/>
                    <b style="font-size: 1.4em;font-weight: bold">{{Carbon\Carbon::parse($reg->queue_date)->translatedFormat('l, d F Y')}}</b> <br/>
                    Waktu <br/>
                    <b>08.00-09.00 WIB</b><br/>
                    @if(!in_array($org->type,['Perusahaan','Individu']))
                        <br/>
                        Harus membawa bukti semua all record, jika tidak membawa maka tidak akan di proses
                    @endif
                    <br/>
                    <br/>
                    <br/>
                </p>
            </td>
        </tr>
    </table>
    <br/>
    <br/>
    <table class="tbl">
        <tr>
            <td style="text-align: center">
                Diterima
                <br/>
                <br/>
                <br/>
                <br/>
                <br/>
                <br/>
                (....................)
            </td>
            <td style="text-align: center">

            </td>
            <td style="text-align: center">
                Pengantar
                <br/>
                <br/>
                <br/>
                <br/>
                <br/>
                <br/>
                ({{$reg->organization->name}})
            </td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: center">
                <p>Tanggal cetak : <i><br/><b>{{ Carbon\Carbon::parse(date('Y-m-d'))->formatLocalized('%d %B %Y').' '.date('H:i:s') }}</b></i></p>
            </td>
        </tr>
    </table>
    @if($index+1<count($patiens))
        <div class="page-break"></div>
        @endif
        @endforeach

        </body>
</html>
