<?php
require '../../koneksi/database.php';
require '../../models/barang/Barang.php';

$models = new Barang($connection);
$kategoriList = $models->getAllKategoriForDropdown();

$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang</title>
</head>
<body>
    <h1>Tambah Barang</h1>

    <?php if ($error): ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form action="../../controllers/barang/BarangController.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="create">

        <label>Kode Barang:</label><br>
        <input type="text" name="kode_barang" required><br><br>

        <label>Nama Barang:</label><br>
        <input type="text" name="nama_barang" required><br><br>

        <label>Kategori:</label><br>
        <select name="id_kategori" required>
            <option value="">-- Pilih Kategori --</option>
            <?php while ($kategori = $kategoriList->fetch_assoc()) { ?>
                <option value="<?php echo $kategori['id']; ?>">
                    <?php echo htmlspecialchars($kategori['nama_kategori']); ?>
                </option>
            <?php } ?>
        </select><br><br>

        <label>Satuan:</label><br>
        <input type="text" name="satuan" required><br><br>

        <label>Harga Beli:</label><br>
        <input type="number" name="harga_beli" step="0.01" min="0" required><br><br>

        <label>Harga Jual:</label><br>
        <input type="number" name="harga_jual" step="0.01" min="0" required><br><br>

        <label>Stok:</label><br>
        <input type="number" name="stok" min="0" required><br><br>

        <label>Deskripsi:</label><br>
        <textarea name="deskripsi"></textarea><br><br>

        <label>Gambar:</label><br>
        <input type="file" name="gambar" accept=".jpg,.jpeg,.png,.gif,.webp" required><br><br>

        <button type="submit">Simpan</button>
    </form>
</body>
</html>