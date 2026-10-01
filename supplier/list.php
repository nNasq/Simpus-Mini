<?php
$page_title = "Daftar Supplier";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

// Konfigurasi Paginasi & Pencarian
$perPage = 5;
$page = max(1, (int) ($_GET['page'] ?? 1));
$offset = ($page - 1) * $perPage;
$keyword = trim($_GET['q'] ?? '');

// Eksekusi Kueri Data
if ($keyword !== '') {
    $hitung = $pdo->prepare("SELECT COUNT(*) FROM supplier WHERE nama ILIKE :kw");
    $hitung->execute(['kw' => '%' . $keyword . '%']);
    $totalRows = $hitung->fetchColumn();

    $stmt = $pdo->prepare("SELECT * FROM supplier WHERE nama ILIKE :kw ORDER BY id DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue('kw', '%' . $keyword . '%');
} else {
    $totalRows = $pdo->query("SELECT COUNT(*) FROM supplier")->fetchColumn();
    $stmt = $pdo->prepare("SELECT * FROM supplier ORDER BY id DESC LIMIT :limit OFFSET :offset");
}
$stmt->bindValue('limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue('offset', $offset, PDO::PARAM_INT);
$stmt->execute();

$daftarSupplier = $stmt->fetchAll(PDO::FETCH_ASSOC);
$totalPages = max(1, (int) ceil($totalRows / $perPage));

$sudahLogin = isset($_SESSION['user_id']);
?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <h2 class="fw-bold mb-0 text-dark">
        <i class="bi bi-truck text-primary me-2"></i> Daftar Supplier
    </h2>
    <div class="d-flex gap-2">
        <a href="list.php" class="btn btn-outline-secondary shadow-sm px-4">
            <i class="bi bi-arrow-clockwise me-1"></i> Muat Ulang
        </a>
        <?php if ($sudahLogin): ?>
            <a href="tambah.php" class="btn btn-primary shadow-sm px-4">
                <i class="bi bi-plus-lg me-1"></i> Tambah Supplier Baru
            </a>
        <?php endif; ?>
    </div>
</div>

<?php if ($flash): ?>
    <div class="alert alert-<?php echo $flash['type'] === 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show shadow-sm rounded-3 d-flex align-items-center" role="alert">
        <i class="bi <?php echo $flash['type'] === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill'; ?> fs-5 me-2"></i>
        <div><?php echo e($flash['pesan']); ?></div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">

        <!-- Baris Pencarian & Info Total Data -->
        <div class="row align-items-center mb-4 g-3">
            <div class="col-md-7 col-lg-5">
                <form method="get" action="list.php" class="input-group shadow-sm">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" name="q" class="form-control border-start-0 ps-0" value="<?php echo e($keyword); ?>" placeholder="Ketik nama supplier...">
                    <button class="btn btn-primary px-3" type="submit">Cari</button>
                    <?php if ($keyword !== ''): ?>
                        <a href="list.php" class="btn btn-danger" title="Reset Pencarian"><i class="bi bi-x-lg"></i></a>
                    <?php endif; ?>
                </form>
            </div>
            <div class="col-md-5 col-lg-7 text-md-end">
                <p class="text-muted small mb-0">
                    Menampilkan <strong class="text-dark"><?php echo count($daftarSupplier); ?></strong> dari <strong class="text-dark"><?php echo (int) $totalRows; ?></strong> supplier
                    <?php if ($keyword !== ''): ?> untuk pencarian "<strong class="text-dark"><?php echo e($keyword); ?></strong>"<?php endif; ?>
                </p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle border text-nowrap mb-0">
                <thead class="table-primary text-center">
                    <tr>
                        <th>Kode Supplier</th>
                        <th class="text-start">Nama</th>
                        <th>Alamat</th>
                        <th>No. HP</th>
                        <?php if ($sudahLogin): ?><th>Aksi</th><?php endif; ?>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php if (empty($daftarSupplier)): ?>
                        <tr>
                            <td colspan="<?php echo $sudahLogin ? 5 : 4; ?>" class="text-muted py-5">
                                <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                Tidak ada data supplier yang cocok.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($daftarSupplier as $s): ?>
                            <tr>
                                <td class="fw-medium text-secondary"><?php echo e($s['kode_supplier']); ?></td>
                                <td class="text-start fw-medium text-dark"><?php echo e($s['nama']); ?></td>
                                <td><?php echo e($s['alamat']); ?></td>
                                <td><?php echo e($s['no_hp']); ?></td>
                                <?php if ($sudahLogin): ?>
                                    <td>
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="edit.php?id=<?php echo (int) $s['id']; ?>" class="btn btn-warning btn-sm text-white shadow-sm" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <!-- Form hapus dengan konfirmasi JS -->
                                            <form class="m-0 p-0" method="post" action="hapus.php" onsubmit="return confirm('Apakah Anda yakin ingin menghapus supplier ini?');">
                                                <input type="hidden" name="id" value="<?php echo (int) $s['id']; ?>">
                                                <button type="submit" class="btn btn-danger btn-sm shadow-sm" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Paginasi -->
        <?php if ($totalPages > 1): ?>
            <nav class="mt-4" aria-label="Navigasi halaman">
                <ul class="pagination pagination-sm justify-content-center mb-0 shadow-sm rounded-3">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
                            <a class="page-link" href="list.php?page=<?php echo $i; ?><?php echo $keyword !== '' ? '&q=' . urlencode($keyword) : ''; ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        <?php endif; ?>

    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>