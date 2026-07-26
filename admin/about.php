<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/functions.php';
$pageTitle = 'Kelola Halaman Tentang Kami';

$aboutData = read_json('about.json');
if (!$aboutData) {
    $aboutData = [
        'hero' => ['title' => '', 'subtitle' => ''],
        'story' => ['title' => '', 'paragraphs' => ['', ''], 'image' => ''],
        'vision' => '',
        'mission' => ['', '', '']
    ];
}

$message = '';
$status = '';
if (isset($_GET['success'])) {
    $message = 'Data berhasil disimpan!';
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
        <span class="material-symbols-outlined text-admin-primary">info</span>
        <h1 class="text-xl font-manrope font-bold text-admin-text">Halaman Tentang Kami</h1>
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
        <input type="hidden" name="type" value="about">
        
        <div class="bg-admin-surface border border-admin-border rounded-2xl p-6">
            <h2 class="text-lg font-bold font-manrope text-admin-text mb-4">Hero Section</h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm text-admin-text-muted mb-2">Judul Hero</label>
                    <input type="text" name="hero_title" value="<?php echo htmlspecialchars($aboutData['hero']['title'] ?? ''); ?>" class="w-full bg-admin-surface-light border border-admin-border rounded-xl px-4 py-2.5 text-admin-text focus:outline-none focus:border-admin-primary transition-colors">
                </div>
                <div>
                    <label class="block text-sm text-admin-text-muted mb-2">Subjudul Hero</label>
                    <textarea name="hero_subtitle" rows="2" class="w-full bg-admin-surface-light border border-admin-border rounded-xl px-4 py-2.5 text-admin-text focus:outline-none focus:border-admin-primary transition-colors"><?php echo htmlspecialchars($aboutData['hero']['subtitle'] ?? ''); ?></textarea>
                </div>
            </div>
        </div>

        <div class="bg-admin-surface border border-admin-border rounded-2xl p-6">
            <h2 class="text-lg font-bold font-manrope text-admin-text mb-4">Cerita Kami (Story)</h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm text-admin-text-muted mb-2">Judul Cerita</label>
                    <input type="text" name="story_title" value="<?php echo htmlspecialchars($aboutData['story']['title'] ?? ''); ?>" class="w-full bg-admin-surface-light border border-admin-border rounded-xl px-4 py-2.5 text-admin-text focus:outline-none focus:border-admin-primary transition-colors">
                </div>
                <div>
                    <label class="block text-sm text-admin-text-muted mb-2">Paragraf 1</label>
                    <textarea name="story_p1" rows="3" class="w-full bg-admin-surface-light border border-admin-border rounded-xl px-4 py-2.5 text-admin-text focus:outline-none focus:border-admin-primary transition-colors"><?php echo htmlspecialchars($aboutData['story']['paragraphs'][0] ?? ''); ?></textarea>
                </div>
                <div>
                    <label class="block text-sm text-admin-text-muted mb-2">Paragraf 2</label>
                    <textarea name="story_p2" rows="3" class="w-full bg-admin-surface-light border border-admin-border rounded-xl px-4 py-2.5 text-admin-text focus:outline-none focus:border-admin-primary transition-colors"><?php echo htmlspecialchars($aboutData['story']['paragraphs'][1] ?? ''); ?></textarea>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-admin-text-muted mb-2">Upload File Gambar Cerita</label>
                        <input type="file" name="story_image_file" accept="image/*" class="w-full bg-admin-surface-light border border-admin-border rounded-xl px-4 py-2 text-sm text-admin-text">
                    </div>
                    <div>
                        <label class="block text-sm text-admin-text-muted mb-2">Atau URL / Path Gambar</label>
                        <div class="flex gap-3 items-center">
                            <input type="text" name="story_image" value="<?php echo htmlspecialchars($aboutData['story']['image'] ?? ''); ?>" class="w-full bg-admin-surface-light border border-admin-border rounded-xl px-4 py-2.5 text-admin-text focus:outline-none focus:border-admin-primary transition-colors">
                            <?php if (!empty($aboutData['story']['image'])): ?>
                            <img src="<?= htmlspecialchars(get_image_url($aboutData['story']['image'])) ?>" alt="preview" class="w-10 h-10 object-cover rounded-lg border border-admin-border shrink-0">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-admin-surface border border-admin-border rounded-2xl p-6">
            <h2 class="text-lg font-bold font-manrope text-admin-text mb-4">Visi & Misi</h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm text-admin-text-muted mb-2">Visi</label>
                    <textarea name="vision" rows="3" class="w-full bg-admin-surface-light border border-admin-border rounded-xl px-4 py-2.5 text-admin-text focus:outline-none focus:border-admin-primary transition-colors"><?php echo htmlspecialchars($aboutData['vision'] ?? ''); ?></textarea>
                </div>
                <div>
                    <label class="block text-sm text-admin-text-muted mb-2">Misi 1</label>
                    <input type="text" name="mission1" value="<?php echo htmlspecialchars($aboutData['mission'][0] ?? ''); ?>" class="w-full bg-admin-surface-light border border-admin-border rounded-xl px-4 py-2.5 text-admin-text focus:outline-none focus:border-admin-primary transition-colors">
                </div>
                <div>
                    <label class="block text-sm text-admin-text-muted mb-2">Misi 2</label>
                    <input type="text" name="mission2" value="<?php echo htmlspecialchars($aboutData['mission'][1] ?? ''); ?>" class="w-full bg-admin-surface-light border border-admin-border rounded-xl px-4 py-2.5 text-admin-text focus:outline-none focus:border-admin-primary transition-colors">
                </div>
                <div>
                    <label class="block text-sm text-admin-text-muted mb-2">Misi 3</label>
                    <input type="text" name="mission3" value="<?php echo htmlspecialchars($aboutData['mission'][2] ?? ''); ?>" class="w-full bg-admin-surface-light border border-admin-border rounded-xl px-4 py-2.5 text-admin-text focus:outline-none focus:border-admin-primary transition-colors">
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-admin-primary hover:bg-admin-primary-light text-white px-6 py-2.5 rounded-xl font-medium transition-colors flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">save</span>
                Simpan Perubahan
            </button>
        </div>
    </form>
  </div>
</main>
</body></html>
