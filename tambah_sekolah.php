<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php"); // Jika belum login, kembali ke login
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Sekolah</title>
    <link rel="stylesheet" href="style/style.css">
    <style>
        .admin-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .admin-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .input-group {
            margin-bottom: 15px;
        }
        .input-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .input-group input[type="text"],
        .input-group input[type="number"],
        .input-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .add-item-group {
            margin-top: 10px;
            padding: 10px;
            border: 1px solid #eee;
            border-radius: 4px;
            background-color: #f9f9f9;
        }
        .add-item-group h4 {
            margin-top: 0;
            margin-bottom: 10px;
        }
        .item-input-group {
            display: flex;
            margin-bottom: 5px;
        }
        .item-input-group input[type="text"] {
            flex-grow: 1;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            margin-right: 5px;
        }
        .add-more-btn {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
        }
        .remove-item-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
            margin-left: 5px;
        }
        .button-container {
            margin-top: 20px;
            text-align: center;
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
    </style>
    <script>
        function addMore(type) {
            const container = document.getElementById(type + '-container');
            const newInput = document.createElement('div');
            newInput.className = 'item-input-group';
            newInput.innerHTML = `<input type="text" name="${type}[]" placeholder="Nama ${type.charAt(0).toUpperCase() + type.slice(1)}" required>
                                 <button type="button" class="remove-item-btn" onclick="removeItem(this)">Hapus</button>`;
            container.appendChild(newInput);
        }

        function removeItem(button) {
            button.parentNode.remove();
        }
    </script>
</head>
<body>
    <div class="header">
        <h1>Admin Panel</h1>
        <div class="nav-buttons">
            <a href="data_sekolah.php">Kembali ke Data Sekolah</a>
        </div>
    </div>

    <div class="admin-container">
        <h2>Tambah Data Sekolah</h2>
        <form action="proses_tambah_sekolah.php" method="POST">
            <div class="input-group">
                <label for="nama">Nama Sekolah:</label>
                <input type="text" id="nama" name="nama" placeholder="Nama Sekolah" required>
            </div>
            <div class="input-group">
                <label for="biaya">Biaya:</label>
                <input type="number" id="biaya" name="biaya" placeholder="Biaya" required>
            </div>
            <div class="input-group">
                <label for="akreditasi">Akreditasi:</label>
                <select id="akreditasi" name="akreditasi" required>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                    <option value="E">E</option>
                </select>
            </div>

            <div class="add-item-group">
                <h4>Beasiswa</h4>
                <div id="beasiswa-container">
                    <div class="item-input-group">
                        <input type="text" name="beasiswa[]" placeholder="Nama Beasiswa" required>
                    </div>
                </div>
                <button type="button" class="add-more-btn" onclick="addMore('beasiswa')">Tambah Beasiswa</button>
            </div>

            <div class="add-item-group">
                <h4>Fasilitas</h4>
                <div id="fasilitas-container">
                    <div class="item-input-group">
                        <input type="text" name="fasilitas[]" placeholder="Nama Fasilitas" required>
                    </div>
                </div>
                <button type="button" class="add-more-btn" onclick="addMore('fasilitas')">Tambah Fasilitas</button>
            </div>

            <div class="add-item-group">
                <h4>Ekstrakurikuler</h4>
                <div id="ekstrakurikuler-container">
                    <div class="item-input-group">
                        <input type="text" name="ekstrakurikuler[]" placeholder="Nama Ekstrakurikuler" required>
                    </div>
                </div>
                <button type="button" class="add-more-btn" onclick="addMore('ekstrakurikuler')">Tambah Ekstrakurikuler</button>
            </div>

            <div class="button-container">
                <button type="submit">Tambah Sekolah</button>
            </div>
        </form>
    </div>
</body>
</html>