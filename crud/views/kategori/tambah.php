<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kategori</title>
</head>
<body>
    <h1>Tambah Kategori</h1>
    <form action="../../controllers/kategori/KategoriController.php" method="POST">
        <input type="hidden" name="action" value="create">
        <label for="nama_kategori">Nama Kategori:</label>
        <input 
            type="text" 
            id="nama_kategori" 
            name="nama_kategori" required>
        <br><br>
        <button type="submit" value="Tambah">
            Simpan</button>
    </form>
</body>
</html>