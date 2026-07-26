<?php
/**
 * Vercel Serverless Function Entrypoint Router
 */
$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$parsedUrl = parse_url($requestUri, PHP_URL_PATH);

// Remove leading slash
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
} elseif (file_exists($targetFile) && !is_dir($targetFile)) {
    $mime = mime_content_type($targetFile);
    header("Content-Type: " . ($mime ?: 'application/octet-stream'));
    readfile($targetFile);
} else {
    chdir($root);
    require $root . '/index.php';
}
