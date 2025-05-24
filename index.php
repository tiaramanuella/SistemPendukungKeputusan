<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bobot Kriteria</title>
    <link rel="stylesheet" href="style/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body>
    <!-- Header Navigasi -->
    <div class="header">
        <h1>Sistem Pendukung Keputusan</h1>
        <div class="nav-buttons">
        <a href="login.php">Login Admin</a>
        </div>
    </div>
    <!-- Kontainer Utama -->
    <div class="container">
        <h2>tentukan bobot masing-masing kriteria di bawah ini.</h2>
        <form action="proses_saw.php" method="POST">
            
            <div class="slider-container">
                <label class="slider-label" for="biaya">Biaya SPP</label>
                <span class="info-wrapper">
                    <i class='bx bx-info-circle info-icon'></i>
                    <div class="tooltip">Semakin Kecil Skala Semakin Kecil Juga Biaya SPP</div>
                </span>
                <div class="slider-wrapper">
                    <input type="range" min="0" max="5" value="0" class="slider" id="biaya" name="biaya" oninput="updateValue(this)">
                    <span class="slider-value" id="biayaValue">0</span>
                </div>
            </div>

            <div class="slider-container">
                <label class="slider-label" for="beasiswa">Ketersediaan Beasiswa</label>
                <span class="info-wrapper">
                    <i class='bx bx-info-circle info-icon'></i>
                    <div class="tooltip">
                            <h4>Keterangan:</h4>
                            <li>1 = 1 Beasiswa</li>
                            <li>2 = 2 Beasiswa</li>
                            <li>3 = 3 Beasiswa</li>
                            <li>4 = 4 Beasiswa</li>
                            <li>5 = 5 Beasiswa</li>
                    </div>
                </span>
                <div class="slider-wrapper">
                    <input type="range" min="0" max="5" value="0" class="slider" id="beasiswa" name="beasiswa" oninput="updateValue(this)">
                    <span class="slider-value" id="beasiswaValue">0</span>
                </div>
            </div>

            <div class="slider-container">
                <label class="slider-label" for="akreditasi">Status Akreditasi Sekolah</label>
                <span class="info-wrapper">
                    <i class='bx bx-info-circle info-icon'></i>
                    <div class="tooltip">
                            <h4>Keterangan:</h4>
                            <li>1 = Berakreditas <strong>E</strong></li>
                            <li>2 = Berakreditas <strong>D</strong></li>
                            <li>3 = Berakreditas <strong>C</strong></li>
                            <li>4 = Berakreditas <strong>B</strong></li>
                            <li>5 = Berakreditas <strong>A</strong></li>
                    </div>
                </span>
                <div class="slider-wrapper">
                    <input type="range" min="0" max="5" value="0" class="slider" id="akreditasi" name="akreditasi" oninput="updateValue(this)">
                    <span class="slider-value" id="akreditasiValue">0</span>
                </div>
            </div>

            <div class="slider-container">
                <label class="slider-label" for="fasilitas">Ketersediaan Fasilitas Belajar</label>
                <span class="info-wrapper">
                    <i class='bx bx-info-circle info-icon'></i>
                    <div class="tooltip">
                            <h4>Keterangan:</h4>
                            <li>1 = <strong>3</strong> Fasilitas</li>
                            <li>2 = <strong>6</strong> Fasilitas</li>
                            <li>3 = <strong>9</strong> Fasilitas</li>
                            <li>4 = <strong>12</strong> Fasilitas</li>
                            <li>5 = <strong>15</strong> Fasilitas</li>
                    </div>
                </span>
                <div class="slider-wrapper">
                    <input type="range" min="0" max="5" value="0" class="slider" id="fasilitas" name="fasilitas" oninput="updateValue(this)">
                    <span class="slider-value" id="fasilitasValue">0</span>
                </div>
            </div>

            <div class="slider-container">
                <label class="slider-label" for="ekstrakurikuler">Ketersediaan Ekstrakurikuler</label>
                <span class="info-wrapper">
                    <i class='bx bx-info-circle info-icon'></i>
                    <div class="tooltip">
                            <h4>Keterangan:</h4>
                            <li>1 = <strong>3</strong> Ekstrakurikuler</li>
                            <li>2 = <strong>6</strong> Ekstrakurikuler</li>
                            <li>3 = <strong>9</strong> Ekstrakurikuler</li>
                            <li>4 = <strong>12</strong> Ekstrakurikuler</li>
                            <li>5 = <strong>15</strong> Ekstrakurikuler</li>
                    </div>
                </span>
                <div class="slider-wrapper">
                    <input type="range" min="0" max="5" value="0" class="slider" id="ekstrakurikuler" name="ekstrakurikuler" oninput="updateValue(this)">
                    <span class="slider-value" id="ekstrakurikulerValue">0</span>
                </div>
            </div>
            <div class="button-container">  
                <button type="submit">→</button>
            </div>
        </form>
    </div>

    <script>
        function updateValue(slider) {
            document.getElementById(slider.id + "Value").textContent = slider.value;
        }

    </script>
        <footer class="footer">
            <div class="footer-container">
                <div class="footer-section">
                    <h3>Kontak Kami</h3>
                    <p>Email: info@sistempendukung.com</p>
                    <p>Telepon: (021) 12345678</p>
                    <p>Alamat: Jl. Contoh No.123, Jakarta</p>
                </div>
                <div class="footer-section">
                    <h3>Navigasi Cepat</h3>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="login.php">Login Admin</a></li>
                        <li><a href="tentang_kami.php">Tentang Kami</a></li>
                        <li><a href="kontak.php">Kontak</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Ikuti Kami</h3>
                    <div class="social-icons">
                        <a href="#"><i class='bx bxl-facebook'></i></a>
                        <a href="#"><i class='bx bxl-twitter'></i></a>
                        <a href="#"><i class='bx bxl-instagram'></i></a>
                        <a href="#"><i class='bx bxl-linkedin'></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Sistem Pendukung Keputusan. All Rights Reserved.</p>
            </div>
        </footer>
</body>
</html>
