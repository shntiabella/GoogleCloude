<?php
require '../../koneksi/database.php';
require '../../models/kategori/Kategori.php';

$models = new Kategori($connection);
$kategoriList = $models->getAllKategori();
$no =1;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index Kategori</title>
</head>
<body>
    <h1>Index Kategori</h1>
    <a href="kategori/tambah.php">Create Kategori</a>
    <!-- table -->
     <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($kategoriList as $kategori) {
            ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $kategori['nama_kategori']; ?></td>
                <td>
                    <a href="kategori/edit.php?id=<?php echo $kategori['id']; ?>">Edit</a>
                    <a href="../../controllers/kategori/KategoriController.php?action=delete&id=<?php echo $kategori['id']; ?>"
                    onclick="return confirm('Are you sure')">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
     </table>
</body>
</html>