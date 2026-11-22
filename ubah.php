<?php
error_reporting(E_ALL);
include_once 'koneksi.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    header('Location: index.php');
    exit;
}

$sql_select = "SELECT * FROM data_barang WHERE id_barang = $id";
$res_select = mysqli_query($conn, $sql_select);
$data = mysqli_fetch_assoc($res_select);

if (!$data) {
    echo "Data barang tidak ditemukan.";
    exit;
}

if (isset($_POST['submit'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $harga_jual = (int) $_POST['harga_jual'];
    $harga_beli = (int) $_POST['harga_beli'];
    $stok = (int) $_POST['stok'];

    $gambar_sql = "";
    if (!empty($_FILES['file_gambar']['name']) && $_FILES['file_gambar']['error'] == 0) {
        $filename = str_replace(' ', '_', basename($_FILES['file_gambar']['name']));
        $upload_dir = dirname(__FILE__) . '/gambar/';

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $destination = $upload_dir . $filename;
        if (move_uploaded_file($_FILES['file_gambar']['tmp_name'], $destination)) {
            $gambar_path = mysqli_real_escape_string($conn, 'gambar/' . $filename);
            $gambar_sql = ", gambar = '$gambar_path'";
        }
    }

    $sql_update = "UPDATE data_barang SET
                    nama = '$nama',
                    kategori = '$kategori',
                    harga_jual = $harga_jual,
                    harga_beli = $harga_beli,
                    stok = $stok
                    $gambar_sql
                   WHERE id_barang = $id";

    if (mysqli_query($conn, $sql_update)) {
        header('Location: index.php');
        exit;
    } else {
        echo "Gagal mengubah data: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <title>Ubah Barang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .form-group {
            margin-bottom: 10px;
        }
        label {
            display: inline-block;
            width: 110px;
        }
        input[type="text"],
        input[type="number"],
        select {
            padding: 4px 6px;
            width: 180px;
        }
        button {
            margin-left: 114px;
            background-color: #0000ff;
            color: #ffffff;
            border: none;
            padding: 6px 14px;
            border-radius: 3px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Ubah Barang</h1>
    <hr>

    <form method="post" action="ubah.php?id=<?= $id; ?>" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nama">Nama Barang</label>
            <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($data['nama']); ?>" required>
        </div>

        <div class="form-group">
            <label for="kategori">Kategori</label>
            <select id="kategori" name="kategori">
                <option value="Komputer" <?= ($data['kategori'] == 'Komputer') ? 'selected' : ''; ?>>Komputer</option>
                <option value="Elektronik" <?= ($data['kategori'] == 'Elektronik') ? 'selected' : ''; ?>>Elektronik</option>
                <option value="Hand Phone" <?= ($data['kategori'] == 'Hand Phone') ? 'selected' : ''; ?>>Hand Phone</option>
            </select>
        </div>

        <div class="form-group">
            <label for="harga_jual">Harga Jual</label>
            <input type="number" id="harga_jual" name="harga_jual" value="<?= htmlspecialchars($data['harga_jual']); ?>" required>
        </div>

        <div class="form-group">
            <label for="harga_beli">Harga Beli</label>
            <input type="number" id="harga_beli" name="harga_beli" value="<?= htmlspecialchars($data['harga_beli']); ?>" required>
        </div>

        <div class="form-group">
            <label for="stok">Stok</label>
            <input type="number" id="stok" name="stok" value="<?= htmlspecialchars($data['stok']); ?>" required>
        </div>

        <div class="form-group">
            <label for="file_gambar">File Gambar</label>
            <input type="file" id="file_gambar" name="file_gambar" accept="image/*">
        </div>

        <button type="submit" name="submit">Simpan</button>
    </form>
</body>
</html>