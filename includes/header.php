<?php
session_start();
$__jobsheetRoot = dirname(__DIR__);
$__scriptDir = dirname($_SERVER['SCRIPT_FILENAME']);
$__rel = ltrim(str_replace('\\', '/', substr($__scriptDir, strlen($__jobsheetRoot))), '/');
$base = $__rel === '' ? '' : str_repeat('../', substr_count($__rel, '/') + 1);

if (!function_exists('e')) {
    function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
}

// Menentukan menu aktif (sesuai template HTML Anda, link tidak menggunakan ikon)
$__current = ($__rel === '' ? '' : $__rel . '/') . basename($_SERVER['SCRIPT_FILENAME']);
$__menu = [
    'index.php'          => 'Beranda',
    'barang/list.php'    => 'Daftar Barang',
    'barang/tambah.php'  => 'Tambah Barang',
    'supplier/list.php'  => 'Daftar Supplier',
    'supplier/tambah.php'=> 'Tambah Supplier',
];
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SIGUDANG-Mini<?php echo isset($page_title) ? ' | ' . e($page_title) : ''; ?></title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="<?php echo $base; ?>assets/css/style.css">

  <style>
    /* CSS tambahan memastikan ikon bulat jika tidak ada di style.css Anda */
    .summary-icon {
        width: 64px;
        height: 64px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }
  </style>
</head>

<body class="bg-light d-flex flex-column min-vh-100">
  <header class="navbar navbar-expand-lg bg-primary sticky-top shadow-sm" data-bs-theme="dark">
    <div class="container">
      <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="<?php echo $base; ?>index.php">
        <i class="bi bi-boxes fs-4"></i> SIGUDANG-Mini
      </a>
      <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav ms-auto fw-medium">
        <?php foreach ($__menu as $path => $label): ?>
          <li class="nav-item">
            <a class="nav-link <?php echo $__current === $path ? 'active' : ''; ?>" href="<?php echo $base . $path; ?>">
              <?php echo $label; ?>
            </a>
          </li>
        <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </header>

  <main class="container py-5 flex-grow-1">