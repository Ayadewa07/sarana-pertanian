<?php
/**
 * Vercel Serverless Function Entrypoint Router
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$parsedUrl = parse_url($requestUri, PHP_URL_PATH);

$path = ltrim($parsedUrl, '/');
if (empty($path)) {
    $path = 'index.php';
}

$root = dirname(__DIR__);
$targetFile = $root . '/' . $path;

if (is_dir($targetFile)) {
    $targetFile = rtrim($targetFile, '/') . '/index.php';
}

if (file_exists($targetFile) && str_ends_with($targetFile, '.php')) {
    chdir(dirname($targetFile));
    require $targetFile;
    exit;
} elseif (file_exists($targetFile) && !is_dir($targetFile)) {
    $ext = pathinfo($targetFile, PATHINFO_EXTENSION);
    $mimes = [
        'css' => 'text/css',
        'js' => 'application/javascript',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'webp' => 'image/webp',
        'svg' => 'image/svg+xml',
        'json' => 'application/json'
    ];
    header("Content-Type: " . ($mimes[$ext] ?? 'application/octet-stream'));
    readfile($targetFile);
    exit;
} else {
    chdir($root);
    require $root . '/index.php';
    exit;
}
