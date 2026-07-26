<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/functions.php';

$pageTitle = 'Kelola FAQ';

$faqs = read_json('faq.json');
if (!is_array($faqs)) $faqs = [];

$action = $_GET['action'] ?? '';
$editId = $_GET['edit'] ?? null;
$editItem = null;

if ($editId) {
    foreach ($faqs as $f) {
        if ($f['id'] == $editId) {
            $editItem = $f;
            $action = 'edit';
            break;
        }
    }
}

require_once __DIR__ . '/includes/admin_header.php';
require_once __DIR__ . '/includes/sidebar.php';
?>
<main class="lg:ml-64 min-h-screen">
  <header class="sticky top-0 z-30 bg-admin-bg/80 backdrop-blur-xl border-b border-admin-border px-6 py-4 flex items-center justify-between">
    <h1 class="text-2xl font-manrope font-bold text-admin-text"><?= htmlspecialchars($pageTitle) ?></h1>
    <?php if ($action !== 'add' && $action !== 'edit'): ?>
    <a href="?action=add" class="bg-admin-primary hover:bg-admin-primary-light text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
      <span class="material-symbols-outlined text-sm">add</span>
      <span>Tambah FAQ</span>
    </a>
    <?php else: ?>
    <a href="faq.php" class="bg-admin-surface-light border border-admin-border text-admin-text hover:text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
      <span class="material-symbols-outlined text-sm">arrow_back</span>
      <span>Kembali</span>
    </a>
    <?php endif; ?>
  </header>
  <div class="p-6">
    <?php if (isset($_GET['success'])): ?>
    <div class="mb-6 p-4 rounded-lg bg-admin-success/10 border border-admin-success/20 flex items-center gap-3 text-admin-success">
      <span class="material-symbols-outlined">check_circle</span>
      <p><?= htmlspecialchars($_GET['success']) ?></p>
    </div>
    <?php endif; ?>

    <?php if ($action === 'add' || $action === 'edit'): ?>
    <div class="bg-admin-surface rounded-xl border border-admin-border p-6 max-w-3xl">
      <form action="api/save.php" method="POST" class="space-y-6">
        <input type="hidden" name="type" value="faq">
        <input type="hidden" name="action" value="<?= $action ?>">
        <?php if ($editItem): ?>
        <input type="hidden" name="id" value="<?= htmlspecialchars($editItem['id']) ?>">
        <?php endif; ?>
        
        <div>
            <label class="block text-admin-text-muted text-sm font-medium mb-2">Pertanyaan</label>
            <input type="text" name="question" required value="<?= $editItem ? htmlspecialchars($editItem['question'] ?? '') : '' ?>" 
                    class="w-full bg-admin-surface-light border border-admin-border rounded-lg px-4 py-2.5 text-admin-text focus:outline-none focus:border-admin-primary">
        </div>

        <div>
          <label class="block text-admin-text-muted text-sm font-medium mb-2">Jawaban</label>
          <textarea name="answer" required rows="6" 
                    class="w-full bg-admin-surface-light border border-admin-border rounded-lg px-4 py-2.5 text-admin-text focus:outline-none focus:border-admin-primary"><?= $editItem ? htmlspecialchars($editItem['answer'] ?? '') : '' ?></textarea>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-admin-border">
            <a href="faq.php" class="px-5 py-2.5 rounded-lg border border-admin-border text-admin-text hover:bg-admin-surface-light transition-colors">Batal</a>
            <button type="submit" class="px-5 py-2.5 rounded-lg bg-admin-primary hover:bg-admin-primary-light text-white transition-colors">
                <?= $action === 'edit' ? 'Simpan Perubahan' : 'Tambah FAQ' ?>
            </button>
        </div>
      </form>
    </div>
    <?php else: ?>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php if (empty($faqs)): ?>
        <div class="col-span-full p-8 text-center text-admin-text-muted bg-admin-surface rounded-xl border border-admin-border">
            Belum ada FAQ.
        </div>
        <?php else: ?>
        <?php foreach ($faqs as $faq): ?>
        <div class="bg-admin-surface rounded-xl border border-admin-border p-6 flex flex-col hover:border-admin-primary/50 transition-colors">
            <div class="flex-1">
                <h3 class="text-admin-text font-medium mb-2 line-clamp-2"><?= htmlspecialchars($faq['question'] ?? '') ?></h3>
                <p class="text-admin-text-muted text-sm line-clamp-4"><?= htmlspecialchars($faq['answer'] ?? '') ?></p>
            </div>
            <div class="flex items-center justify-end gap-2 mt-6 pt-4 border-t border-admin-border">
                <a href="?edit=<?= htmlspecialchars($faq['id']) ?>" class="px-3 py-1.5 text-xs text-admin-text-muted hover:text-admin-primary transition-colors bg-admin-surface-light rounded flex items-center gap-1 border border-admin-border" title="Edit">
                    <span class="material-symbols-outlined" style="font-size: 16px;">edit</span>
                    <span>Edit</span>
                </a>
                <form action="api/delete.php" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus FAQ ini?');">
                    <input type="hidden" name="type" value="faq">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($faq['id']) ?>">
                    <button type="submit" class="px-3 py-1.5 text-xs text-admin-text-muted hover:text-admin-danger transition-colors bg-admin-surface-light rounded flex items-center gap-1 border border-admin-border" title="Hapus">
                        <span class="material-symbols-outlined" style="font-size: 16px;">delete</span>
                        <span>Hapus</span>
                    </button>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
    
    <?php endif; ?>
  </div>
</main>
</body></html>
