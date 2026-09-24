<?php
$page_title = "Tambah Supplier";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <h2 class="fw-bold mb-0 text-dark">
        <i class="bi bi-person-plus text-primary me-2"></i> Tambah Supplier Baru
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

        <h5 class="card-title text-primary fw-bold mb-4">Informasi Supplier</h5>

        <form id="form-tambah" method="post" action="proses_tambah.php" novalidate>
            <div class="row g-4">
                
                <div class="col-md-6">
                    <label for="nama" class="form-label fw-semibold text-secondary">Nama Supplier</label>
                    <input type="text" class="form-control" name="nama" id="nama" placeholder="Masukkan nama supplier..." required />
                </div>

                <div class="col-md-6">
                    <label for="kode_supplier" class="form-label fw-semibold text-secondary">Kode Supplier</label>
                    <input type="text" class="form-control" name="kode_supplier" id="kode_supplier" placeholder="Contoh: SUP-001" required />
                </div>

                <div class="col-md-6">
                    <label for="no_hp" class="form-label fw-semibold text-secondary">No. HP / Telepon</label>
                    <input type="text" class="form-control" name="no_hp" id="no_hp" placeholder="Contoh: 08123456789" />
                </div>

                <div class="col-md-6">
                    <label for="alamat" class="form-label fw-semibold text-secondary">Alamat Lengkap</label>
                    <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Masukkan alamat lengkap supplier..." />
                </div>

            </div>

            <hr class="my-4 text-muted">

            <div class="d-flex justify-content-end gap-2">
                <a href="list.php" class="btn btn-light px-4 border">Batal</a>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-floppy me-1"></i> Simpan Data
                </button>
            </div>
        </form>

    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>