<?php

require_once __DIR__ . '/koneksi.php';


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['user_id'])) {
    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Anda harus login terlebih dahulu.'];


    $__jobsheetRoot = dirname(__DIR__);
    $__scriptDir = dirname($_SERVER['SCRIPT_FILENAME']);
    $__rel = ltrim(str_replace('\\', '/', substr($__scriptDir, strlen($__jobsheetRoot))), '/');
    $base = $__rel === '' ? '' : str_repeat('../', substr_count($__rel, '/') + 1);

    header("Location: {$base}auth/login.php");
    exit;
}
