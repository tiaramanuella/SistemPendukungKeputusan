<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

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
    <title>Admin - Tambah Fasilitas</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>

<div class="header">
    <h1>Sistem Pendukung Keputusan</h1>
    <div class="nav-buttons">
        <a href="edit_sekolah.php?id=<?= urlencode($sekolah_id); ?>">Kembali ke Edit Sekolah</a>
        <a class="logout" href="logout.php">Logout</a>
    </div>
</div>

<div class="container">
    <h2>Tambah Fasilitas</h2>
    <form action="proses_tambah_fasilitas.php" method="POST">
        <input type="hidden" name="sekolah_id" value="<?= $sekolah_id; ?>">
        <div class="input-group">
            <label for="nama_fasilitas">Nama Fasilitas:</label>
            <input type="text" id="nama_fasilitas" name="nama_fasilitas" required>
        </div>
        <div class="button-container">
            <button type="submit">Tambah Fasilitas</button>
        </div>
    </form>
</div>

</body>
</html>