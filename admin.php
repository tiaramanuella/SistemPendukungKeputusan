<?php

session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';

$query = "SELECT
    s.id,
    s.nama,
    s.biaya,
    s.akreditasi,
    COUNT(DISTINCT b.id_beasiswa) AS jumlah_beasiswa,
    COUNT(DISTINCT f.id_fasilitas) AS jumlah_fasilitas,
    COUNT(DISTINCT e.id_ekskul) AS jumlah_ekstrakurikuler
FROM sekolah s
LEFT JOIN beasiswa b ON s.id = b.id_sekolah
LEFT JOIN fasilitas f ON s.id = f.id_sekolah
LEFT JOIN ekstrakurikuler e ON s.id = e.id_sekolah
GROUP BY s.id";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Data Sekolah</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style/style.css">

</head>
<body>

<div class="header">
    <h1>Panel Admin</h1>
    <div class="nav-buttons">
        <div class="admin-info">
            <i class="fas fa-user"></i><span><?= isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Admin'; ?></span>
        </div>
        <a class="logout" href="logout.php">Logout</a>
        <a class="back" href="index.php">Back</a>
    </div>
</div>
    <h2>Data Sekolah</h2>
    <a href="tambah_sekolah.php" class="add-btn">Tambah Data</a>
    <table class="data-table">
        <tr>
            <th>ID</th>
            <th>Nama Sekolah</th>
            <th>Biaya</th>
            <th>Beasiswa</th>
            <th>Akreditasi</th>
            <th>Fasilitas</th>
            <th>Ekstrakurikuler</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $row['id']; ?></td>
            <td><?= $row['nama']; ?></td>
            <td><?= number_format($row['biaya'], 0, ',', '.'); ?></td>
            <td><?= $row['jumlah_beasiswa']; ?></td>
            <td><?= $row['akreditasi']; ?></td>
            <td><?= $row['jumlah_fasilitas']; ?></td>
            <td><?= $row['jumlah_ekstrakurikuler']; ?></td>
            <td>
                <a href="edit_sekolah.php?id=<?= urlencode($row['id']); ?>" class="edit-btn">Edit</a>
                <a href="hapus_sekolah.php" class="delete-btn" data-id="<?= $row['id']; ?>">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <h2>Keterangan Nilai Bobot</h2>
    <table class="info-table">
        <tr>
            <th rowspan="2">NAMA CRITERIA</th>
            <th colspan="5" class="sub-header">NILAI BOBOT</th>
        </tr>
        <tr class="sub-header">
            <td>1</td>
            <td>2</td>
            <td>3</td>
            <td>4</td>
            <td>5</td>
        </tr>
        <tr>
            <td>Biaya</td>
            <td>1.000.000-1.900.000</td>
            <td>2.000.000-2.900.000</td>
            <td>3.000.000-3.900.000</td>
            <td>4.000.000-4.900.000</td>
            <td>>= 5.000.000</td>
        </tr>
        <tr>
            <td>Beasiswa</td>
            <td>1</td>
            <td>2</td>
            <td>3</td>
            <td>4</td>
            <td>5</td>
        </tr>
        <tr>
            <td>Akreditasi</td>
            <td>E</td>
            <td>D</td>
            <td>C</td>
            <td>B</td>
            <td>A</td>
        </tr>
        <tr>
            <td>Fasilitas</td>
            <td>3</td>
            <td>6</td>
            <td>9</td>
            <td>12</td>
            <td>15</td>
        </tr>
        <tr>
            <td>Ekstrakurikuler</td>
            <td>3</td>
            <td>6</td>
            <td>9</td>
            <td>12</td>
            <td>15</td>
        </tr>
    </table>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteButtons = document.querySelectorAll('.delete-btn');

            deleteButtons.forEach(function (btn) {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    const id = this.getAttribute('data-id');

                    if (confirm('Hapus data sekolah ini?')) {
                        fetch('hapus_sekolah.php?id=' + id)
                            .then(response => response.text())
                            .then(result => {
                                if (result.trim() === 'success') {
                                    // Hapus baris dari tabel
                                    this.closest('tr').remove();
                                    alert("Data sekolah berhasil dihapus!");
                                } else {
                                    alert("Gagal menghapus data sekolah.");
                                }
                            });
                    }
                });
            });
        });
    </script>
<?php 
include "footer.php"
?>
</body>
</html>