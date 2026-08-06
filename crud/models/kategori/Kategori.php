<?php
require __DIR__ . '/../../koneksi/database.php';

class Kategori {
    public $connection;
    private $id;
    private $nama_kategori;

    public function __construct($connection){
        $this->connection = $connection;
    }

    public function getAllKategori(){
        return $this->connection->query("SELECT * FROM kategori ORDER BY id DESC");

    }

    public function getKategoriById($id){
        $query = $this->connection->prepare("SELECT * FROM kategori WHERE id = ?");
        $query->bind_param("i", $id);
        $query->execute();
        return $query->get_result()->fetch_assoc();
    }

    public function createKategori($nama_kategori){
        $query = $this->connection->prepare("INSERT INTO kategori (nama_kategori) VALUES (?)");
        $query->bind_param("s", $nama_kategori);
        return $query->execute();
    }

    public function updateKategori($id, $nama_kategori){
        $query = $this->connection->prepare("UPDATE kategori SET nama_kategori = ? WHERE id = ?");
        $query->bind_param("si", $nama_kategori, $id);
        return $query->execute();
    }

    public function deleteKategori($id){
        $query = $this->connection->prepare("DELETE FROM kategori WHERE id = ?");
        $query->bind_param("i", $id);
        return $query->execute();
    }
}

?>