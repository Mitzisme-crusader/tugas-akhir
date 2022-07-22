<?php

namespace App\Http\Controllers;

class convert_number{
    function convert_number($number)
    {
        if (($number < 0) || ($number > 999999999))
        {
            return "Angka tidak bisa dikonversi";
        }
        $giga = floor($number / 1000000);
        // Millions (giga)
        $number -= $giga * 1000000;
        $kilo = floor($number / 1000);
        // Thousands (kilo)
        $number -= $kilo * 1000;
        $hecto = floor($number / 100);
        // Hundreds (hecto)
        $number -= $hecto * 100;
        $deca = floor($number / 10);
        // Tens (deca)
        $n = $number % 10;
        // Ones
        $result = "";
        if ($giga)
        {
            $result .= $this->convert_number($giga) .  "Juta";
        }
        if ($kilo)
        {
            $result .= (empty($result) ? "" : " ") .$this->convert_number($kilo) . " Ribu";
        }
        if ($hecto)
        {
            $result .= (empty($result) ? "" : " ") .$this->convert_number($hecto) . " Ratus";
        }
        $ones = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas", "dua belas", "tiga belas", "empat belas", "lima belas", "enam belas", "tujuh belas", "delapan belas", "sembilan belas");
        $tens = array("", "", "dua puluh", "tiga puluh", "empat puluh", "lima puluh", "enam puluh", "sembilan puluh", "delapan puluh", "sembilan puluh");
        if ($deca || $n) {
            if (!empty($result))
            {
                $result .= " dan ";
            }
            if ($deca < 2)
            {
                $result .= $ones[$deca * 10 + $n];
            } else {
                $result .= $tens[$deca];
                if ($n)
                {
                    $result .= "-" . $ones[$n];
                }
            }
        }
        if (empty($result))
        {
            $result = "nol";
        }
        return $result;
    }
}
?>
