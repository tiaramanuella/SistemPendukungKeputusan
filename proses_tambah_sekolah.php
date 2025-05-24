<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_sekolah = $_POST['nama'];
    $biaya = $_POST['biaya'];
    $akreditasi = $_POST['akreditasi'];
    $beasiswa_list = $_POST['beasiswa'];
    $fasilitas_list = $_POST['fasilitas'];
    $ekstrakurikuler_list = $_POST['ekstrakurikuler'];

    // 1. Simpan data sekolah ke tabel 'sekolah'
    $query_sekolah = "INSERT INTO sekolah (nama, biaya, beasiswa, akreditasi, fasilitas, ekstrakurikuler) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_sekolah = mysqli_prepare($conn, $query_sekolah);
    // Jumlah beasiswa, fasilitas, ekstrakurikuler disimpan sebagai jumlah saja di tabel sekolah
    $jumlah_beasiswa = is_array($beasiswa_list) ? count($beasiswa_list) : 0;
    $jumlah_fasilitas = is_array($fasilitas_list) ? count($fasilitas_list) : 0;
    $jumlah_ekskul = is_array($ekstrakurikuler_list) ? count($ekstrakurikuler_list) : 0;
    mysqli_stmt_bind_param($stmt_sekolah, "siisii", $nama_sekolah, $biaya, $jumlah_beasiswa, $akreditasi, $jumlah_fasilitas, $jumlah_ekskul);

    if (mysqli_stmt_execute($stmt_sekolah)) {
        $id_sekolah_baru = mysqli_insert_id($conn); // Dapatkan ID sekolah yang baru diinsert

        // 2. Simpan data beasiswa ke tabel 'beasiswa'
        if (is_array($beasiswa_list)) {
            $query_beasiswa = "INSERT INTO beasiswa (id_sekolah, nama_beasiswa) VALUES (?, ?)";
            $stmt_beasiswa = mysqli_prepare($conn, $query_beasiswa);
            foreach ($beasiswa_list as $nama_beasiswa) {
                mysqli_stmt_bind_param($stmt_beasiswa, "is", $id_sekolah_baru, trim($nama_beasiswa));
                mysqli_stmt_execute($stmt_beasiswa);
            }
            mysqli_stmt_close($stmt_beasiswa);
        }

        // 3. Simpan data fasilitas ke tabel 'fasilitas'
        if (is_array($fasilitas_list)) {
            $query_fasilitas = "INSERT INTO fasilitas (id_sekolah, nama_fasilitas) VALUES (?, ?)";
            $stmt_fasilitas = mysqli_prepare($conn, $query_fasilitas);
            foreach ($fasilitas_list as $nama_fasilitas) {
                mysqli_stmt_bind_param($stmt_fasilitas, "is", $id_sekolah_baru, trim($nama_fasilitas));
                mysqli_stmt_execute($stmt_fasilitas);
            }
            mysqli_stmt_close($stmt_fasilitas);
        }

        // 4. Simpan data ekstrakurikuler ke tabel 'ekstrakurikuler'
        if (is_array($ekstrakurikuler_list)) {
            $query_ekskul = "INSERT INTO ekstrakurikuler (id_sekolah, nama_ekskul) VALUES (?, ?)";
            $stmt_ekskul = mysqli_prepare($conn, $query_ekskul);
            foreach ($ekstrakurikuler_list as $nama_ekskul) {
                mysqli_stmt_bind_param($stmt_ekskul, "is", $id_sekolah_baru, trim($nama_ekskul));
                mysqli_stmt_execute($stmt_ekskul);
            }
            mysqli_stmt_close($stmt_ekskul);
        }

        mysqli_stmt_close($stmt_sekolah);
        header("Location: admin.php?success=1"); // Redirect dengan pesan sukses
        exit();
    } else {
        $_SESSION['error'] = "Gagal menambahkan data sekolah: " . mysqli_error($conn);
        header("Location: tambah_sekolah.php"); // Kembali ke form tambah jika gagal
        exit();
    }

    mysqli_close($conn);
} else {
    header("Location: tambah_sekolah.php");
    exit();
}
?>