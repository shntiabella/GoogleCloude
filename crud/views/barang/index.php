<?php
require '../../koneksi/database.php';
require '../../models/barang/Barang.php';

$models = new Barang($connection);
$barangList = $models->getAllBarang();
$no = 1;

// Ambil pesan error/success dari URL (kalau ada, misal dari redirect controller)
$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index Barang</title>
</head>
<body>
    <h1>Index Barang</h1>

    <?php if ($error): ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <?php if ($success): ?>
        <p style="color:green;"><?php echo htmlspecialchars($success); ?></p>
    <?php endif; ?>

    <a href="barang/tambah.php">Create Barang</a>

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Satuan</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($barang = $barangList->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td>
                    <img src="../../uploads/<?php echo htmlspecialchars($barang['gambar']); ?>"
                         alt="<?php echo htmlspecialchars($barang['nama_barang']); ?>"
                         width="60">
                </td>
                <td><?php echo htmlspecialchars($barang['kode_barang']); ?></td>
                <td><?php echo htmlspecialchars($barang['nama_barang']); ?></td>
                <td><?php echo htmlspecialchars($barang['nama_kategori']); ?></td>
                <td><?php echo htmlspecialchars($barang['satuan']); ?></td>
                <td><?php echo number_format($barang['harga_beli'], 2); ?></td>
                <td><?php echo number_format($barang['harga_jual'], 2); ?></td>
                <td><?php echo $barang['stok']; ?></td>
                <td>
                    <a href="edit.php?id=<?php echo $barang['id_barang']; ?>">Edit</a>
                    <a href="../../controllers/barang/BarangController.php?action=delete&id=<?php echo $barang['id_barang']; ?>"
                       onclick="return confirm('Are you sure')">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>