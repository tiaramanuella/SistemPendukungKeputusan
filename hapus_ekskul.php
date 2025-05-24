<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';

if (isset($_GET['id']) && isset($_GET['sekolah_id'])) {
    $id_ekskul = $_GET['id'];
    $sekolah_id = $_GET['sekolah_id'];

    $query_delete = "DELETE FROM ekstrakurikuler WHERE id_ekskul = ?";
    $stmt_delete = mysqli_prepare($conn, $query_delete);
    mysqli_stmt_bind_param($stmt_delete, "i", $id_ekskul);

    if (mysqli_stmt_execute($stmt_delete)) {
        // Ekstrakurikuler berhasil dihapus, sekarang update tabel sekolah
        $query_update_sekolah = "UPDATE sekolah
                                SET ekstrakurikuler = (SELECT COUNT(*) FROM ekstrakurikuler WHERE id_sekolah = ?)
                                WHERE id = ?";
        $stmt_update_sekolah = mysqli_prepare($conn, $query_update_sekolah);
        mysqli_stmt_bind_param($stmt_update_sekolah, "ii", $sekolah_id, $sekolah_id);
        mysqli_stmt_execute($stmt_update_sekolah);
        mysqli_stmt_close($stmt_update_sekolah);

        $_SESSION['pesan'] = "Ekstrakurikuler berhasil dihapus.";
    } else {
        $_SESSION['pesan'] = "Gagal menghapus ekstrakurikuler: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt_delete);
    mysqli_close($conn);
    header("Location: edit_sekolah.php?id=" . $sekolah_id);
    exit();
} else {
    header("Location: data_sekolah.php");
    exit();
}
?>