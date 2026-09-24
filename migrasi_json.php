<?php
require __DIR__ . '/includes/koneksi.php';

echo "<h2>Proses Migrasi JSON ke Database</h2>";

$pathJson = __DIR__ . '/data/barang.json';

if (!file_exists($pathJson)) {
    die("<p style='color:red;'>Error: File <b>$pathJson</b> tidak ditemukan.</p>");
}

$jsonString = file_get_contents($pathJson);
if ($jsonString === false) {
    die("<p style='color:red;'>Error: Gagal membaca file JSON.</p>");
}

$dataBarang = json_decode($jsonString, true);

if (!is_array($dataBarang)) {
    die("<p style='color:red;'>Error: Format JSON tidak valid atau kosong.</p>");
}

$berhasil = 0;
$gagal = 0;

$stmt = $pdo->prepare(
    "INSERT INTO barang (nama, sku, kategori, harga, stok) 
     VALUES (:nama, :sku, :kategori, :harga, :stok)"
);

echo "<ul>";

foreach ($dataBarang as $index => $item) {
    try {
        $stmt->execute([
            'nama'     => $item['nama'] ?? 'Tanpa Nama',
            'sku'      => $item['sku'] ?? null,
            'kategori' => $item['kategori'] ?? 'Lainnya',
            'harga'    => (int) ($item['harga'] ?? 0),
            'stok'     => (int) ($item['stok'] ?? 0)
        ]);
        
        echo "<li style='color:green;'>[SUKSES] Barang '{$item['nama']}' berhasil dipindahkan.</li>";
        $berhasil++;
        
    } catch (PDOException $e) {
        echo "<li style='color:red;'>[GAGAL] Barang '{$item['nama']}' gagal dipindahkan. Alasan: " . $e->getMessage() . "</li>";
        $gagal++;
    }
}

echo "</ul>";

echo "<h3>Migrasi Selesai!</h3>";
echo "<b>Total Berhasil:</b> $berhasil <br>";
echo "<b>Total Gagal:</b> $gagal <br>";
echo "<br><a href='barang/list.php'>Kembali ke Daftar Barang</a>";
?>