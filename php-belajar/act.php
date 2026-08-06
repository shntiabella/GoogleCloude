<?php

$angka1 = $_POST['angka1'];
$angka2 = $_POST['angka2'];
$operator = $_POST['operator'];

$hasilPenjumlahan = $angka1 + $angka2;
$hasilPerkalian = $angka1 * $angka2;
$hasilPengurangan = $angka1 - $angka2;

if($operator == "+") {
    echo "HASILNYA ADALAH:".$hasilPenjumlahan;
}elseif ($operator == "*") {
    echo "HASILNYA ADALAH:".$hasilPerkalian;
}elseif ($operator == "-"){
    echo "HASILNYA ADALAH:".$hasilPengurangan;
}elseif ($operator == "/") {
    if ($angka2 == 0) {
        echo "Tidak bisa membagi dengan angka 0";
    }
    else{
        $hasilPembagian = $angka1 / $angka2;
        echo "HASILNYA ADALAH: ".$hasilPembagian;
    }

} else {
    echo "operator tidak dikenal";
}
