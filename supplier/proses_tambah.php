<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

$nama         = trim($_POST['nama'] ?? '');
$kodeSupplier = trim($_POST['kode_supplier'] ?? '');
$alamat       = trim($_POST['alamat'] ?? '');
$noHp         = trim($_POST['no_hp'] ?? '');

$errors = [];
if ($nama === '') {
    $errors[] = "Nama wajib diisi.";
}
if ($kodeSupplier === '') {
    $errors[] = "Kode supplier wajib diisi.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: tambah.php');
    exit;
}

$stmt = $pdo->prepare(
    "INSERT INTO supplier (kode_supplier, nama, alamat, no_hp)
     VALUES (:kode_supplier, :nama, :alamat, :no_hp)"
);
$stmt->execute([
    'kode_supplier' => $kodeSupplier,
    'nama'          => $nama,
    'alamat'        => $alamat,
    'no_hp'         => $noHp,
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Supplier berhasil ditambahkan.'];
header('Location: list.php');
exit;