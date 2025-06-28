<?php
// Pengaturan koneksi database
$db_host = 'localhost';
$db_user = 'root';
$db_pass = ''; // Kosongkan jika tidak ada password di XAMPP Anda
$db_name = 'db_portofolio';

// Membuat koneksi
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Cek koneksi
if (!$conn) {
    die("Koneksi Gagal: " . mysqli_connect_error());
}

// Memulai session untuk digunakan di halaman admin
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>