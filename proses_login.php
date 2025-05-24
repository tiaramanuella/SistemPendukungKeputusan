<?php
session_start();
include 'koneksi.php';

$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

// Query ke database
$sql = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if ($row) {
    $_SESSION['admin'] = $username; // Simpan sesi admin
    header("Location: admin.php"); // Redirect ke halaman tambah sekolah
} else {
    header("Location: login.php?error=1"); // Redirect kembali ke login jika gagal
}
exit();
?>
