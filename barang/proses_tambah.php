<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

$nama     = trim($_POST['nama'] ?? '');
$sku      = trim($_POST['sku'] ?? '');
$kategori = trim($_POST['kategori'] ?? '');
$harga    = $_POST['harga'] ?? '';
$stok     = $_POST['stok'] ?? '';

$errors = [];
if ($nama === '') {
    $errors[] = "Nama barang wajib diisi.";
}
if (!is_numeric($harga) || $harga < 0) {
    $errors[] = "Harga tidak boleh negatif.";
}
if (!is_numeric($stok) || $stok < 0) {
    $errors[] = "Stok tidak boleh negatif.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: tambah.php');
    exit;
}

$stmt = $pdo->prepare(
    "INSERT INTO barang (nama, sku, kategori, harga, stok)
     VALUES (:nama, :sku, :kategori, :harga, :stok)"
);

$berhasil = $stmt->execute([
    'nama'     => $nama,
    'sku'      => $sku,
    'kategori' => $kategori,
    'harga'    => (int) $harga,
    'stok'     => (int) $stok,
]);

if ($berhasil) {
    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Barang berhasil ditambahkan.'];
} else {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal menyimpan ke database. Cek struktur tabel Anda.'];
}

header('Location: list.php');
exit;