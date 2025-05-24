<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $biaya = $_POST['biaya'];

    $query = "UPDATE sekolah SET nama=?, biaya=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sii", $nama, $biaya, $id);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['pesan'] = "Data utama sekolah berhasil diubah.";
    } else {
        $_SESSION['pesan'] = "Gagal mengubah data utama sekolah: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    header("Location: edit_sekolah.php?id=" . $id); // Kembali ke halaman edit
    exit();
} else {
    header("Location: data_sekolah.php");
    exit();
}
?>