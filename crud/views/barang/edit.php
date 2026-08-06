<?php
require '../../koneksi/database.php';
require '../../models/barang/Barang.php';

$models = new Barang($connection);

$id_barang = (int) ($_GET['id'] ?? 0);
$data = $models->getBarangById($id_barang);

if (!$data) {
    header('Location: index.php?error=' . urlencode('Barang tidak ditemukan'));
    exit;
}

$kategoriList = $models->getAllKategoriForDropdown();
$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang</title>
</head>
<body>
    <h1>Edit Barang</h1>

    <?php if ($error): ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form action="../../controllers/barang/BarangController.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="id_barang" value="<?php echo $data['id_barang']; ?>">
        <input type="hidden" name="gambar_lama" value="<?php echo htmlspecialchars($data['gambar']); ?>">

        <label>Kode Barang:</label><br>
        <input type="text" name="kode_barang" value="<?php echo htmlspecialchars($data['kode_barang']); ?>" required><br><br>

        <label>Nama Barang:</label><br>
        <input type="text" name="nama_barang" value="<?php echo htmlspecialchars($data['nama_barang']); ?>" required><br><br>

        <label>Kategori:</label><br>
        <select name="id_kategori" required>
            <option value="">-- Pilih Kategori --</option>
            <?php while ($kategori = $kategoriList->fetch_assoc()) { ?>
                <option value="<?php echo $kategori['id']; ?>"
                    <?php echo ($kategori['id'] == $data['id_kategori']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($kategori['nama_kategori']); ?>
                </option>
            <?php } ?>
        </select><br><br>

        <label>Satuan:</label><br>
        <input type="text" name="satuan" value="<?php echo htmlspecialchars($data['satuan']); ?>" required><br><br>

        <label>Harga Beli:</label><br>
        <input type="number" name="harga_beli" step="0.01" min="0" value="<?php echo $data['harga_beli']; ?>" required><br><br>

        <label>Harga Jual:</label><br>
        <input type="number" name="harga_jual" step="0.01" min="0" value="<?php echo $data['harga_jual']; ?>" required><br><br>

        <label>Stok:</label><br>
        <input type="number" name="stok" min="0" value="<?php echo $data['stok']; ?>" required><br><br>

        <label>Deskripsi:</label><br>
        <textarea name="deskripsi"><?php echo htmlspecialchars($data['deskripsi']); ?></textarea><br><br>

        <label>Gambar saat ini:</label><br>
        <img src="../../uploads/barang/<?php echo htmlspecialchars($data['gambar']); ?>" width="100"><br>
        <label>Ganti Gambar (kosongkan jika tidak ingin diubah):</label><br>
        <input type="file" name="gambar" accept=".jpg,.jpeg,.png,.gif,.webp"><br><br>

        <button type="submit">Update</button>
    </form>
</body>
</html>