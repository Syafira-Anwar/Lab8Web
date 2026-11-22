<?php
include "koneksi.php";

$sql = "SELECT * FROM data_barang";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Barang</title>
    <style>
        table {
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 6px 10px;
        }
        th {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <h1>Data Barang</h1>
    <hr>
    <p><a href="tambah.php">Tambah Barang</a></p>

    <table>
        <thead>
            <tr>
                <th>Gambar</th>
                <th>Nama Barang</th>
                <th>Katagori</th>
                <th>Harga Jual</th>
                <th>Harga Beli</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nama']); ?></td>
                        <td><?= htmlspecialchars($row['nama']); ?></td>
                        <td><?= htmlspecialchars($row['kategori']); ?></td>
                        <td><?= htmlspecialchars($row['harga_jual']); ?></td>
                        <td><?= htmlspecialchars($row['harga_beli']); ?></td>
                        <td><?= htmlspecialchars($row['stok']); ?></td>
                        <td>
                            <a href="ubah.php?id=<?= $row['id_barang']; ?>">Ubah</a>
                            <a href="hapus.php?id=<?= $row['id_barang']; ?>" onclick="return confirm('Yakin ingin menghapus data ini?');">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">Belum ada data</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>