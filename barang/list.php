<?php
$page_title = "Daftar Barang";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$daftarBarang = $pdo->query("SELECT * FROM barang ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <h2 class="fw-bold mb-0 text-dark">
        <i class="bi bi-box-seam text-primary me-2"></i> Daftar Barang
    </h2>
    <div class="d-flex gap-2">
        <button type="button" id="btn-muat-ulang" class="btn btn-outline-secondary shadow-sm px-4">
            <i class="bi bi-arrow-clockwise me-1"></i> Muat Ulang
        </button>
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
            <div class="col-md-6 col-lg-4">
                <div class="input-group shadow-sm">
                    <span class="input-group-text bg-white border-end-0" id="search-icon">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" id="search-input" class="form-control border-start-0 ps-0" placeholder="Ketik nama barang..." aria-describedby="search-icon">
                </div>
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
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <tr id="loading-row" style="display:none;">
                        <td colspan="6" class="text-center py-4">
                            <div id="loading-indicator" class="text-secondary">
                                <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                                <span>Memuat data...</span>
                            </div>
                        </td>
                    </tr>
                    
                    <?php if (empty($daftarBarang)): ?>
                    <tr>
                        <td colspan="6" class="text-muted py-4">Belum ada data barang. Silakan tambah lewat menu "Tambah Barang Baru".</td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($daftarBarang as $b): ?>
                        <tr>
                            <td class="text-start fw-medium text-dark"><?php echo e($b['nama']); ?></td>
                            <td><?php echo e($b['sku']); ?></td>
                            <td><?php echo e($b['kategori']); ?></td>
                            <td>Rp <?php echo number_format((int)$b['harga'], 0, ',', '.'); ?></td>
                            <td>
                                <?php echo e($b['stok']); ?>
                                <?php if ((int)$b['stok'] > 0): ?>
                                    <span class="badge bg-success rounded-pill ms-1">Tersedia</span>
                                <?php else: ?>
                                    <span class="badge bg-danger rounded-pill ms-1">Kosong</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm text-white" title="Edit"><i class="bi bi-pencil-square"></i></button>
                                <button type="button" class="btn btn-info btn-sm text-white" title="Detail"><i class="bi bi-eye"></i></button>
                                <button type="button" class="btn btn-danger btn-sm btn-hapus" title="Hapus"><i class="bi bi-trash"></i></button>
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