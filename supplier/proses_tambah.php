<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

$nama         = trim($_POST['nama'] ?? '');
$kodeSupplier = trim($_POST['kode_supplier'] ?? '');
$alamat       = trim($_POST['alamat'] ?? '');
$noHp         = trim($_POST['no_hp'] ?? '');

$errors = [];
if ($nama === '') {
    $errors[] = "Nama supplier wajib diisi.";
}
if ($kodeSupplier === '') {
    $errors[] = "Kode supplier wajib diisi.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => implode(' ', $errors)];
    header('Location: tambah.php');
    exit;
}

try {
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

    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data supplier baru berhasil ditambahkan.'];
    header('Location: list.php');
    exit;

} catch (PDOException $e) {
    if ($e->getCode() == 23505 || $e->getCode() == 23000) {
        $_SESSION['flash'] = ['type' => 'danger', 'pesan' => "Gagal! Kode Supplier '{$kodeSupplier}' sudah terdaftar di sistem. Gunakan kode lain."];
    } else {
        $_SESSION['flash'] = ['type' => 'danger', 'pesan' => "Terjadi kesalahan pada database: " . $e->getMessage()];
    }
    
    header('Location: tambah.php');
    exit;
}