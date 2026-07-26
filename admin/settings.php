<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/functions.php';
$pageTitle = 'Pengaturan Situs';

$settingsData = get_settings();

$message = '';
$status = '';
if (isset($_GET['success'])) {
    $message = 'Pengaturan berhasil disimpan!';
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
        <span class="material-symbols-outlined text-admin-primary">settings</span>
        <h1 class="text-xl font-manrope font-bold text-admin-text">Pengaturan Sistem</h1>
    </div>
  </header>
  <div class="p-6">
    <?php if ($message): ?>
    <div class="mb-6 p-4 rounded-xl flex items-center gap-3 <?php echo $status === 'success' ? 'bg-admin-success/10 border border-admin-success/20 text-admin-success' : 'bg-admin-danger/10 border border-admin-danger/20 text-admin-danger'; ?>">
        <span class="material-symbols-outlined"><?php echo $status === 'success' ? 'check_circle' : 'error'; ?></span>
        <p><?php echo htmlspecialchars($message); ?></p>
    </div>
    <?php endif; ?>

    <form action="api/save.php" method="POST" class="space-y-6">
        <input type="hidden" name="type" value="settings">
        
        <div class="bg-admin-surface border border-admin-border rounded-2xl p-6">
            <h2 class="text-lg font-bold font-manrope text-admin-text mb-4 border-b border-admin-border pb-2">Pengaturan Situs</h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm text-admin-text-muted mb-2">Nama Situs</label>
                    <input type="text" name="site_name" value="<?php echo htmlspecialchars($settingsData['site_name'] ?? ''); ?>" class="w-full bg-admin-surface-light border border-admin-border rounded-xl px-4 py-2.5 text-admin-text focus:outline-none focus:border-admin-primary transition-colors">
                </div>
                <div>
                    <label class="block text-sm text-admin-text-muted mb-2">Slogan (Tagline)</label>
                    <input type="text" name="site_tagline" value="<?php echo htmlspecialchars($settingsData['site_tagline'] ?? ''); ?>" class="w-full bg-admin-surface-light border border-admin-border rounded-xl px-4 py-2.5 text-admin-text focus:outline-none focus:border-admin-primary transition-colors">
                </div>
                <div>
                    <label class="block text-sm text-admin-text-muted mb-2">Tagline Footer</label>
                    <textarea name="footer_tagline" rows="2" class="w-full bg-admin-surface-light border border-admin-border rounded-xl px-4 py-2.5 text-admin-text focus:outline-none focus:border-admin-primary transition-colors"><?php echo htmlspecialchars($settingsData['footer_tagline'] ?? ''); ?></textarea>
                </div>
                <div>
                    <label class="block text-sm text-admin-text-muted mb-2">Teks Copyright</label>
                    <input type="text" name="copyright" value="<?php echo htmlspecialchars($settingsData['copyright'] ?? ''); ?>" class="w-full bg-admin-surface-light border border-admin-border rounded-xl px-4 py-2.5 text-admin-text focus:outline-none focus:border-admin-primary transition-colors">
                </div>
                <div>
                    <label class="block text-sm text-admin-text-muted mb-2">Nomor WhatsApp Default</label>
                    <input type="text" name="whatsapp_number" value="<?php echo htmlspecialchars($settingsData['whatsapp_number'] ?? ''); ?>" class="w-full bg-admin-surface-light border border-admin-border rounded-xl px-4 py-2.5 text-admin-text focus:outline-none focus:border-admin-primary transition-colors">
                </div>
            </div>
        </div>

        <div class="bg-admin-surface border border-admin-border rounded-2xl p-6">
            <h2 class="text-lg font-bold font-manrope text-admin-text mb-4 border-b border-admin-border pb-2">Ganti Kredensial Login</h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm text-admin-text-muted mb-2">Username Baru</label>
                    <input type="text" name="new_username" placeholder="Kosongkan jika tidak ingin mengubah" value="<?php echo htmlspecialchars($settingsData['admin_username'] ?? ''); ?>" class="w-full bg-admin-surface-light border border-admin-border rounded-xl px-4 py-2.5 text-admin-text focus:outline-none focus:border-admin-primary transition-colors">
                </div>
                <div>
                    <label class="block text-sm text-admin-text-muted mb-2">Password Saat Ini (Wajib diisi jika mengganti password atau username)</label>
                    <input type="password" name="current_password" placeholder="Masukkan password saat ini" class="w-full bg-admin-surface-light border border-admin-border rounded-xl px-4 py-2.5 text-admin-text focus:outline-none focus:border-admin-primary transition-colors">
                </div>
                <div>
                    <label class="block text-sm text-admin-text-muted mb-2">Password Baru</label>
                    <input type="password" name="new_password" placeholder="Kosongkan jika tidak ingin mengubah password" class="w-full bg-admin-surface-light border border-admin-border rounded-xl px-4 py-2.5 text-admin-text focus:outline-none focus:border-admin-primary transition-colors">
                </div>
                <div>
                    <label class="block text-sm text-admin-text-muted mb-2">Konfirmasi Password Baru</label>
                    <input type="password" name="confirm_password" placeholder="Masukkan ulang password baru" class="w-full bg-admin-surface-light border border-admin-border rounded-xl px-4 py-2.5 text-admin-text focus:outline-none focus:border-admin-primary transition-colors">
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-admin-primary hover:bg-admin-primary-light text-white px-6 py-2.5 rounded-xl font-medium transition-colors flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">save</span>
                Simpan Pengaturan
            </button>
        </div>
    </form>
  </div>
</main>
</body></html>
