<?php
session_start();
// Hapus semua data sesi
session_unset();
// Hancurkan sesi
session_destroy();
// Set pesan logout
$_SESSION['logout_message'] = "Logout berhasil!";
// Redirect kembali ke halaman index
header("Location: index.php");
exit();
?>