<?php
require __DIR__ . '/../../koneksi/database.php';

class Barang {
    public $connection;

    public function __construct($connection){
        $this->connection = $connection;
    }

    // Ambil semua barang + join nama kategori
    public function getAllBarang(){
        $query = "SELECT barang.*, kategori.nama_kategori 
                  FROM barang 
                  JOIN kategori ON barang.id_kategori = kategori.id 
                  ORDER BY barang.id_barang DESC";
        return $this->connection->query($query);
    }

    // Ambil satu barang berdasarkan id_barang
    public function getBarangById($id_barang){
        $query = $this->connection->prepare("SELECT * FROM barang WHERE id_barang = ?");
        $query->bind_param("i", $id_barang);
        $query->execute();
        return $query->get_result()->fetch_assoc();
    }

    // Cek apakah kode_barang sudah dipakai (dipakai saat create & update)
    public function isKodeBarangExists($kode_barang, $exclude_id = null){
        if ($exclude_id === null) {
            $query = $this->connection->prepare("SELECT id_barang FROM barang WHERE kode_barang = ?");
            $query->bind_param("s", $kode_barang);
        } else {
            $query = $this->connection->prepare("SELECT id_barang FROM barang WHERE kode_barang = ? AND id_barang != ?");
            $query->bind_param("si", $kode_barang, $exclude_id);
        }
        $query->execute();
        $result = $query->get_result();
        return $result->num_rows > 0;
    }

    // Tambah barang baru
    public function createBarang($data){
        $query = $this->connection->prepare(
            "INSERT INTO barang 
            (kode_barang, nama_barang, id_kategori, satuan, harga_beli, harga_jual, stok, deskripsi, gambar) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $query->bind_param(
            "ssisddiss",
            $data['kode_barang'],
            $data['nama_barang'],
            $data['id_kategori'],
            $data['satuan'],
            $data['harga_beli'],
            $data['harga_jual'],
            $data['stok'],
            $data['deskripsi'],
            $data['gambar']
        );
        return $query->execute();
    }

    // Update barang (gambar opsional, ditangani di controller)
    public function updateBarang($id_barang, $data){
        $query = $this->connection->prepare(
            "UPDATE barang SET 
                kode_barang = ?, 
                nama_barang = ?, 
                id_kategori = ?, 
                satuan = ?, 
                harga_beli = ?, 
                harga_jual = ?, 
                stok = ?, 
                deskripsi = ?, 
                gambar = ?
            WHERE id_barang = ?"
        );
        $query->bind_param(
            "ssisddissi",
            $data['kode_barang'],
            $data['nama_barang'],
            $data['id_kategori'],
            $data['satuan'],
            $data['harga_beli'],
            $data['harga_jual'],
            $data['stok'],
            $data['deskripsi'],
            $data['gambar'],
            $id_barang
        );
        return $query->execute();
    }

    // Hapus barang
    public function deleteBarang($id_barang){
        $query = $this->connection->prepare("DELETE FROM barang WHERE id_barang = ?");
        $query->bind_param("i", $id_barang);
        return $query->execute();
    }

    // Ambil semua kategori (buat dropdown di form tambah/edit)
    public function getAllKategoriForDropdown(){
        return $this->connection->query("SELECT id, nama_kategori FROM kategori ORDER BY nama_kategori ASC");
    }
}
?>