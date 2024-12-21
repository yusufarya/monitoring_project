<?php

use App\Models\User;
use Illuminate\Support\Facades\DB;

function testHelper() {
    die('Helper is ready');
}

function last_query($result = '') {
    DB::enableQueryLog();

    // and then you can get query log

    dd(DB::getQueryLog());
}

function cleanForPriceHD($value) {
    $string = str_replace('.', '', $value); // Removes special chars.
    $string = str_replace(',', '.', $string); // Replaces all spaces with hyphens.
    // dd($string);
    $formatted = sprintf('%.2f', $string);

    return preg_replace('/-+/', '-', $formatted); // Replaces multiple hyphens with single one.
}

function cleanForPrice($value) {
    $string = str_replace('.', ',', $value); // Removes special chars.
    $string = str_replace(',', '.', $string); // Replaces all spaces with hyphens.
    // dd($string);
    $formatted = sprintf('%.2f', $string);

    return preg_replace('/-+/', '-', $formatted); // Replaces multiple hyphens with single one.
}

function hitung_umur($tanggal_lahir){
	$birthDate = new DateTime($tanggal_lahir);
	$today = new DateTime("today");
	if ($birthDate > $today) {
	    // exit("0 tahun 0 bulan 0 hari");
	}
	$y = $today->diff($birthDate)->y;
	// $m = $today->diff($birthDate)->m;
	// $d = $today->diff($birthDate)->d;
	// return $y." tahun ".$m." bulan ".$d." hari";
    return $y;
}

function getNotif() {
    $data = DB::select('select * from users where number IS NULL ');
    return $data;
}

function rupiah($angka) {
    $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
    echo $hasil_rupiah;
}

if (!function_exists('getMonthName')) {
    function getMonthName($bln) {
        switch ($bln) {
            case '1':
                $bulan = 'Januari';
                break;
            case '2':
                $bulan = 'Februari';
                break;
            case '3':
                $bulan = 'Maret';
                break;
            case '4':
                $bulan = 'April';
                break;
            case '5':
                $bulan = 'Mei';
                break;
            case '6':
                $bulan = 'Juni';
                break;
            case '7':
                $bulan = 'Juli';
                break;
            case '8':
                $bulan = 'Agustus';
                break;
            case '9':
                $bulan = 'September';
                break;
            case '10':
                $bulan = 'Oktober';
                break;
            case '11':
                $bulan = 'November';
                break;
            case '12':
                $bulan = 'Desember';
                break;
            default:
                break;
        }
        return $bulan;
    }
}

// Mendapatkan file script
function getContentScript($isAdmin, $filename) {
    if($isAdmin === true) {
        $filename_script = base_path() . '/public/js/admin-page/' . $filename . '.js';
        if (file_exists($filename_script)) {
            $filename_script = 'js/admin-page/'. $filename;
        } else {
            $filename_script = 'js/admin-page/default_script';
        }
    } else {
        $filename_script = base_path() . '/public/js/user-page/' . $filename . '.js';
        if (file_exists($filename_script)) {
            $filename_script = 'js/user-page/'. $filename;
        } else {
            $filename_script = 'js/admin-page/default_script';
        }
    }

    return $filename_script;
}

function getLastNumberAdmin() {

    $lastCode = User::max('number');

    if($lastCode) {
        $lastCode = substr($lastCode, -4);
        $code_ = sprintf('%04d', $lastCode+1);
        $numberFix = "ADM".date('Ymd').$code_;
    } else {
        $numberFix = "ADM".date('Ymd')."0001";
    }

    return $numberFix;
}

function getLastNumberStaff() {

    $lastCode = User::max('number');

    if($lastCode) {
        $lastCode = substr($lastCode, -4);
        $code_ = sprintf('%04d', $lastCode+1);
        $numberFix = "STF".date('Ymd').$code_;
    } else {
        $numberFix = "STF".date('Ymd')."0001";
    }

    return $numberFix;
}

?>
