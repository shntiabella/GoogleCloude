<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kingg</title>
</head>
<body>
    <form method="POST">
        <input type="text" name="namaKucing" placeholder="Masukin nama kucing" step="any">  
        <input type="text" name="warnaKucing" placeholder="Masukin warna kucing" step="any">
        <button type="submit" name="simpan">Simpan</button>
    </form>
</body>

<?php

    if(isset($_POST['simpan'])) {
        $namaKucing=$_POST['namaKucing'];
        $warnaKucing=$_POST['warnaKucing'];

        class Kucing {
            public $namaKucing;
            public $warnaKucing;

            //rumus disimpan dalam func
            function meong() {
                return "Meonggg!! aku si ".$this->namaKucing. " dan aku berwarna ".$this->warnaKucing;
             }
        }


        //panggil function
        $kucingBaru= new Kucing();
        $kucingBaru->namaKucing=$namaKucing;
        $kucingBaru->warnaKucing=$warnaKucing;

        echo $kucingBaru -> meong();
        }
 ?>   
</html>

