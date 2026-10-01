<?php
// Mengambil path dari URL yang diketik pengguna
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Jika pengguna hanya mengakses domain utama, arahkan ke Beranda
if ($path === '/' || $path === '') {
    $path = '/index.php';
}

$file = __DIR__ . $path;

if (file_exists($file) && is_file($file)) {
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    
    if ($ext === 'php') {
        // Trik memanipulasi variabel server agar desain $base di header.php Nanas tetap berfungsi
        $_SERVER['SCRIPT_FILENAME'] = $file;
        $_SERVER['SCRIPT_NAME'] = $path;
        $_SERVER['PHP_SELF'] = $path;
        chdir(dirname($file));
        
        require $file;
        exit;
    } else {
        // Penanganan file statis (CSS/JS) agar desain tidak hancur
        $mimeTypes = [
            'css' => 'text/css',
            'js'  => 'application/javascript',
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg'=> 'image/jpeg',
            'svg' => 'image/svg+xml'
        ];
        if (isset($mimeTypes[$ext])) {
            header("Content-Type: " . $mimeTypes[$ext]);
        }
        readfile($file);
        exit;
    }
}

// Jika halaman benar-benar tidak ada
http_response_code(404);
echo "404 - Halaman Tidak Ditemukan";