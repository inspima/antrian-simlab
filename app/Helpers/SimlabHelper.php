<?php

    namespace App\Helpers;

    use Illuminate\Support\Facades\DB;

    class SimlabHelper
    {
        public static function getRegistrasiSimlabByIdMd5($id_registrasi)
        {
            $query = "select rp.*,p.*,i.nama_instansi,d.nama_dokter,pt.nama_pasien_tipe,p.nama nama_pasien,p.alamat alamat_pasien,d.gelar_depan,d.gelar_belakang
            from registrasi_pemeriksaan rp
            join pasien p on rp.id_pasien=p.id_pasien
            join instansi i on i.id_instansi=rp.id_instansi
            left join dokter d on d.id_dokter=rp.id_dokter_pengirim
            join pasien_tipe pt on pt.id_pasien_tipe =rp.id_pasien_tipe
            where md5(rp.id_registrasi_pemeriksaan)='{$id_registrasi}'";
            return collect(DB::connection('mysql-simlab')->select($query))->first();
        }
        public static function getRegistrasiSimlab($no_registrasi)
        {
            $query = "select rp.*,p.*,i.nama_instansi,d.nama_dokter,pt.nama_pasien_tipe,p.nama nama_pasien,p.alamat alamat_pasien,d.gelar_depan,d.gelar_belakang
            from registrasi_pemeriksaan rp
            join pasien p on rp.id_pasien=p.id_pasien
            join instansi i on i.id_instansi=rp.id_instansi
            left join dokter d on d.id_dokter=rp.id_dokter_pengirim
            join pasien_tipe pt on pt.id_pasien_tipe =rp.id_pasien_tipe
            where rp.no_registrasi='{$no_registrasi}'";
            return collect(DB::connection('mysql-simlab')->select($query))->first();
        }

        public static function getPasienPemeriksaanSimlab($no_registrasi)
        {
            $result = array();
            $query = "
            select pp.*,p.nilai_normal,p.flag_parent_group,p.nama_pengujian,p.kode_pengujian,s.nama_sample,peg.nama_pegawai nama_validator,rps.keterangan_sample
            from pasien_pemeriksaan pp
            join registrasi_pemeriksaan rp on rp.id_registrasi_pemeriksaan=pp.id_registrasi_pemeriksaan
            join pengujian p on pp.id_pengujian=p.id_pengujian
            left join registrasi_pasien_sample rps on rps.id_registrasi_pasien_sample=pp.id_registrasi_pasien_sample
            left join pegawai peg on peg.id_pegawai = pp.id_petugas_validasi
            left join sample s on s.id_sample = rps.id_sample
            where rp.no_registrasi='{$no_registrasi}'
            order by pp.id_pasien_pemeriksaan
            ";
            $data_pasien_pemeriksaan = DB::connection('mysql-simlab')->select($query);
            foreach ($data_pasien_pemeriksaan as $index => $d) {
                if ($d->flag_parent_group == '1') {
                    $query_child = "


				select p.*,p.id_pengujian as id_pengujian_child,pph.*,pph.keterangan as keterangan_hasil
				from pengujian p
                join pasien_pemeriksaan_hasil pph on pph.id_pengujian = p.id_pengujian and pph.id_registrasi_pemeriksaan='{$d->id_registrasi_pemeriksaan}'
                where p.id_pengujian_group ='{$d->id_pengujian}'";
                    $data_pengujian_child = DB::connection('mysql-simlab')->select($query_child);

                    //$data_pengujian_child = array();
                } else {
                    $data_pengujian_child = array();
                }
                $query_sample_pasien = "
                select rps.*,s.nama_sample,ps.id_pemeriksaan_sample
                from registrasi_pasien_sample rps
                join sample s on rps.id_sample=s.id_sample
                left join pemeriksaan_sample ps on ps.id_registrasi_pasien_sample =rps.id_registrasi_pasien_sample and ps.id_pasien_pemeriksaan='{$d->id_pasien_pemeriksaan}'
                where rps.id_registrasi_pemeriksaan='{$d->id_registrasi_pemeriksaan}'
                order by rps.waktu_masuk desc,s.nama_sample
                ";
                $data_sample = DB::connection('mysql-simlab')->select($query_sample_pasien);
                $data_pasien_pemeriksaan[$index]->data_sample = $data_sample;
                $data_pasien_pemeriksaan[$index]->data_child = $data_pengujian_child;
            }
            $result = $data_pasien_pemeriksaan;
            return $result;
        }

        public static function getPasienPemeriksaanSimlabByIdMd5($id_registrasi)
        {
            $result = array();
            $query = "
            select pp.*,p.nilai_normal,p.flag_parent_group,p.nama_pengujian,p.kode_pengujian,s.nama_sample,peg.nama_pegawai nama_validator,rps.keterangan_sample
            from pasien_pemeriksaan pp
            join registrasi_pemeriksaan rp on rp.id_registrasi_pemeriksaan=pp.id_registrasi_pemeriksaan
            join pengujian p on pp.id_pengujian=p.id_pengujian
            left join registrasi_pasien_sample rps on rps.id_registrasi_pasien_sample=pp.id_registrasi_pasien_sample
            left join pegawai peg on peg.id_pegawai = pp.id_petugas_validasi
            left join sample s on s.id_sample = rps.id_sample
            where md5(rp.id_registrasi_pemeriksaan)='{$id_registrasi}'
            order by pp.id_pasien_pemeriksaan
            ";
            $data_pasien_pemeriksaan = DB::connection('mysql-simlab')->select($query);
            foreach ($data_pasien_pemeriksaan as $index => $d) {
                if ($d->flag_parent_group == '1') {
                    $query_child = "


				select p.*,p.id_pengujian as id_pengujian_child,pph.*,pph.keterangan as keterangan_hasil
				from pengujian p
                join pasien_pemeriksaan_hasil pph on pph.id_pengujian = p.id_pengujian and pph.id_registrasi_pemeriksaan='{$d->id_registrasi_pemeriksaan}'
                where p.id_pengujian_group ='{$d->id_pengujian}'";
                    $data_pengujian_child = DB::connection('mysql-simlab')->select($query_child);

                    //$data_pengujian_child = array();
                } else {
                    $data_pengujian_child = array();
                }
                $query_sample_pasien = "
                select rps.*,s.nama_sample,ps.id_pemeriksaan_sample
                from registrasi_pasien_sample rps
                join sample s on rps.id_sample=s.id_sample
                left join pemeriksaan_sample ps on ps.id_registrasi_pasien_sample =rps.id_registrasi_pasien_sample and ps.id_pasien_pemeriksaan='{$d->id_pasien_pemeriksaan}'
                where rps.id_registrasi_pemeriksaan='{$d->id_registrasi_pemeriksaan}'
                order by rps.waktu_masuk desc,s.nama_sample
                ";
                $data_sample = DB::connection('mysql-simlab')->select($query_sample_pasien);
                $data_pasien_pemeriksaan[$index]->data_sample = $data_sample;
                $data_pasien_pemeriksaan[$index]->data_child = $data_pengujian_child;
            }
            $result = $data_pasien_pemeriksaan;
            return $result;
        }


    }
