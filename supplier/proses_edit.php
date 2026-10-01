<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/koneksi.php';

$id           = $_POST['id'] ?? null;
$nama         = trim($_POST['nama'] ?? '');
$kodeSupplier = trim($_POST['kode_supplier'] ?? '');
$alamat       = trim($_POST['alamat'] ?? '');
$noHp         = trim($_POST['no_hp'] ?? '');

if (!$id) {
    header('Location: list.php');
    exit;
}

$errors = [];
if ($nama === '') {
    $errors[] = "Nama wajib diisi.";
}
if ($kodeSupplier === '') {
    $errors[] = "Kode supplier wajib diisi.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: edit.php?id=' . urlencode($id));
    exit;
}

$stmt = $pdo->prepare(
    "UPDATE supplier SET kode_supplier = :kode_supplier, nama = :nama,
     alamat = :alamat, no_hp = :no_hp WHERE id = :id"
);
$stmt->execute([
    'kode_supplier' => $kodeSupplier,
    'nama'          => $nama,
    'alamat'        => $alamat,
    'no_hp'         => $noHp,
    'id'            => $id,
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Supplier berhasil diperbarui.'];
header('Location: list.php');
exit;