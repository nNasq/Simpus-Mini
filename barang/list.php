<?php
$page_title = "Daftar Barang";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

// Menangkap query pencarian dari form (jika ada)
$keyword = trim($_GET['q'] ?? '');

// Logika Pencarian Server-Side
if ($keyword !== '') {
    // Menggunakan ILIKE untuk PostgreSQL (Jika pakai MySQL, ganti menjadi LIKE)
    $stmt = $pdo->prepare("SELECT * FROM barang WHERE nama ILIKE :keyword ORDER BY id DESC");
    $stmt->execute(['keyword' => "%$keyword%"]);
    $daftarBarang = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Jika tidak ada pencarian, tampilkan semua data
    $daftarBarang = $pdo->query("SELECT * FROM barang ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
}
?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <h2 class="fw-bold mb-0 text-dark">
        <i class="bi bi-box-seam text-primary me-2"></i> Daftar Barang
    </h2>
    <div class="d-flex gap-2">
        <a href="list.php" class="btn btn-outline-secondary shadow-sm px-4">
            <i class="bi bi-arrow-clockwise me-1"></i> Muat Ulang
        </a>
        <a href="tambah.php" class="btn btn-primary shadow-sm px-4">
            <i class="bi bi-plus-lg me-1"></i> Tambah Barang Baru
        </a>
    </div>
</div>

<?php if ($flash): ?>
<div class="alert alert-<?php echo $flash['type'] === 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show shadow-sm rounded-3" role="alert">
    <?php echo e($flash['pesan']); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
</div>
<?php endif; ?>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">

        <div class="row mb-4">
            <div class="col-md-6 col-lg-5">
                <!-- Ubah menjadi Form nyata agar data terkirim ke URL -->
                <form method="GET" action="list.php" class="input-group shadow-sm">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" name="q" value="<?php echo e($keyword); ?>" class="form-control border-start-0 ps-0" placeholder="Cari nama barang..." aria-label="Cari barang">
                    <button class="btn btn-primary" type="submit">Cari</button>
                    
                    <?php if($keyword): ?>
                        <a href="list.php" class="btn btn-danger" title="Hapus Filter"><i class="bi bi-x-lg"></i></a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle border text-nowrap mb-0">
                <thead class="table-primary text-center">
                    <tr>
                        <th class="text-start">Nama Barang</th>
                        <th>SKU</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Tanggal Masuk</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php if (empty($daftarBarang)): ?>
                    <tr>
                        <td colspan="7" class="text-muted py-5 text-center">
                            <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary opacity-50"></i>
                            <?php echo $keyword ? "Tidak ada barang dengan nama '<b>" . e($keyword) . "</b>'." : "Belum ada data barang. Silakan tambah lewat menu 'Tambah Barang Baru'."; ?>
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($daftarBarang as $b): ?>
                        <tr>
                            <td class="text-start fw-medium text-dark"><?php echo e($b['nama']); ?></td>
                            <td><?php echo e($b['sku']); ?></td>
                            <td><span class="badge bg-secondary bg-opacity-10 text-secondary border"><?php echo e($b['kategori']); ?></span></td>
                            <td>Rp <?php echo number_format((int)$b['harga'], 0, ',', '.'); ?></td>
                            <td>
                                <span class="fw-medium me-1"><?php echo e($b['stok']); ?></span>
                                <?php if ((int)$b['stok'] > 0): ?>
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success-subtle rounded-pill">Tersedia</span>
                                <?php else: ?>
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger-subtle rounded-pill">Kosong</span>
                                <?php endif; ?>
                            </td>
                            <!-- Memformat dan Menampilkan Kolom TIMESTAMP baru -->
                            <td class="text-secondary small">
                                <?php 
                                    $waktu = $b['tanggal_ditambahkan'] ?? 'Belum diset'; 
                                    echo ($waktu !== 'Belum diset') ? date('d M Y, H:i', strtotime($waktu)) : $waktu;
                                ?>
                            </td>
                            <td>
                                <div class="btn-group shadow-sm">
                                    <button type="button" class="btn btn-warning btn-sm text-white" title="Edit"><i class="bi bi-pencil-square"></i></button>
                                    <button type="button" class="btn btn-danger btn-sm btn-hapus" title="Hapus"><i class="bi bi-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>