<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sekolah_id = $_POST['sekolah_id'];
    $nama_fasilitas = $_POST['nama_fasilitas'];

    $query_insert = "INSERT INTO fasilitas (id_sekolah, nama_fasilitas) VALUES (?, ?)";
    $stmt_insert = mysqli_prepare($conn, $query_insert);
    mysqli_stmt_bind_param($stmt_insert, "is", $sekolah_id, $nama_fasilitas);

    if (mysqli_stmt_execute($stmt_insert)) {
        // Fasilitas berhasil ditambahkan, sekarang update tabel sekolah
        $query_update_sekolah = "UPDATE sekolah
                                SET fasilitas = (SELECT COUNT(*) FROM fasilitas WHERE id_sekolah = ?)
                                WHERE id = ?";
        $stmt_update_sekolah = mysqli_prepare($conn, $query_update_sekolah);
        mysqli_stmt_bind_param($stmt_update_sekolah, "ii", $sekolah_id, $sekolah_id);
        mysqli_stmt_execute($stmt_update_sekolah);
        mysqli_stmt_close($stmt_update_sekolah);

        $_SESSION['pesan'] = "Fasilitas berhasil ditambahkan.";
    } else {
        $_SESSION['pesan'] = "Gagal menambahkan fasilitas: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt_insert);
    mysqli_close($conn);
    header("Location: edit_sekolah.php?id=" . $sekolah_id);
    exit();
} else {
    header("Location: data_sekolah.php");
    exit();
}
?>