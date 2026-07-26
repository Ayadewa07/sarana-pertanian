<?php
/**
 * Admin Dashboard Helper Functions
 * Sarana Pertanian - Admin Panel
 */

define('DATA_DIR', __DIR__ . '/../data/');

/**
 * Read JSON data file
 */
function read_json($filename) {
    $path = DATA_DIR . $filename;
    if (!file_exists($path)) {
        return ($filename === 'messages.json') ? [] : [];
    }
    $content = file_get_contents($path);
    $data = json_decode($content, true);
    return $data !== null ? $data : [];
}

/**
 * Write data to JSON file
 */
function write_json($filename, $data) {
    $path = DATA_DIR . $filename;
    if (!is_dir(DATA_DIR)) {
        mkdir(DATA_DIR, 0755, true);
    }
    return file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
}

/**
 * Get next ID for an array of items
 */
function get_next_id($items) {
    if (empty($items)) return 1;
    $maxId = 0;
    foreach ($items as $item) {
        if (isset($item['id']) && $item['id'] > $maxId) {
            $maxId = $item['id'];
        }
    }
    return $maxId + 1;
}

/**
 * Format Rupiah
 */
function format_rupiah_admin($number) {
    return 'Rp ' . number_format($number, 0, ',', '.');
}

/**
 * Get settings
 */
function get_settings() {
    $settings = read_json('settings.json');
    if (empty($settings)) {
        $settings = [
            'site_name' => 'Sarana Pertanian',
            'site_tagline' => 'Yield Certainty through Precision Stewardship',
            'footer_tagline' => 'Precision Stewardship through Scientific Rigor.',
            'copyright' => '© 2024 Sarana Pertanian. All rights reserved.',
            'whatsapp_number' => '6281123456789',
            'admin_username' => 'admin',
            'admin_password_hash' => password_hash('admin123', PASSWORD_DEFAULT)
        ];
        write_json('settings.json', $settings);
    }
    return $settings;
}

/**
 * Sanitize input
 */
function sanitize($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

/**
 * Get count of items in a JSON file
 */
function get_count($filename) {
    $data = read_json($filename);
    return is_array($data) ? count($data) : 0;
}

/**
 * Get unread message count
 */
function get_unread_count() {
    $messages = read_json('messages.json');
    $count = 0;
    foreach ($messages as $msg) {
        if (empty($msg['read'])) $count++;
    }
    return $count;
}

/**
 * Time ago helper
 */
function time_ago($datetime) {
    $now = new DateTime();
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);
    
    if ($diff->y > 0) return $diff->y . ' tahun lalu';
    if ($diff->m > 0) return $diff->m . ' bulan lalu';
    if ($diff->d > 0) return $diff->d . ' hari lalu';
    if ($diff->h > 0) return $diff->h . ' jam lalu';
    if ($diff->i > 0) return $diff->i . ' menit lalu';
    return 'Baru saja';
}

/**
 * Handle image file upload
 */
function handle_image_upload($fileInputKey, $fallbackUrl = '') {
    if (isset($_FILES[$fileInputKey]) && $_FILES[$fileInputKey]['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES[$fileInputKey]['tmp_name'];
        $originalName = $_FILES[$fileInputKey]['name'];
        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];
        if (in_array($ext, $allowedExts)) {
            $uploadDir = __DIR__ . '/../../gambar/uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $filename = 'img_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
            $destination = $uploadDir . $filename;
            
            if (move_uploaded_file($tmpName, $destination)) {
                return 'gambar/uploads/' . $filename;
            }
        }
    }
    
    return $fallbackUrl;
}

/**
 * Format image URL for display inside admin panel
 */
function get_image_url($path) {
    if (empty($path)) return '';
    if (strpos($path, 'http://') === 0 || strpos($path, 'https://') === 0) {
        return $path;
    }
    return '../' . ltrim($path, '/');
}
?>
