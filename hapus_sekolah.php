<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php"); // Redirect ke halaman login jika belum login
    exit();
}

include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Amankan dari SQL injection dengan prepared statement
    $query = "DELETE FROM sekolah WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        echo "success";
    } else {
        echo "error";
    }

    mysqli_stmt_close($stmt);
} else {
    echo "invalid";
}

mysqli_close($conn);
?>