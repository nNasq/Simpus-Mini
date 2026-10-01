<?php
// Memastikan hanya user yang sudah login yang bisa mengakses halaman ini
require __DIR__ . '/../includes/auth.php';

$page_title = "Edit Barang";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM barang WHERE id = :id");
$stmt->execute(['id' => $id]);
$barang = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$barang) {
    header('Location: list.php');
    exit;
}
?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <h2 class="fw-bold mb-0 text-dark">
        <i class="bi bi-pencil-square text-primary me-2"></i> Edit Barang
    </h2>
    <a href="list.php" class="btn btn-outline-secondary shadow-sm px-4 bg-white">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
    </a>
</div>

<?php if ($flash): ?>
<div class="alert alert-<?php echo $flash['type'] === 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show shadow-sm border-0 d-flex align-items-center rounded-3" role="alert">
    <i class="bi <?php echo $flash['type'] === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill'; ?> fs-4 me-3"></i>
    <div>
        <strong><?php echo $flash['type'] === 'success' ? 'Berhasil!' : 'Gagal!'; ?></strong> <?php echo e($flash['pesan']); ?>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4 p-md-5">

        <h5 class="card-title text-primary fw-bold mb-4">Informasi Barang</h5>

        <form id="form-edit" method="post" action="proses_edit.php" novalidate>
            <!-- Input Hidden untuk ID Barang -->
            <input type="hidden" name="id" value="<?php echo (int) $barang['id']; ?>">

            <div class="row g-4">
                
                <div class="col-md-6">
                    <label for="nama" class="form-label fw-semibold text-secondary">Nama Barang</label>
                    <input type="text" class="form-control" name="nama" id="nama" value="<?php echo e($barang['nama']); ?>" required />
                </div>

                <div class="col-md-6">
                    <label for="sku" class="form-label fw-semibold text-secondary">SKU / Kode Barang</label>
                    <input type="text" class="form-control" name="sku" id="sku" value="<?php echo e($barang['sku']); ?>" placeholder="Contoh: ELK-001" required />
                </div>

                <div class="col-md-4">
                    <label for="kategori" class="form-label fw-semibold text-secondary">Kategori</label>
                    <select class="form-select" id="kategori" name="kategori" required>
                        <?php foreach (['elektronik' => 'Elektronik', 'perkakas' => 'Perkakas', 'atk' => 'ATK', 'lainnya' => 'Lainnya'] as $value => $label): ?>
                            <option value="<?php echo $value; ?>" <?php echo $barang['kategori'] === $value ? 'selected' : ''; ?>>
                                <?php echo $label; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="harga" class="form-label fw-semibold text-secondary">Harga (Rp)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">Rp</span>
                        <input type="number" class="form-control" name="harga" id="harga" min="0" value="<?php echo e($barang['harga']); ?>" required />
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="stok" class="form-label fw-semibold text-secondary">Jumlah Stok</label>
                    <input type="number" class="form-control" name="stok" id="stok" min="0" value="<?php echo e($barang['stok']); ?>" required />
                </div>

            </div>

            <hr class="my-4 text-muted opacity-25">

            <div class="d-flex justify-content-end gap-2">
                <a href="list.php" class="btn btn-light px-4 border shadow-sm">Batal</a>
                <button type="submit" class="btn btn-primary px-4 shadow-sm">
                    <i class="bi bi-save me-1"></i> Simpan Perubahan
                </button>
            </div>
        </form>

    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>