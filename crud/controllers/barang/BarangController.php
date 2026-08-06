<?php
require '../../koneksi/database.php';
require '../../models/barang/Barang.php';

$model = new Barang($connection);

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'create':
        // 1. Ambil & bersihkan input teks
        $kode_barang = trim($_POST['kode_barang'] ?? '');
        $nama_barang = trim($_POST['nama_barang'] ?? '');
        $id_kategori = (int) ($_POST['id_kategori'] ?? 0);
        $satuan = trim($_POST['satuan'] ?? '');
        $harga_beli = $_POST['harga_beli'] ?? '';
        $harga_jual = $_POST['harga_jual'] ?? '';
        $stok = $_POST['stok'] ?? '';
        $deskripsi = trim($_POST['deskripsi'] ?? '');

        // 2. Validasi field wajib tidak boleh kosong
        if ($kode_barang === '' || $nama_barang === '' || $id_kategori <= 0 || $satuan === '' 
            || $harga_beli === '' || $harga_jual === '' || $stok === '') {
            header('Location: ../../views/barang/tambah.php?error=' . urlencode('Semua field wajib diisi'));
            exit;
        }

        // 3. Validasi angka harus positif
        if (!is_numeric($harga_beli) || $harga_beli < 0 ||
            !is_numeric($harga_jual) || $harga_jual < 0 ||
            !is_numeric($stok) || $stok < 0) {
            header('Location: ../../views/barang/tambah.php?error=' . urlencode('Harga dan stok harus angka positif'));
            exit;
        }

        // 4. Validasi kode_barang unik
        if ($model->isKodeBarangExists($kode_barang)) {
            header('Location: ../../views/barang/tambah.php?error=' . urlencode('Kode barang sudah digunakan'));
            exit;
        }

        // 5. Validasi upload gambar
        if (!isset($_FILES['gambar']) || $_FILES['gambar']['error'] !== UPLOAD_ERR_OK) {
            header('Location: ../../views/barang/tambah.php?error=' . urlencode('Gambar wajib diupload'));
            exit;
        }

        $file = $_FILES['gambar'];

        // 5a. Validasi ukuran maksimal 2MB
        $maxSize = 2 * 1024 * 1024; // 2MB dalam bytes
        if ($file['size'] > $maxSize) {
            header('Location: ../../views/barang/tambah.php?error=' . urlencode('Ukuran gambar maksimal 2MB'));
            exit;
        }

        // 5b. Validasi ekstensi file
        $allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowedExt)) {
            header('Location: ../../views/barang/tambah.php?error=' . urlencode('Format file tidak didukung'));
            exit;
        }

        // 5c. Validasi BENAR-BENAR gambar (bukan cuma ganti nama ekstensi)
        $checkImage = getimagesize($file['tmp_name']);
        if ($checkImage === false) {
            header('Location: ../../views/barang/tambah.php?error=' . urlencode('File yang diupload bukan gambar valid'));
            exit;
        }

        // 6. Generate nama file unik & pindahkan ke folder uploads
        $newFileName = uniqid('barang_', true) . '.' . $ext;
        $uploadPath = '../../uploads/' . $newFileName;

        if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
            header('Location: ../../views/barang/tambah.php?error=' . urlencode('Gagal mengupload gambar'));
            exit;
        }

        // 7. Simpan ke database
        $data = [
            'kode_barang' => $kode_barang,
            'nama_barang' => $nama_barang,
            'id_kategori' => $id_kategori,
            'satuan' => $satuan,
            'harga_beli' => $harga_beli,
            'harga_jual' => $harga_jual,
            'stok' => $stok,
            'deskripsi' => $deskripsi,
            'gambar' => $newFileName
        ];

        $model->createBarang($data);
        header('Location: ../../views/barang/index.php?success=' . urlencode('Barang berhasil ditambahkan'));
        exit;
    
    case 'update':
        $id_barang = (int) ($_POST['id_barang'] ?? 0);
        $kode_barang = trim($_POST['kode_barang'] ?? '');
        $nama_barang = trim($_POST['nama_barang'] ?? '');
        $id_kategori = (int) ($_POST['id_kategori'] ?? 0);
        $satuan = trim($_POST['satuan'] ?? '');
        $harga_beli = $_POST['harga_beli'] ?? '';
        $harga_jual = $_POST['harga_jual'] ?? '';
        $stok = $_POST['stok'] ?? '';
        $deskripsi = trim($_POST['deskripsi'] ?? '');
        $gambar_lama = $_POST['gambar_lama'] ?? '';

        // Validasi field wajib
        if ($id_barang <= 0 || $kode_barang === '' || $nama_barang === '' || $id_kategori <= 0 
            || $satuan === '' || $harga_beli === '' || $harga_jual === '' || $stok === '') {
            header('Location: ../../views/barang/edit.php?id=' . $id_barang . '&error=' . urlencode('Semua field wajib diisi'));
            exit;
        }

        // Validasi angka positif
        if (!is_numeric($harga_beli) || $harga_beli < 0 ||
            !is_numeric($harga_jual) || $harga_jual < 0 ||
            !is_numeric($stok) || $stok < 0) {
            header('Location: ../../views/barang/edit.php?id=' . $id_barang . '&error=' . urlencode('Harga dan stok harus angka positif'));
            exit;
        }

        // Validasi kode_barang unik (kecuali milik barang ini sendiri)
        if ($model->isKodeBarangExists($kode_barang, $id_barang)) {
            header('Location: ../../views/barang/edit.php?id=' . $id_barang . '&error=' . urlencode('Kode barang sudah digunakan'));
            exit;
        }

        // Cek apakah user upload gambar baru
        $gambarFinal = $gambar_lama; // default: pakai gambar lama

        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['gambar'];

            $maxSize = 2 * 1024 * 1024;
            if ($file['size'] > $maxSize) {
                header('Location: ../../views/barang/edit.php?id=' . $id_barang . '&error=' . urlencode('Ukuran gambar maksimal 2MB'));
                exit;
            }

            $allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, $allowedExt)) {
                header('Location: ../../views/barang/edit.php?id=' . $id_barang . '&error=' . urlencode('Format file tidak didukung'));
                exit;
            }

            $checkImage = getimagesize($file['tmp_name']);
            if ($checkImage === false) {
                header('Location: ../../views/barang/edit.php?id=' . $id_barang . '&error=' . urlencode('File yang diupload bukan gambar valid'));
                exit;
            }

            // Upload gambar baru
            $newFileName = uniqid('barang_', true) . '.' . $ext;
            $uploadPath = '../../uploads/' . $newFileName;

            if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
                header('Location: ../../views/barang/edit.php?id=' . $id_barang . '&error=' . urlencode('Gagal mengupload gambar'));
                exit;
            }

            // Hapus gambar lama dari server
            $oldFilePath = '../../uploads/' . $gambar_lama;
            if ($gambar_lama !== '' && file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }

            $gambarFinal = $newFileName;
        }
        // Kalau user nggak upload gambar baru, $gambarFinal tetap = $gambar_lama (nggak masuk if di atas)

        $data = [
            'kode_barang' => $kode_barang,
            'nama_barang' => $nama_barang,
            'id_kategori' => $id_kategori,
            'satuan' => $satuan,
            'harga_beli' => $harga_beli,
            'harga_jual' => $harga_jual,
            'stok' => $stok,
            'deskripsi' => $deskripsi,
            'gambar' => $gambarFinal
        ];

        $model->updateBarang($id_barang, $data);
        header('Location: ../../views/barang/index.php?success=' . urlencode('Barang berhasil diupdate'));
        exit;
    
    case 'delete':
        $id_barang = (int) ($_GET['id'] ?? 0);

        if ($id_barang <= 0) {
            header('Location: ../../views/barang/index.php?error=' . urlencode('ID tidak valid'));
            exit;
        }

        // Ambil data barang dulu, buat tau nama file gambarnya
        $barang = $model->getBarangById($id_barang);

        if (!$barang) {
            header('Location: ../../views/barang/index.php?error=' . urlencode('Barang tidak ditemukan'));
            exit;
        }

        // Hapus data dari database dulu
        $deleted = $model->deleteBarang($id_barang);

        if ($deleted) {
            // Baru hapus file gambarnya dari server
            $filePath = '../../uploads/barang/' . $barang['gambar'];
            if ($barang['gambar'] !== '' && file_exists($filePath)) {
                unlink($filePath);
            }
            header('Location: ../../views/barang/index.php?success=' . urlencode('Barang berhasil dihapus'));
        } else {
            header('Location: ../../views/barang/index.php?error=' . urlencode('Gagal menghapus barang'));
        }
        exit;

    default:
        header('Location: ../../views/barang/index.php?error=Aksi+tidak+valid');
        exit;
}
?>
