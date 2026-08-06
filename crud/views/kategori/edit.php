<?php
require '../../koneksi/database.php';
require '../../models/kategori/Kategori.php';

$models = new Kategori($connection);
$data = $models->getKategoriById($_GET['id']);
// var_dump($data);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kategori</title>
</head>
<body>

    <form action="../../controllers/kategori/KategoriController.php" method="POST">

        <input type="hidden" name="action" value="update">
        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">

        <input
            type="text"
            name="nama_kategori"
            placeholder="Nama kategori" value="<?php echo htmlspecialchars($data['nama_kategori']); ?>"> 

        <button type="submit">
            Simpan
        </button>

    </form>
    
</body>
</html>