<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/functions.php';

$pageTitle = 'Kelola Artikel';

$articles = read_json('articles.json');
if (!is_array($articles)) $articles = [];

$action = $_GET['action'] ?? '';
$editId = $_GET['edit'] ?? null;
$editItem = null;

if ($editId) {
    foreach ($articles as $a) {
        if ($a['id'] == $editId) {
            $editItem = $a;
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
      <span>Tambah Artikel</span>
    </a>
    <?php else: ?>
    <a href="articles.php" class="bg-admin-surface-light border border-admin-border text-admin-text hover:text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
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
    
    <?php if (isset($_GET['error'])): ?>
    <div class="mb-6 p-4 rounded-lg bg-admin-danger/10 border border-admin-danger/20 flex items-center gap-3 text-admin-danger">
      <span class="material-symbols-outlined">error</span>
      <p><?= htmlspecialchars($_GET['error']) ?></p>
    </div>
    <?php endif; ?>

    <?php if ($action === 'add' || $action === 'edit'): ?>
    <div class="bg-admin-surface rounded-xl border border-admin-border p-6">
      <form action="api/save.php" method="POST" enctype="multipart/form-data" class="space-y-6">
        <input type="hidden" name="type" value="article">
        <input type="hidden" name="action" value="<?= $action ?>">
        <?php if ($editItem): ?>
        <input type="hidden" name="id" value="<?= htmlspecialchars($editItem['id']) ?>">
        <?php endif; ?>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div>
              <label class="block text-admin-text-muted text-sm font-medium mb-2">Judul Artikel</label>
              <input type="text" name="title" required value="<?= $editItem ? htmlspecialchars($editItem['title'] ?? '') : '' ?>" 
                     class="w-full bg-admin-surface-light border border-admin-border rounded-lg px-4 py-2.5 text-admin-text focus:outline-none focus:border-admin-primary">
            </div>
            
            <div>
              <label class="block text-admin-text-muted text-sm font-medium mb-2">Kategori</label>
              <input type="text" name="category" required value="<?= $editItem ? htmlspecialchars($editItem['category'] ?? '') : '' ?>" 
                     class="w-full bg-admin-surface-light border border-admin-border rounded-lg px-4 py-2.5 text-admin-text focus:outline-none focus:border-admin-primary">
            </div>

            <div class="lg:col-span-2">
              <label class="block text-admin-text-muted text-sm font-medium mb-2">Tanggal</label>
              <input type="date" name="date" required value="<?= $editItem ? htmlspecialchars($editItem['date'] ?? '') : date('Y-m-d') ?>" 
                     class="w-full bg-admin-surface-light border border-admin-border rounded-lg px-4 py-2.5 text-admin-text focus:outline-none focus:border-admin-primary" style="color-scheme: dark;">
            </div>

            <!-- Image Upload & Preview Section -->
            <div class="lg:col-span-2 bg-admin-bg/60 p-4 rounded-xl border border-admin-border/80">
                <label class="block text-sm font-semibold text-admin-text mb-3">Gambar Artikel</label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                    <div class="flex flex-col items-center justify-center p-3 bg-admin-surface border border-admin-border rounded-lg h-36 relative">
                        <?php 
                        $currentArtImg = $editItem && !empty($editItem['image']) ? get_image_url($editItem['image']) : '';
                        ?>
                        <img id="article_img_preview" src="<?= htmlspecialchars($currentArtImg) ?>" alt="Preview" 
                             class="<?= empty($currentArtImg) ? 'hidden' : '' ?> max-h-30 max-w-full object-contain rounded">
                        <div id="art_no_img" class="<?= !empty($currentArtImg) ? 'hidden' : '' ?> text-center text-admin-text-muted">
                            <span class="material-symbols-outlined text-4xl block mb-1">image</span>
                            <span class="text-xs">Belum ada gambar</span>
                        </div>
                    </div>
                    <div class="md:col-span-2 space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-admin-text-muted mb-1">1. Upload Gambar dari Komputer</label>
                            <label class="cursor-pointer bg-admin-primary hover:bg-admin-primary-light text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors inline-flex items-center gap-2">
                                <span class="material-symbols-outlined text-lg">cloud_upload</span>
                                <span>Pilih File Gambar</span>
                                <input type="file" name="image_file" accept="image/*" onchange="previewArticleFile(this)" class="hidden">
                            </label>
                            <span id="art_file_name" class="text-xs text-admin-text-muted italic ml-2">Tidak ada file baru</span>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-admin-text-muted mb-1">2. Atau URL / Path Gambar</label>
                            <input type="text" name="image" value="<?= $editItem ? htmlspecialchars($editItem['image'] ?? '') : '' ?>"
                                   oninput="previewArticleUrl(this.value)" placeholder="gambar/... atau https://..."
                                   class="w-full bg-admin-surface-light border border-admin-border rounded-lg px-4 py-2 text-sm text-admin-text focus:outline-none focus:border-admin-primary">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div>
          <label class="block text-admin-text-muted text-sm font-medium mb-2">Ringkasan (Excerpt)</label>
          <textarea name="excerpt" required rows="3" 
                    class="w-full bg-admin-surface-light border border-admin-border rounded-lg px-4 py-2.5 text-admin-text focus:outline-none focus:border-admin-primary" placeholder="Ringkasan singkat untuk kartu artikel..."><?= $editItem ? htmlspecialchars($editItem['excerpt'] ?? '') : '' ?></textarea>
        </div>

        <div>
          <label class="block text-admin-text-muted text-sm font-medium mb-2">Isi Artikel Lengkap</label>
          <textarea name="content" rows="8" 
                    class="w-full bg-admin-surface-light border border-admin-border rounded-lg px-4 py-2.5 text-admin-text focus:outline-none focus:border-admin-primary" placeholder="Tulis isi lengkap artikel di sini. Gunakan baris baru untuk memisah paragraf."><?= $editItem ? htmlspecialchars($editItem['content'] ?? '') : '' ?></textarea>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-admin-border">
            <a href="articles.php" class="px-5 py-2.5 rounded-lg border border-admin-border text-admin-text hover:bg-admin-surface-light transition-colors">Batal</a>
            <button type="submit" class="px-5 py-2.5 rounded-lg bg-admin-primary hover:bg-admin-primary-light text-white transition-colors">
                <?= $action === 'edit' ? 'Simpan Perubahan' : 'Tambah Artikel' ?>
            </button>
        </div>
      </form>
    </div>
    <?php else: ?>
    <div class="bg-admin-surface rounded-xl border border-admin-border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-admin-surface-light border-b border-admin-border text-admin-text-muted">
                        <th class="p-4 font-medium text-sm">Gambar</th>
                        <th class="p-4 font-medium text-sm">Judul</th>
                        <th class="p-4 font-medium text-sm">Kategori</th>
                        <th class="p-4 font-medium text-sm">Tanggal</th>
                        <th class="p-4 font-medium text-sm text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-admin-border">
                    <?php if (empty($articles)): ?>
                    <tr>
                        <td colspan="5" class="p-8 text-center text-admin-text-muted">Belum ada artikel.</td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($articles as $article): ?>
                    <tr class="hover:bg-admin-surface-light/50 transition-colors">
                        <td class="p-4">
                            <img src="<?= htmlspecialchars(get_image_url($article['image'] ?? '')) ?>" alt="img" class="w-16 h-12 object-cover rounded border border-admin-border">
                        </td>
                        <td class="p-4">
                            <div class="font-medium text-admin-text"><?= htmlspecialchars($article['title'] ?? '') ?></div>
                            <div class="text-sm text-admin-text-muted mt-1 max-w-xs truncate"><?= htmlspecialchars($article['excerpt'] ?? '') ?></div>
                        </td>
                        <td class="p-4 text-admin-text">
                            <span class="px-2.5 py-1 rounded-full bg-admin-surface-light border border-admin-border text-xs">
                                <?= htmlspecialchars($article['category'] ?? '') ?>
                            </span>
                        </td>
                        <td class="p-4 text-admin-text"><?= htmlspecialchars($article['date'] ?? '') ?></td>
                        <td class="p-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="?edit=<?= htmlspecialchars($article['id']) ?>" class="p-2 text-admin-text-muted hover:text-admin-primary transition-colors bg-admin-surface-light rounded-lg border border-admin-border" title="Edit">
                                    <span class="material-symbols-outlined text-sm">edit</span>
                                </a>
                                <form action="api/delete.php" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus artikel ini?');">
                                    <input type="hidden" name="type" value="articles">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($article['id']) ?>">
                                    <button type="submit" class="p-2 text-admin-text-muted hover:text-admin-danger transition-colors bg-admin-surface-light rounded-lg border border-admin-border" title="Hapus">
                                        <span class="material-symbols-outlined text-sm">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>
  </div>
<script>
function previewArticleFile(input) {
    const file = input.files[0];
    const preview = document.getElementById('article_img_preview');
    const placeholder = document.getElementById('art_no_img');
    const fileNameSpan = document.getElementById('art_file_name');

    if (file) {
        fileNameSpan.textContent = file.name;
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            if (placeholder) placeholder.classList.add('hidden');
        };
        reader.readAsDataURL(file);
    }
}

function previewArticleUrl(url) {
    const preview = document.getElementById('article_img_preview');
    const placeholder = document.getElementById('art_no_img');
    
    if (url.trim() !== '') {
        let src = url;
        if (!url.startsWith('http') && !url.startsWith('/')) {
            src = '../' + url;
        }
        preview.src = src;
        preview.classList.remove('hidden');
        if (placeholder) placeholder.classList.add('hidden');
    } else {
        preview.src = '';
        preview.classList.add('hidden');
        if (placeholder) placeholder.classList.remove('hidden');
    }
}
</script>
</body></html>
