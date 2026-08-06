<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menghitung</title>
</head>
<body>

    <form method="POST">
    <input type="number" name="jari_jari" 
        placeholder="Masukkan jari-jari lingkaran" step="any">
        <button type="submit" name="hitung">Hitung Luas</button>
    </form>
    <?php

    //pow=untuk menghitung pangkat
    //m_pi=untuk nilai phi

    if(isset($_POST['hitung'])) {
        $luas=$_POST['jari_jari'];

        //rumus disimpan dalam func
        function luasLingkaran($jariJari) {
           $luas = M_PI * pow($jariJari, 2) ;
           return $luas;
        }

        //panggil function
        $jariJari = $luas;
        $luas =luasLingkaran($jariJari);
        echo "Luas Lingkaran dengan jari-jari $jariJari 
        adalah: ".round($luas, 2);
    }
    ?>

</body>





</html>