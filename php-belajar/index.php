<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator</title>
</head>
<body>
    <form action="act.php" method="POST">
        <input type="number" name="angka1" placholder="Masukin angka pertama" step="any">  
        <input type="number" name="angka2" placholder="Masukin angka kedua" step="any">
        <select name="operator">
            <option value="+">+</option>
            <option value="-">-</option>
            <option value="*">*</option>
            <option value="/">/</option>
        </select>
        <button type="submit">Hitung</button>
    </form>

    <a href="lingkaran.php">Next halaman</a>
    <a href="king.php">Kucing halaman</a>


</body>
</html>