<?php
$page_title = "Beranda";
include __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/koneksi.php';

// Eksekusi data dinamis
$totalBarang   = $pdo->query("SELECT COUNT(*) FROM barang")->fetchColumn();
$totalSupplier = $pdo->query("SELECT COUNT(*) FROM supplier")->fetchColumn();
$stokMenipis   = $pdo->query("SELECT COUNT(*) FROM barang WHERE stok > 0 AND stok <= 5")->fetchColumn();
$stokHabis     = $pdo->query("SELECT COUNT(*) FROM barang WHERE stok = 0")->fetchColumn();
?>

<!-- Section 1: Hero Banner -->
<section class="p-5 mb-5 bg-white rounded-4 shadow-sm border-0 text-center text-md-start hero-section">
  <div class="row align-items-center">
    <div class="col-lg-8">
      <h1 class="display-6 fw-bold text-primary mb-3">Selamat Datang di <br>Sistem Inventaris Gudang</h1>
      <p class="lead text-secondary mb-0">
        Aplikasi sederhana, cepat, dan responsif untuk mengelola data barang serta supplier gudang Anda.
      </p>
    </div>
    <div class="col-lg-4 d-none d-lg-block text-end">
      <i class="bi bi-box-seam text-primary" style="font-size: 8rem; opacity: 0.8;"></i>
    </div>
  </div>
</section>

<!-- Section 2: Ringkasan Data -->
<section>
  <h3 class="fw-bold mb-4 text-dark"><i class="bi bi-bar-chart-fill text-primary me-2"></i> Ringkasan Data</h3>

  <div class="row g-4 text-center">
    <!-- Total Barang -->
    <div class="col-6 col-md-3">
      <div class="card summary-card h-100 border-0 rounded-4 shadow-sm p-4">
        <div class="summary-icon text-primary bg-primary bg-opacity-10 mb-3 mx-auto">
          <i class="bi bi-box-seam-fill fs-2"></i>
        </div>
        <h4 class="h6 text-secondary fw-semibold">Total Barang</h4>
        <p class="fs-1 fw-bold text-dark mb-0"><?php echo e($totalBarang); ?></p>
      </div>
    </div>

    <!-- Total Supplier -->
    <div class="col-6 col-md-3">
      <div class="card summary-card h-100 border-0 rounded-4 shadow-sm p-4">
        <div class="summary-icon text-success bg-success bg-opacity-10 mb-3 mx-auto">
          <i class="bi bi-truck fs-2"></i>
        </div>
        <h4 class="h6 text-secondary fw-semibold">Total Supplier</h4>
        <p class="fs-1 fw-bold text-dark mb-0"><?php echo e($totalSupplier); ?></p>
      </div>
    </div>

    <!-- Stok Menipis -->
    <div class="col-6 col-md-3">
      <div class="card summary-card h-100 border-0 rounded-4 shadow-sm p-4">
        <div class="summary-icon text-warning bg-warning bg-opacity-10 mb-3 mx-auto">
          <i class="bi bi-graph-down-arrow fs-2"></i>
        </div>
        <h4 class="h6 text-secondary fw-semibold">Stok Menipis</h4>
        <p class="fs-1 fw-bold text-dark mb-0"><?php echo e($stokMenipis); ?></p>
      </div>
    </div>

    <!-- Stok Habis -->
    <div class="col-6 col-md-3">
      <div class="card summary-card h-100 border-0 rounded-4 shadow-sm p-4">
        <div class="summary-icon text-danger bg-danger bg-opacity-10 mb-3 mx-auto">
          <i class="bi bi-exclamation-triangle-fill fs-2"></i>
        </div>
        <h4 class="h6 text-secondary fw-semibold">Stok Habis</h4>
        <p class="fs-1 fw-bold text-dark mb-0"><?php echo e($stokHabis); ?></p>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>