<?php
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['type']) && isset($_POST['id'])) {
    $type = $_POST['type'];
    $id = (int)$_POST['id'];
    $redirect = $_SERVER['HTTP_REFERER'] ?? '../index.php';
    // Remove query params from redirect
    $redirect = explode('?', $redirect)[0];

    $filename = '';
    if ($type === 'products') {
        $filename = 'products.json';
    } elseif ($type === 'articles') {
        $filename = 'articles.json';
    } elseif ($type === 'faq') {
        $filename = 'faq.json';
    } elseif ($type === 'messages') {
        $filename = 'messages.json';
    }

    if ($filename) {
        $items = read_json($filename);
        $newItems = [];
        foreach ($items as $item) {
            if (isset($item['id']) && $item['id'] !== $id) {
                $newItems[] = $item;
            }
        }
        write_json($filename, $newItems);
        header("Location: {$redirect}?deleted=1");
        exit;
    }

    header("Location: {$redirect}");
    exit;
}

header("Location: ../index.php");
exit;
