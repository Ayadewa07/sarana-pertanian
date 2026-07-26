<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/functions.php';
$pageTitle = 'Kelola Hero Banner';

$heroData = read_json('hero.json');
if (!$heroData) {
    $heroData = [
        'index' => ['title' => '', 'subtitle' => '', 'image' => '', 'cta_text' => '', 'cta_link' => ''],
        'about' => ['title' => '', 'subtitle' => '', 'image' => ''],
        'contact' => ['title' => '', 'subtitle' => '', 'image' => '']
    ];
}

$message = '';
$status = '';
if (isset($_GET['success'])) {
    $message = 'Hero banner berhasil disimpan!';
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
        <span class="material-symbols-outlined text-admin-primary">view_carousel</span>
        <h1 class="text-xl font-manrope font-bold text-admin-text">Hero Banner</h1>
    </div>
  </header>
  <div class="p-6">
    <?php if ($message): ?>
    <div class="mb-6 p-4 rounded-xl flex items-center gap-3 <?php echo $status === 'success' ? 'bg-admin-success/10 border border-admin-success/20 text-admin-success' : 'bg-admin-danger/10 border border-admin-danger/20 text-admin-danger'; ?>">
        <span class="material-symbols-outlined"><?php echo $status === 'success' ? 'check_circle' : 'error'; ?></span>
        <p><?php echo htmlspecialchars($message); ?></p>
    </div>
    <?php endif; ?>

    <form action="api/save.php" method="POST" enctype="multipart/form-data" class="space-y-6">
        <input type="hidden" name="type" value="hero">
        
        <div class="bg-admin-surface border border-admin-border rounded-2xl overflow-hidden">
            <div class="bg-admin-surface-light border-b border-admin-border p-4">
                <h2 class="text-lg font-bold font-manrope text-admin-text">Beranda (Home)</h2>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm text-admin-text-muted mb-2">Judul</label>
                    <input type="text" name="index_title" value="<?php echo htmlspecialchars($heroData['index']['title'] ?? ''); ?>" class="w-full bg-admin-surface-light border border-admin-border rounded-xl px-4 py-2.5 text-admin-text focus:outline-none focus:border-admin-primary transition-colors">
                </div>
                <div>
                    <label class="block text-sm text-admin-text-muted mb-2">Subjudul</label>
                    <textarea name="index_subtitle" rows="2" class="w-full bg-admin-surface-light border border-admin-border rounded-xl px-4 py-2.5 text-admin-text focus:outline-none focus:border-admin-primary transition-colors"><?php echo htmlspecialchars($heroData['index']['subtitle'] ?? ''); ?></textarea>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-admin-text-muted mb-2">Upload File Gambar Latar</label>
                        <input type="file" name="index_image_file" accept="image/*" class="w-full bg-admin-surface-light border border-admin-border rounded-xl px-4 py-2 text-sm text-admin-text">
                    </div>
                    <div>
                        <label class="block text-sm text-admin-text-muted mb-2">Atau URL / Path Gambar</label>
                        <div class="flex gap-3 items-center">
                            <input type="text" name="index_image" value="<?php echo htmlspecialchars($heroData['index']['image'] ?? ''); ?>" class="w-full bg-admin-surface-light border border-admin-border rounded-xl px-4 py-2.5 text-admin-text focus:outline-none focus:border-admin-primary transition-colors">
                            <?php if (!empty($heroData['index']['image'])): ?>
                            <img src="<?= htmlspecialchars(get_image_url($heroData['index']['image'])) ?>" alt="preview" class="w-10 h-10 object-cover rounded-lg border border-admin-border shrink-0">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm text-admin-text-muted mb-2">Teks Tombol CTA</label>
                        <input type="text" name="index_cta_text" value="<?php echo htmlspecialchars($heroData['index']['cta_text'] ?? ''); ?>" class="w-full bg-admin-surface-light border border-admin-border rounded-xl px-4 py-2.5 text-admin-text focus:outline-none focus:border-admin-primary transition-colors">
                    </div>
                    <div>
                        <label class="block text-sm text-admin-text-muted mb-2">Link Tombol CTA</label>
                        <input type="text" name="index_cta_link" value="<?php echo htmlspecialchars($heroData['index']['cta_link'] ?? ''); ?>" class="w-full bg-admin-surface-light border border-admin-border rounded-xl px-4 py-2.5 text-admin-text focus:outline-none focus:border-admin-primary transition-colors">
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-admin-surface border border-admin-border rounded-2xl overflow-hidden">
            <div class="bg-admin-surface-light border-b border-admin-border p-4">
                <h2 class="text-lg font-bold font-manrope text-admin-text">Tentang Kami (About)</h2>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm text-admin-text-muted mb-2">Judul</label>
                    <input type="text" name="about_title" value="<?php echo htmlspecialchars($heroData['about']['title'] ?? ''); ?>" class="w-full bg-admin-surface-light border border-admin-border rounded-xl px-4 py-2.5 text-admin-text focus:outline-none focus:border-admin-primary transition-colors">
                </div>
                <div>
                    <label class="block text-sm text-admin-text-muted mb-2">Subjudul</label>
                    <textarea name="about_subtitle" rows="2" class="w-full bg-admin-surface-light border border-admin-border rounded-xl px-4 py-2.5 text-admin-text focus:outline-none focus:border-admin-primary transition-colors"><?php echo htmlspecialchars($heroData['about']['subtitle'] ?? ''); ?></textarea>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-admin-text-muted mb-2">Upload File Gambar Latar</label>
                        <input type="file" name="about_image_file" accept="image/*" class="w-full bg-admin-surface-light border border-admin-border rounded-xl px-4 py-2 text-sm text-admin-text">
                    </div>
                    <div>
                        <label class="block text-sm text-admin-text-muted mb-2">Atau URL / Path Gambar</label>
                        <div class="flex gap-3 items-center">
                            <input type="text" name="about_image" value="<?php echo htmlspecialchars($heroData['about']['image'] ?? ''); ?>" class="w-full bg-admin-surface-light border border-admin-border rounded-xl px-4 py-2.5 text-admin-text focus:outline-none focus:border-admin-primary transition-colors">
                            <?php if (!empty($heroData['about']['image'])): ?>
                            <img src="<?= htmlspecialchars(get_image_url($heroData['about']['image'])) ?>" alt="preview" class="w-10 h-10 object-cover rounded-lg border border-admin-border shrink-0">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-admin-surface border border-admin-border rounded-2xl overflow-hidden">
            <div class="bg-admin-surface-light border-b border-admin-border p-4">
                <h2 class="text-lg font-bold font-manrope text-admin-text">Kontak (Contact)</h2>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm text-admin-text-muted mb-2">Judul</label>
                    <input type="text" name="contact_title" value="<?php echo htmlspecialchars($heroData['contact']['title'] ?? ''); ?>" class="w-full bg-admin-surface-light border border-admin-border rounded-xl px-4 py-2.5 text-admin-text focus:outline-none focus:border-admin-primary transition-colors">
                </div>
                <div>
                    <label class="block text-sm text-admin-text-muted mb-2">Subjudul</label>
                    <textarea name="contact_subtitle" rows="2" class="w-full bg-admin-surface-light border border-admin-border rounded-xl px-4 py-2.5 text-admin-text focus:outline-none focus:border-admin-primary transition-colors"><?php echo htmlspecialchars($heroData['contact']['subtitle'] ?? ''); ?></textarea>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-admin-text-muted mb-2">Upload File Gambar Latar</label>
                        <input type="file" name="contact_image_file" accept="image/*" class="w-full bg-admin-surface-light border border-admin-border rounded-xl px-4 py-2 text-sm text-admin-text">
                    </div>
                    <div>
                        <label class="block text-sm text-admin-text-muted mb-2">Atau URL / Path Gambar</label>
                        <div class="flex gap-3 items-center">
                            <input type="text" name="contact_image" value="<?php echo htmlspecialchars($heroData['contact']['image'] ?? ''); ?>" class="w-full bg-admin-surface-light border border-admin-border rounded-xl px-4 py-2.5 text-admin-text focus:outline-none focus:border-admin-primary transition-colors">
                            <?php if (!empty($heroData['contact']['image'])): ?>
                            <img src="<?= htmlspecialchars(get_image_url($heroData['contact']['image'])) ?>" alt="preview" class="w-10 h-10 object-cover rounded-lg border border-admin-border shrink-0">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-admin-primary hover:bg-admin-primary-light text-white px-6 py-2.5 rounded-xl font-medium transition-colors flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">save</span>
                Simpan Hero Banner
            </button>
        </div>
    </form>
  </div>
</main>
</body></html>
