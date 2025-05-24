<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';

if (!isset($_GET['sekolah_id'])) {
    header("Location: data_sekolah.php");
    exit();
}
$sekolah_id = $_GET['sekolah_id'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Tambah Ekstrakurikuler</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>

<div class="header">
    <h1>Sistem Pendukung Keputusan</h1>
    <div class="nav-buttons">
        <a href="edit_sekolah.php?id=<?= urlencode($sekolah_id); ?>">Back to Edit Sekolah</a>
        <a class="logout" href="logout.php">Logout</a>
    </div>
</div>

<div class="container">
    <h2>Tambah Ekstrakurikuler</h2>
    <form action="proses_tambah_ekskul.php" method="POST">
        <input type="hidden" name="sekolah_id" value="<?= $sekolah_id; ?>">
        <div class="input-group">
            <label for="nama_ekskul">Nama Ekstrakurikuler:</label>
            <input type="text" id="nama_ekskul" name="nama_ekskul" required>
        </div>
        <div class="button-container">
            <button type="submit">Tambah Ekstrakurikuler</button>
        </div>
    </form>
</div>

</body>
</html>