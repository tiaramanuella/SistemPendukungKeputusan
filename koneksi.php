<?php
$host = "localhost"; // Sesuaikan dengan konfigurasi XAMPP kamu
$user = "root"; // Default XAMPP user adalah root
$pass = ""; // Kosongkan jika tidak ada password
$db   = "spk_saw"; // Ganti dengan nama database yang digunakan

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
