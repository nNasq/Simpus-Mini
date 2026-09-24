<?php
$page_title = "Tambah Barang";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <h2 class="fw-bold mb-0 text-dark">
        <i class="bi bi-box-seam text-primary me-2"></i> Tambah Barang Baru
    </h2>
    <a href="list.php" class="btn btn-outline-secondary shadow-sm px-4 bg-white">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
    </a>
</div>

<?php if ($flash): ?>
<div class="alert alert-<?php echo $flash['type'] === 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show shadow-sm border-0 d-flex align-items-center" role="alert">
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

        <form id="form-tambah" method="post" action="proses_tambah.php" novalidate>
            <div class="row g-4">
                
                <div class="col-md-6">
                    <label for="nama" class="form-label fw-semibold text-secondary">Nama Barang</label>
                    <input type="text" class="form-control" name="nama" id="nama" placeholder="Masukkan nama barang..." required />
                </div>

                <div class="col-md-6">
                    <label for="sku" class="form-label fw-semibold text-secondary">SKU / Kode Barang</label>
                    <input type="text" class="form-control" name="sku" id="sku" placeholder="Contoh: BRG-001" required />
                </div>

                <div class="col-md-4">
                    <label for="kategori" class="form-label fw-semibold text-secondary">Kategori</label>
                    <select class="form-select" id="kategori" name="kategori" required>
                        <option value="" disabled selected>Pilih kategori...</option>
                        <option value="elektronik">Elektronik</option>
                        <option value="perkakas">Perkakas</option>
                        <option value="atk">ATK</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="harga" class="form-label fw-semibold text-secondary">Harga (Rp)</label>
                    <input type="number" class="form-control" name="harga" id="harga" min="0" placeholder="0" required />
                </div>

                <div class="col-md-4">
                    <label for="stok" class="form-label fw-semibold text-secondary">Jumlah Stok</label>
                    <input type="number" class="form-control" name="stok" id="stok" min="0" placeholder="0" required />
                </div>

            </div>

            <hr class="my-4 text-muted">

            <div class="d-flex justify-content-end gap-2">
                <button type="reset" class="btn btn-light px-4 border">Reset</button>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-floppy me-1"></i> Simpan Data
                </button>
            </div>
        </form>

    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>