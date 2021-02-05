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
            font-weight: bolder;
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
<table class="tbl-head-border" style="border: 1px solid black;">
    <tr>
        <td style="text-align: center">
            <img height="85" width="85" src="{{URL::asset('assets/images/logo_unair.gif')}}"/>
        </td>
        <td>
            <h3 style="text-align: left">TROPICAL DISEASE DIAGNOSTIC CENTER</h3>
            <address style="margin: 4px 0px;font-weight: 300" class="align-left">
                Institute of Tropical Disease (Lembaga Penyakit Tropis)<br/>
                Universitas Airlangga<br/>
                Ex.Tropical Disease Center (TDC), Kampus C Unair, Jl.Mulyorejo Surabaya -60115<br/>
                Telp. (031) 5992445-46, Fax. (031) 5992445 <br/>
                Email : <span style="text-decoration: underline">sekretariat@itd.unair.ac.id</span> Website:
                <span style="text-decoration: underline">www.itd.unair.ac.id</span> <br/>
            </address>
        </td>
    </tr>
</table>

<table class="tbl">
    <tr>
        <td style="text-align: center;">
            <h3 style="text-align: center;padding: 5px">HASIL PEMERIKSAAN</h3>
        </td>
    </tr>
    <tr>
        <td style="border: 1px solid black;">
            <p style="text-align: center;font-size: 1.1em;margin-top: 20px">
                Kode Registrasi<br/>
                <b style="font-size: 1.2em;font-weight: bold">{{ $reg->code }}</b><br/>
                Nama<br/>
                <b style="font-size: 1.2em;font-weight: bold">{{ $reg_patient->name }}</b><br/>
                <br/>
            </p>
        </td>
    </tr>
</table>
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
    @php
        $no = 1;
        foreach ($reg_patient_simlabs as $d):
            $status_validasi = $d->status_validasi;
            ?>
            <tr>
                <td style="text-align: center;padding-left:5%;border: 1px solid grey;font-weight: normal"><?php echo $d->nama_pengujian ?></td>
                        <?php
                    foreach ($d->data_sample as $ds) {
                        if ($ds->id_pemeriksaan_sample != '') {
                            echo '- ' . $ds->nama_sample . '<br/>';
                        }
                    }
                ?>
                        </td>
                        -->
                <td style="text-align: center;border: 1px solid grey;font-weight: normal"><?php echo $d->hasil_pengujian; ?></td>
                <td style="text-align: center;border: 1px solid grey;font-weight: normal"><?php echo $d->nilai_normal; ?></td>
            </tr>
            <?php
            if (count($d->data_child) > 0) {
                $no_child = 1;
                foreach ($d->data_child as $dc) {
                    ?>
                    <tr>
                        <td style="text-align: left;padding-left:5%;border: 1px solid grey;">- <?php echo $dc->nama_pengujian ?></td>
                        <td style="text-align: center;border: 1px solid grey">
                            <?php echo strip_tags($dc->hasil_pengujian) ?>
                        </td>
                        <td style="text-align: center;border: 1px solid grey;"><?php echo $dc->nilai_normal ?></td>
                    </tr>
                    <?php
                    $no_child++;
                }
            }
            $no++;
        endforeach;
    @endphp

    </tbody>
</table>
<br/>
<table class="tbl">
    <tr>
        <td colspan="3" style="text-align: center">
            <p>Tanggal cetak : <i><br/><b>{{ Carbon\Carbon::parse(date('Y-m-d'))->formatLocalized('%d %B %Y').' '.date('H:i:s') }}</b></i></p>
        </td>
    </tr>
</table>
</body>
</html>
