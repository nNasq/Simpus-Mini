<?php
// 1. Paste "Connection string" dari Neon tepat di antara tanda kutip di bawah ini
$neon_link = "postgresql://neondb_owner:npg_SM4Ci6RbaqPo@ep-cool-bread-b4akwc0d-pooler.c-6.us-east-2.aws.neon.tech/neondb?sslmode=require&channel_binding=require";

// 2. Fungsi parse_url() otomatis memecah link di atas menjadi bagian-bagian yang dibutuhkan PDO
$db_url = parse_url($neon_link);

$host = $db_url['host'];
$port = $db_url['port'] ?? 5432;
$user = $db_url['user'];
$pass = $db_url['pass'];
$db   = ltrim($db_url['path'], '/'); // Menghilangkan garis miring di depan nama database

// 3. Menyusun Data Source Name (DSN) untuk PostgreSQL
$dsn = "pgsql:host=$host;port=$port;dbname=$db;sslmode=require";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        // Ubah baris di bawah ini dari false menjadi true
        PDO::ATTR_EMULATE_PREPARES   => true, 
    ]);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
?>