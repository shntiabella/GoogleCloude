<?php

// =============================================================================
//  CONTROLLER AUTENTIKASI (Login / Register / Logout)
// -----------------------------------------------------------------------------
//  Dipanggil oleh halaman login.php, register.php, dan tombol logout.
//  Membaca aksi dari $_POST['action'] (login/register) atau $_GET['action'] (logout),
//  lalu memproses autentikasi dan mengelola $_SESSION.
//
//  Alur login:
//    1. Ambil email & password dari form
//    2. Cari user di database (getUserByEmail)
//    3. Cocokkan password dengan password_verify()
//    4. Set $_SESSION lalu redirect ke dashboard
// =============================================================================

session_start();

require '../../koneksi/database.php';
require '../../models/users/users.php';

$models = new User($connection);

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'register':
        $data = [
            'name' => $_POST['nama'] ?? '',
            'email' => $_POST['email'] ?? '',
            'password' => $_POST['password'] ?? '',
        ];

        // var_dump($data); // Debugging: tampilkan data yang diterima dari form
        // exit;

        // validasi input
        if ($data['name'] === '' || $data['email'] === '' || $data['password'] === '') {
            echo "<script>alert('Semua field wajib diisi'); window.location.href = '../register.php';</script>";
            exit;
        }

        // password minimal 6 karakter
        if (strlen($data['password'] < 6)) {
            echo "<script>alert('Password minimal 6 karakter'); window.location.href = '../register.php';</script>";
            exit;
        }

        //  cek email duplikat
        if ($models->getUserByEmail($data['email'])) {
            echo "<script>alert('Email sudah terdaftar'); window.location.href = '../register.php';</script>";
            exit;
        }

        $models->register($data);
        echo "<script>alert('Registrasi berhasil, silakan login'); window.location.href = '../login.php';</script>";
        exit;

    case 'login':
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        // validasi
        if ($email === '' || $password === '') {
            echo "<script>alert('Email dan password wajib diisi'); window.location.href = '../login.php';</script>";
            exit;
        }

        $users = $models->getUserByEmail($email);

        // cek user dan password ada apa engga
        if (!$users || !password_verify($password, $users['password'])) {
            echo "<script>alert('Email atau password salah'); window.location.href = '../login.php';</script>";
            exit;
        }

        // set session
        $_SESSION['user_id'] = $users['id'];
        $_SESSION['user_name'] = $users['name'];
        $_SESSION['user_email'] = $users['email'];

        header('Location: ../../index.php');
        exit;

    case 'logout':
        session_unset();
        session_destroy();
        header('Location: ../login.php');
        exit;

    default:
        echo "<script>alert('Aksi tidak valid'); window.location.href = '../login.php';</script>";
        exit;
}