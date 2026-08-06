<?php
require '../../koneksi/database.php';
require '../../models/kategori/kategori.php';

$model = new Kategori($connection);

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'create':
        $nama_kategori = trim($_POST['nama_kategori'] ?? '');
        if ($nama_kategori === '') {
            header('Location: ../../views/kategori/index.php?error=Nama+kategori+kosong');
            exit;
        }
        $model->createKategori($nama_kategori);
        header('Location: ../../views/kategori');
        exit;

    case 'update':
        $id = (int) ($_POST['id'] ?? 0);
        $nama_kategori = trim($_POST['nama_kategori'] ?? '');
        if ($id <= 0 || $nama_kategori === '') {
            header('Location: ../../views/kategori/index.php?error=ID+atau+Nama+kosong');
            exit;
        }
        $ok = $model->updateKategori($id, $nama_kategori);
        if (!$ok) {
            $err = urlencode($connection->error ?? 'Gagal+update');
            header("Location: ../../views/kategori/index.php?error=$err");
            exit;
        }
        header('Location: ../../views/kategori');
        exit;

    case 'edit':
        $id = (int) ($_GET['id'] ?? 0);
        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(['error' => 'ID tidak boleh kosong']);
            exit;
        }
        $kategori = $model->getKategoriById($id);
        echo json_encode($kategori);
        exit;

    case 'delete':
        $id = (int) ($_GET['id'] ?? 0);
        if ($id <= 0) {
            header('Location: ../../views/kategori/index.php?error=ID+kosong');
            exit;
        }
        $model->deleteKategori($id);
        header('Location: ../../views/kategori');
        exit;

    default:
        header('Location: ../../views/kategori/index.php?error=Aksi+tidak+valid');
        exit;
}
?>