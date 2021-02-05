<?php

    namespace App\Helpers;

    class TextformattingHelper
    {

        public static function getDateIndo($date)
        { // fungsi atau method untuk mengubah tanggal ke format indonesia
            // variabel BulanIndo merupakan variabel array yang menyimpan nama-nama bulan
            $BulanIndo = array(
                "Januari", "Februari", "Maret",
                "April", "Mei", "Juni",
                "Juli", "Agustus", "September",
                "Oktober", "November", "Desember"
            );

            $tahun = substr($date, 0, 4); // memisahkan format tahun menggunakan substring
            $bulan = substr($date, 5, 2); // memisahkan format bulan menggunakan substring
            $tgl = substr($date, 8, 2); // memisahkan format tanggal menggunakan substring

            $result = $tgl . " " . $BulanIndo[(int)$bulan - 1] . " " . $tahun;
            return ($result);
        }

        public static function integerToRoman($integer)
        {
            // Convert the integer into an integer (just to make sure)
            $integer = intval($integer);
            $result = '';

            // Create a lookup array that contains all of the Roman numerals.
            $lookup = array(
                'M' => 1000,
                'CM' => 900,
                'D' => 500,
                'CD' => 400,
                'C' => 100,
                'XC' => 90,
                'L' => 50,
                'XL' => 40,
                'X' => 10,
                'IX' => 9,
                'V' => 5,
                'IV' => 4,
                'I' => 1
            );

            foreach ($lookup as $roman => $value) {
                // Determine the number of matches
                $matches = intval($integer / $value);

                // Add the same number of characters to the string
                $result .= str_repeat($roman, $matches);

                // Set the integer to be the remainder of the integer and the value
                $integer = $integer % $value;
            }

            // The Roman numeral should be built, return it
            return $result;
        }

        public static function getTerbilang($x)
        {
            $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
            if ($x < 12) {
                return " " . $abil[$x];
            } else if ($x < 20) {
                return getTerbilang($x - 10) . "belas";
            } else if ($x < 100) {
                return getTerbilang($x / 10) . " puluh" . getTerbilang($x % 10);
            } else if ($x < 200) {
                return " seratus" . getTerbilang($x - 100);
            } else if ($x < 1000) {
                return getTerbilang($x / 100) . " ratus" . getTerbilang($x % 100);
            } else if ($x < 2000) {
                return " seribu" . getTerbilang($x - 1000);
            } else if ($x < 1000000) {
                return getTerbilang($x / 1000) . " ribu" . getTerbilang($x % 1000);
            } else if ($x < 1000000000) {
                return getTerbilang($x / 1000000) . " juta" . getTerbilang($x % 1000000);
            }
        }

    }
