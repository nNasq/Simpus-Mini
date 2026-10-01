<?php

require_once __DIR__ . '/../includes/koneksi.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') {
    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Username dan Password wajib diisi.'];
    header('Location: login.php');
    exit;
}


$stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
$stmt->execute(['username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {

    $_SESSION['user_id']  = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['nama']     = $user['nama'];
    $_SESSION['role']     = $user['role'] ?? 'user';

    header('Location: ../index.php');
    exit;
} else {
    $_SESSION['flash'] = ['type' => 'danger', 'pesan' => 'Username atau Password salah.'];
    header('Location: login.php');
    exit;
}
