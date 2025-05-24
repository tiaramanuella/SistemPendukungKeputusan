<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Ranking Sekolah</title>
    <link rel="stylesheet" href="style/proses-saw.css">
</head>
<body>
    <div class="header">
        <h1>Sistem Pendukung Keputusan</h1>
        <div class="nav-buttons">
        <a href="login.php">Login Admin</a>
        </div>
    </div>
    <div class="container">
        <h2>Hasil Ranking Sekolah</h2>
            <?php
                // Koneksi database
                include 'koneksi.php';

                // Ambil bobot dari form user
                $biaya = isset($_POST['biaya']) ? $_POST['biaya'] : '';
                $beasiswa = isset($_POST['beasiswa']) ? $_POST['beasiswa'] : '';
                $akreditasi = isset($_POST['akreditasi']) ? $_POST['akreditasi'] : '';
                $fasilitas = isset($_POST['fasilitas']) ? $_POST['fasilitas'] : '';
                $ekstrakurikuler = isset($_POST['ekstrakurikuler']) ? $_POST['ekstrakurikuler'] : '';

                // Validasi apakah semua kriteria telah diisi
                if ($biaya === '' || $beasiswa === '' || $akreditasi === '' || $fasilitas === '' || $ekstrakurikuler === '') {
                    echo '<script>alert("Tolong isi semua Kriteria");</script>';
                    echo '<p><a href="javascript:history.back()" class="btn">Kembali ke Form</a></p>';
                } else {
                    // Total bobot
                    $total_bobot = $biaya + $beasiswa + $akreditasi + $fasilitas + $ekstrakurikuler;

                    // Pencegahan pembagian dengan nol jika total bobot adalah 0 (walaupun seharusnya tidak terjadi jika semua diisi)
                    if ($total_bobot == 0) {
                        echo '<script>alert("Total bobot tidak boleh nol. Pastikan Anda mengisi setidaknya satu kriteria.");</script>';
                        echo '<p><a href="javascript:history.back()" class="btn">Kembali ke Form</a></p>';
                    } else {
                        // Normalisasi bobot
                        $bobot = [
                            'biaya' => $biaya / $total_bobot,
                            'beasiswa' => $beasiswa / $total_bobot,
                            'akreditasi' => $akreditasi / $total_bobot,
                            'fasilitas' => $fasilitas / $total_bobot,
                            'ekstrakurikuler' => $ekstrakurikuler / $total_bobot
                        ];

                        // Ambil data dari database
                        $query = "SELECT * FROM sekolah";
                        $result = $conn->query($query);

                        // Inisialisasi array
                        $data = [];
                        $max_beasiswa = 0;

                        // Cari nilai maksimum beasiswa terlebih dahulu
                        $result->data_seek(0); // Reset pointer result
                        while ($row = $result->fetch_assoc()) {
                            if ($row['beasiswa'] > $max_beasiswa) {
                                $max_beasiswa = $row['beasiswa'];
                            }
                        }

                        // Reset hasil query
                        $result->data_seek(0);

                        // Inisialisasi array data dengan normalisasi yang benar
                        while ($row = $result->fetch_assoc()) {
                            $data[] = [
                                'id' => $row['id'],
                                'nama' => $row['nama'],

                                // Biaya dinilai secara kategori
                                'biaya' => $row['biaya'] == 5000000 ? 5 : ($row['biaya'] == 4000000 ? 4 : ($row['biaya'] == 3000000 ? 3 : ($row['biaya'] == 2000000 ? 2 : 1))),

                                // Beasiswa di-normalisasi: nilai beasiswa dibagi dengan nilai maksimum
                                // Jika beasiswa bernilai 0, langsung atur hasil normalisasi menjadi 0
                                'beasiswa' => $row['beasiswa'] == 0 ? 0 : ($row['beasiswa'] / $max_beasiswa),

                                // Akreditasi sudah disesuaikan dengan tipe VARCHAR (A=5, B=4, C=3, D=2, E=1)
                                'akreditasi' => match (strtoupper($row['akreditasi'])) {
                                    'A' => 5,
                                    'B' => 4,
                                    'C' => 3,
                                    'D' => 2,
                                    'E' => 1,
                                    default => 0
                                },

                                // Fasilitas dan Ekstrakurikuler dibagi 3 sesuai yang kamu tentukan
                                'fasilitas' => $row['fasilitas'] / 3,
                                'ekstrakurikuler' => $row['ekstrakurikuler'] / 3
                            ];
                        }


                        // Normalisasi Matriks
                        $normalisasi = [];

                        $min_biaya = min(array_column($data, 'biaya'));
                        $max_beasiswa = max(array_column($data, 'beasiswa'));
                        $max_akreditasi = max(array_column($data, 'akreditasi'));
                        $max_fasilitas = max(array_column($data, 'fasilitas'));
                        $max_ekstrakurikuler = max(array_column($data, 'ekstrakurikuler'));

                        foreach ($data as $item) {
                            $normalisasi[] = [
                                'id' => $item['id'],
                                'nama' => $item['nama'],
                                // Biaya adalah Cost, maka nilai minimum dibagi nilai alternatif
                                'biaya' => $min_biaya / $item['biaya'],

                                // Beasiswa adalah Benefit, nilai alternatif dibagi nilai maksimum
                                'beasiswa' => $item['beasiswa'] / $max_beasiswa,

                                // Akreditasi adalah Benefit, nilai alternatif dibagi nilai maksimum
                                'akreditasi' => $item['akreditasi'] / $max_akreditasi,

                                // Fasilitas adalah Benefit, nilai alternatif dibagi nilai maksimum
                                'fasilitas' => $item['fasilitas'] / $max_fasilitas,

                                // Ekstrakurikuler adalah Benefit, nilai alternatif dibagi nilai maksimum
                                'ekstrakurikuler' => $item['ekstrakurikuler'] / $max_ekstrakurikuler,

                                'detail' => $item
                            ];
                        }

                        // Perhitungan Nilai Akhir (V)
                        $hasil_akhir = [];
                        foreach ($normalisasi as $item) {
                            $nilai = (
                                ($bobot['biaya'] * $item['biaya']) +
                                ($bobot['beasiswa'] * $item['beasiswa']) +
                                ($bobot['akreditasi'] * $item['akreditasi']) +
                                ($bobot['fasilitas'] * $item['fasilitas']) +
                                ($bobot['ekstrakurikuler'] * $item['ekstrakurikuler'])
                            );

                            $hasil_akhir[] = [
                                'id' => $item['id'],  // Menambahkan id
                                'nama' => $item['nama'],
                                'nilai' => round($nilai, 5), // Dibulatkan 5 angka di belakang koma
                                'detail' => $item['detail']   // Tambahkan informasi detail
                            ];

                        }

                        // Sorting berdasarkan nilai terbesar
                        usort($hasil_akhir, function ($a, $b) {
                            return $b['nilai'] <=> $a['nilai'];
                        });

                        echo "<table>
                        <tr>
                            <th>Peringkat</th>
                            <th>Nama Sekolah</th>
                            <th>Nilai Akhir</th>
                        </tr>";

                        $peringkat = 1;
                        foreach ($hasil_akhir as $item) {
                            echo "<tr>
                                <td>$peringkat</td>
                                <td>{$item['nama']}</td>
                                <td>{$item['nilai']}</td>
                            </tr>";
                            $peringkat++;
                        }
                        echo "</table>";

                        // Ambil detail sekolah peringkat 1 langsung dari database
                        if (!empty($hasil_akhir)) {
                            $id_terbaik = $hasil_akhir[0]['id'];
                            $query_detail = "SELECT * FROM sekolah WHERE id = '$id_terbaik'";
                            $result_detail = $conn->query($query_detail);
                            $detail_terbaik = $result_detail->fetch_assoc(); // Ambil detail peringkat pertama

                            echo '<div class="detail-container">';
                            echo '<h3>Sekolah yang Direkomendasikan:</h3>';
                            echo '<p>Nama Sekolah: ' . $detail_terbaik['nama'] . '</p>';
                            echo '<p>Biaya: Rp ' . number_format($detail_terbaik['biaya'], 0, ',', '.') . ' / Bulan</p>';
                            echo '<p>Ketersediaan Beasiswa: ' . $detail_terbaik['beasiswa'] . '</p>';
                            echo '<div class="beasiswa-container">';
                            echo '<h4>Daftar Beasiswa:</h4>';
                            echo '<ul>';
                            $id_sekolah_terbaik = $detail_terbaik['id'];
                            $query_beasiswa = "SELECT nama_beasiswa FROM beasiswa WHERE id_sekolah = '$id_sekolah_terbaik'";
                            $result_beasiswa = $conn->query($query_beasiswa);
                            if ($result_beasiswa->num_rows > 0) {
                                while ($row_beasiswa = $result_beasiswa->fetch_assoc()) {
                                    echo "<li>" . $row_beasiswa['nama_beasiswa'] . "</li>";
                                }
                            } else {
                                echo "<li>Tidak ada beasiswa yang tersedia.</li>";
                            }
                            echo '</ul>';
                            echo '</div>';
                            echo '<p>Akreditasi: ' . $detail_terbaik['akreditasi'] . '</p>';
                            echo '<p>Jumlah Fasilitas: ' . $detail_terbaik['fasilitas'] . '</p>';
                            echo '<div class="fasilitas-container">';
                            echo '<h4>Daftar Fasilitas:</h4>';
                            echo '<ul>';
                            $query_fasilitas = "SELECT nama_fasilitas FROM fasilitas WHERE id_sekolah = '$id_sekolah_terbaik'";
                            $result_fasilitas = $conn->query($query_fasilitas);
                            if ($result_fasilitas->num_rows > 0) {
                                while ($row_fasilitas = $result_fasilitas->fetch_assoc()) {
                                    echo "<li>" . $row_fasilitas['nama_fasilitas'] . "</li>";
                                }
                            } else {
                                echo "<li>Tidak ada fasilitas yang tersedia.</li>";
                            }
                            echo '</ul>';
                            echo '</div>';
                            echo '<p>Jumlah Ekstrakurikuler: ' . $detail_terbaik['ekstrakurikuler'] . '</p>';
                            echo '<div class="ekskul-container">';
                            echo '<h4>Daftar Ekstrakurikuler:</h4>';
                            echo '<ul>';
                            $query_ekskul = "SELECT nama_ekskul FROM ekstrakurikuler WHERE id_sekolah = '$id_sekolah_terbaik'";
                            $result_ekskul = $conn->query($query_ekskul);
                            if ($result_ekskul->num_rows > 0) {
                                while ($row_ekskul = $result_ekskul->fetch_assoc()) {
                                    echo "<li>" . $row_ekskul['nama_ekskul'] . "</li>";
                                }
                            } else {
                                echo "<li>Tidak ada ekstrakurikuler yang tersedia.</li>";
                            }
                            echo '</ul>';
                            echo '</div>';
                            echo '</div>';
                        }
                    }
                }
            ?>

        <a href="index.php" class="btn">Kembali</a>
    </div>

    <script>
        function toggleDetail(id) {
            const detail = document.getElementById('detail-' + id);
            detail.style.display = (detail.style.display === 'none') ? 'block' : 'none';
        }
    </script>
</body>
</html>