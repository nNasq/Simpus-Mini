<?php

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


if ($path === '/' || $path === '') {
    $path = '/index.php';
}

$file = __DIR__ . $path;

if (file_exists($file) && is_file($file)) {
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

    if ($ext === 'php') {

        $_SERVER['SCRIPT_FILENAME'] = $file;
        $_SERVER['SCRIPT_NAME'] = $path;
        $_SERVER['PHP_SELF'] = $path;
        chdir(dirname($file));

        require $file;
        exit;
    } else {

        $mimeTypes = [
            'css' => 'text/css',
            'js'  => 'application/javascript',
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'svg' => 'image/svg+xml'
        ];
        if (isset($mimeTypes[$ext])) {
            header("Content-Type: " . $mimeTypes[$ext]);
        }
        readfile($file);
        exit;
    }
}


http_response_code(404);
echo "404 - Halaman Tidak Ditemukan";
