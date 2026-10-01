<?php
// Data detail koneksi dari Supabase Nanas
$host = 'db.jhhwmzaivtymiwaqtpsq.supabase.co'; // Diambil dari teks setelah tanda '@'
$port = '5432';                                // Port default Supabase
$db   = 'postgres';                            // Nama database default
$user = 'postgres';                            // Diambil dari teks setelah '://'
$pass = '12345678';  // Ganti bagian ini dengan password Anda!

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$db";
    $pdo = new PDO($dsn, $user, $pass);
    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi Database Gagal: " . $e->getMessage());
}
?>