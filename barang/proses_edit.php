<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/koneksi.php';

$id       = $_POST['id'] ?? null;
$nama     = trim($_POST['nama'] ?? '');
$sku      = trim($_POST['sku'] ?? '');
$kategori = trim($_POST['kategori'] ?? '');
$harga    = $_POST['harga'] ?? '';
$stok     = $_POST['stok'] ?? '';

if (!$id) {
    header('Location: list.php');
    exit;
}

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
    header('Location: edit.php?id=' . urlencode($id));
    exit;
}

$stmt = $pdo->prepare(
    "UPDATE barang SET nama = :nama, sku = :sku, kategori = :kategori,
     harga = :harga, stok = :stok WHERE id = :id"
);
$stmt->execute([
    'nama'     => $nama,
    'sku'      => $sku,
    'kategori' => $kategori,
    'harga'    => (int) $harga,
    'stok'     => (int) $stok,
    'id'       => $id,
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Barang berhasil diperbarui.'];
header('Location: list.php');
exit;
