<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/functions.php';
$pageTitle = 'Informasi Kontak';

$contactData = read_json('contact.json');
if (!$contactData) {
    $contactData = [
        'address' => '',
        'whatsapp' => '',
        'whatsapp_display' => '',
        'email' => '',
        'maps_embed' => ''
    ];
}

$message = '';
$status = '';
if (isset($_GET['success'])) {
    $message = 'Informasi kontak berhasil disimpan!';
    $status = 'success';
} elseif (isset($_GET['error'])) {
    $message = urldecode($_GET['error']);
    $status = 'danger';
} elseif (isset($_SESSION['flash_message'])) {
    $message = $_SESSION['flash_message'];
    $status = $_SESSION['flash_status'] ?? 'success';
    unset($_SESSION['flash_message'], $_SESSION['flash_status']);
}

require_once __DIR__ . '/includes/admin_header.php';
require_once __DIR__ . '/includes/sidebar.php';
?>
<main class="lg:ml-64 min-h-screen">
  <header class="sticky top-0 z-30 bg-admin-bg/80 backdrop-blur-xl border-b border-admin-border px-6 py-4 flex items-center justify-between">
    <div class="flex items-center gap-3">
        <span class="material-symbols-outlined text-admin-primary">contact_page</span>
        <h1 class="text-xl font-manrope font-bold text-admin-text">Informasi Kontak</h1>
    </div>
  </header>
  <div class="p-6">
    <?php if ($message): ?>
    <div class="mb-6 p-4 rounded-xl flex items-center gap-3 <?php echo $status === 'success' ? 'bg-admin-success/10 border border-admin-success/20 text-admin-success' : 'bg-admin-danger/10 border border-admin-danger/20 text-admin-danger'; ?>">
        <span class="material-symbols-outlined"><?php echo $status === 'success' ? 'check_circle' : 'error'; ?></span>
        <p><?php echo htmlspecialchars($message); ?></p>
    </div>
    <?php endif; ?>

    <form action="api/save.php" method="POST" class="bg-admin-surface border border-admin-border rounded-2xl p-6 space-y-6">
        <input type="hidden" name="type" value="contact">
        
        <div>
            <label class="block text-sm text-admin-text-muted mb-2">Alamat Lengkap</label>
            <textarea name="address" rows="3" class="w-full bg-admin-surface-light border border-admin-border rounded-xl px-4 py-2.5 text-admin-text focus:outline-none focus:border-admin-primary transition-colors"><?php echo htmlspecialchars($contactData['address'] ?? ''); ?></textarea>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm text-admin-text-muted mb-2">WhatsApp (Nomor untuk Link)</label>
                <input type="text" name="whatsapp" value="<?php echo htmlspecialchars($contactData['whatsapp'] ?? ''); ?>" placeholder="Contoh: 6281123456789" class="w-full bg-admin-surface-light border border-admin-border rounded-xl px-4 py-2.5 text-admin-text focus:outline-none focus:border-admin-primary transition-colors">
                <p class="text-xs text-admin-text-muted mt-1">Gunakan kode negara (62) tanpa spasi atau +.</p>
            </div>
            <div>
                <label class="block text-sm text-admin-text-muted mb-2">WhatsApp (Tampilan Teks)</label>
                <input type="text" name="whatsapp_display" value="<?php echo htmlspecialchars($contactData['whatsapp_display'] ?? ''); ?>" placeholder="Contoh: +62 811-2345-6789" class="w-full bg-admin-surface-light border border-admin-border rounded-xl px-4 py-2.5 text-admin-text focus:outline-none focus:border-admin-primary transition-colors">
            </div>
        </div>

        <div>
            <label class="block text-sm text-admin-text-muted mb-2">Email</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($contactData['email'] ?? ''); ?>" class="w-full bg-admin-surface-light border border-admin-border rounded-xl px-4 py-2.5 text-admin-text focus:outline-none focus:border-admin-primary transition-colors">
        </div>

        <div>
            <label class="block text-sm text-admin-text-muted mb-2">Embed Google Maps (URL/Iframe src)</label>
            <textarea name="maps_embed" rows="3" class="w-full bg-admin-surface-light border border-admin-border rounded-xl px-4 py-2.5 text-admin-text focus:outline-none focus:border-admin-primary transition-colors"><?php echo htmlspecialchars($contactData['maps_embed'] ?? ''); ?></textarea>
        </div>

        <div class="flex justify-end pt-4 border-t border-admin-border">
            <button type="submit" class="bg-admin-primary hover:bg-admin-primary-light text-white px-6 py-2.5 rounded-xl font-medium transition-colors flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">save</span>
                Simpan Kontak
            </button>
        </div>
    </form>
  </div>
</main>
</body></html>
