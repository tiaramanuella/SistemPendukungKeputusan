<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';

if (isset($_GET['id'])) {
    $id_sekolah = $_GET['id'];
    // Ambil data sekolah
    $query_sekolah = "SELECT * FROM sekolah WHERE id = ?";
    $stmt_sekolah = mysqli_prepare($conn, $query_sekolah);
    mysqli_stmt_bind_param($stmt_sekolah, "i", $id_sekolah);
    mysqli_stmt_execute($stmt_sekolah);
    $result_sekolah = mysqli_stmt_get_result($stmt_sekolah);
    $sekolah = mysqli_fetch_assoc($result_sekolah);
    mysqli_stmt_close($stmt_sekolah);

    if (!$sekolah) {
        header("Location: data_sekolah.php");
        exit();
    }

    // Proses update data utama jika form disubmit
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST['id'];
        $nama = $_POST['nama'];
        $biaya = $_POST['biaya'];
        $akreditasi = $_POST['akreditasi'];

        $query_update = "UPDATE sekolah SET nama=?, biaya=?, akreditasi=? WHERE id=?";
        $stmt_update = mysqli_prepare($conn, $query_update);
        mysqli_stmt_bind_param($stmt_update, "sisi", $nama, $biaya, $akreditasi, $id);

        if (mysqli_stmt_execute($stmt_update)) {
            echo "<script>alert('Data utama sekolah berhasil disimpan!'); window.location.href = 'admin.php';</script>";
            exit();
        } else {
            $_SESSION['pesan'] = "Gagal menyimpan perubahan utama: " . mysqli_error($conn);
            // Pesan gagal bisa ditampilkan di halaman edit
        }
        mysqli_stmt_close($stmt_update);
    }

    // Ambil data beasiswa
    $query_beasiswa = "SELECT * FROM beasiswa WHERE id_sekolah = ?";
    $stmt_beasiswa = mysqli_prepare($conn, $query_beasiswa);
    mysqli_stmt_bind_param($stmt_beasiswa, "i", $id_sekolah);
    mysqli_stmt_execute($stmt_beasiswa);
    $result_beasiswa = mysqli_stmt_get_result($stmt_beasiswa);

    // Ambil data fasilitas
    $query_fasilitas = "SELECT * FROM fasilitas WHERE id_sekolah = ?";
    $stmt_fasilitas = mysqli_prepare($conn, $query_fasilitas);
    mysqli_stmt_bind_param($stmt_fasilitas, "i", $id_sekolah);
    mysqli_stmt_execute($stmt_fasilitas);
    $result_fasilitas = mysqli_stmt_get_result($stmt_fasilitas);

    // Ambil data ekstrakurikuler
    $query_ekskul = "SELECT * FROM ekstrakurikuler WHERE id_sekolah = ?";
    $stmt_ekskul = mysqli_prepare($conn, $query_ekskul);
    mysqli_stmt_bind_param($stmt_ekskul, "i", $id_sekolah);
    mysqli_stmt_execute($stmt_ekskul);
    $result_ekskul = mysqli_stmt_get_result($stmt_ekskul);

} else {
    header("Location: data_sekolah.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Edit Data Sekolah</title>
    <link rel="stylesheet" href="style/style.css">
    <style>
        .sub-section {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .sub-section h3 {
            margin-top: 0;
            margin-bottom: 10px;
        }
        .list-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 5px;
            padding-bottom: 5px;
            border-bottom: 1px dotted #eee;
        }
        .list-item:last-child {
            border-bottom: none;
        }
        .action-buttons a, .add-button {
            display: inline-block;
            padding: 5px 10px;
            margin-right: 5px;
            text-decoration: none;
            border-radius: 3px;
            font-size: 0.9em;
        }
        .edit-sub-btn {
            background-color: #007bff;
            color: white;
        }
        .delete-sub-btn {
            background-color: #dc3545;
            color: white;
        }
        .add-button {
            background-color: #28a745;
            color: white;
            margin-top: 10px;
        }
        .input-group {
            margin-bottom: 10px;
        }
        .input-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .input-group input[type="text"], .input-group input[type="number"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .button-container {
            margin-top: 20px;
        }
        .button-container button[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
        }
        .alert {
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
        }
        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Sistem Pendukung Keputusan</h1>
    <div class="nav-buttons">
        <a href="admin.php">Back</a>
        <a class="logout" href="logout.php">Logout</a>
    </div>
</div>

<div class="container">
    <h2>Edit Data Sekolah</h2>

    <?php if (isset($_SESSION['pesan'])): ?>
        <div class="alert <?= (strpos($_SESSION['pesan'], 'berhasil') !== false) ? 'alert-success' : 'alert-danger'; ?>">
            <?= $_SESSION['pesan']; ?>
        </div>
        <?php unset($_SESSION['pesan']); ?>
    <?php endif; ?>

    <form method="POST">
        <div class="input-group">
            <label for="nama">Nama Sekolah:</label>
            <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($sekolah['nama']); ?>" required>
        </div>
        <div class="input-group">
            <label for="biaya">Biaya:</label>
            <input type="number" id="biaya" name="biaya" value="<?= htmlspecialchars($sekolah['biaya']); ?>" required>
        </div>
        <div class="input-group">
            <label for="akreditasi">Akreditasi:</label>
            <select id="akreditasi" name="akreditasi" required>
                <option value="A" <?= ($sekolah['akreditasi'] == 'A') ? 'selected' : ''; ?>>A</option>
                <option value="B" <?= ($sekolah['akreditasi'] == 'B') ? 'selected' : ''; ?>>B</option>
                <option value="C" <?= ($sekolah['akreditasi'] == 'C') ? 'selected' : ''; ?>>C</option>
                <option value="D" <?= ($sekolah['akreditasi'] == 'D') ? 'selected' : ''; ?>>D</option>
                <option value="E" <?= ($sekolah['akreditasi'] == 'E') ? 'selected' : ''; ?>>E</option>
            </select>
        </div>
        <input type="hidden" name="id" value="<?= $sekolah['id']; ?>">
        <div class="button-container">
            <button type="submit">Simpan Perubahan Utama</button>
        </div>
    </form>

    <div class="sub-section">
        <h3>Manajemen Beasiswa</h3>
        <?php if (mysqli_num_rows($result_beasiswa) > 0): ?>
            <?php while ($beasiswa_item = mysqli_fetch_assoc($result_beasiswa)): ?>
                <div class="list-item">
                    <span><?= htmlspecialchars($beasiswa_item['nama_beasiswa']); ?></span>
                    <div class="action-buttons">
                        <!-- <a href="edit_beasiswa.php?id=<?= urlencode($beasiswa_item['id_beasiswa']); ?>" class="edit-sub-btn">Edit</a> -->
                        <a href="hapus_beasiswa.php?id=<?= urlencode($beasiswa_item['id_beasiswa']); ?>&sekolah_id=<?= urlencode($id_sekolah); ?>" class="delete-sub-btn" onclick="return confirm('Hapus beasiswa ini?')">Hapus</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Belum ada data beasiswa.</p>
        <?php endif; ?>
        <a href="tambah_beasiswa.php?sekolah_id=<?= urlencode($id_sekolah); ?>" class="add-button">Tambah Beasiswa</a>
    </div>

    <div class="sub-section">
        <h3>Manajemen Fasilitas</h3>
        <?php if (mysqli_num_rows($result_fasilitas) > 0): ?>
            <?php while ($fasilitas_item = mysqli_fetch_assoc($result_fasilitas)): ?>
                <div class="list-item">
                    <span><?= htmlspecialchars($fasilitas_item['nama_fasilitas']); ?></span>
                    <div class="action-buttons">
                        <!-- <a href="edit_fasilitas.php?id=<?= urlencode($fasilitas_item['id_fasilitas']); ?>" class="edit-sub-btn">Edit</a> -->
                        <a href="hapus_fasilitas.php?id=<?= urlencode($fasilitas_item['id_fasilitas']); ?>&sekolah_id=<?= urlencode($id_sekolah); ?>" class="delete-sub-btn" onclick="return confirm('Hapus fasilitas ini?')">Hapus</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Belum ada data fasilitas.</p>
        <?php endif; ?>
        <a href="tambah_fasilitas.php?sekolah_id=<?= urlencode($id_sekolah); ?>" class="add-button">Tambah Fasilitas</a>
    </div>

    <div class="sub-section">
        <h3>Manajemen Ekstrakurikuler</h3>
        <?php if (mysqli_num_rows($result_ekskul) > 0): ?>
            <?php while ($ekskul_item = mysqli_fetch_assoc($result_ekskul)): ?>
                <div class="list-item">
                    <span><?= htmlspecialchars($ekskul_item['nama_ekskul']); ?></span>
                    <div class="action-buttons">
                        <!-- <a href="edit_ekskul.php?id=<?= urlencode($ekskul_item['id_ekskul']); ?>" class="edit-sub-btn">Edit</a> -->
                        <a href="hapus_ekskul.php?id=<?= urlencode($ekskul_item['id_ekskul']); ?>&sekolah_id=<?= urlencode($id_sekolah); ?>" class="delete-sub-btn" onclick="return confirm('Hapus ekstrakurikuler ini?')">Hapus</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Belum ada data ekstrakurikuler.</p>
        <?php endif; ?>
        <a href="tambah_ekskul.php?sekolah_id=<?= urlencode($id_sekolah); ?>" class="add-button">Tambah Ekstrakurikuler</a>
    </div>

</div>

<script>
    <?php if (isset($_SESSION['pesan']) && strpos($_SESSION['pesan'], 'berhasil') !== false): ?>
        alert("<?= $_SESSION['pesan']; ?>");
        window.location.href = 'admin.php';
    <?php endif; ?>
</script>

</body>
</html>