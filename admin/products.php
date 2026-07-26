<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/functions.php';

$pageTitle = 'Kelola Produk';
$products = read_json('products.json');

$action = $_GET['action'] ?? '';
$editId = $_GET['edit'] ?? null;

$editProduct = null;
if ($editId) {
    foreach ($products as $p) {
        if ($p['id'] == $editId) {
            $editProduct = $p;
            $action = 'edit';
            break;
        }
    }
}

require_once __DIR__ . '/includes/admin_header.php';
require_once __DIR__ . '/includes/sidebar.php';
?>
<main class="lg:ml-64 min-h-screen">
    <!-- Top Bar -->
    <header class="sticky top-0 z-30 bg-admin-bg/80 backdrop-blur-xl border-b border-admin-border px-6 py-4 flex justify-between items-center">
        <h1 class="text-xl font-manrope font-bold text-admin-text"><?= $pageTitle ?></h1>
        <?php if ($action !== 'add' && $action !== 'edit'): ?>
            <a href="?action=add" class="bg-admin-primary hover:bg-admin-primary-light text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors inline-flex items-center gap-2">
                <span class="material-symbols-outlined text-[20px]">add</span>
                Tambah Produk
            </a>
        <?php else: ?>
            <a href="products.php" class="bg-admin-surface-light hover:bg-admin-border text-admin-text px-4 py-2 rounded-lg text-sm font-medium transition-colors inline-flex items-center gap-2 border border-admin-border">
                <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                Kembali
            </a>
        <?php endif; ?>
    </header>

    <div class="p-6">
        <?php if (isset($_GET['success'])): ?>
            <div class="bg-admin-success/10 border border-admin-success text-admin-success px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined">check_circle</span>
                Data berhasil disimpan!
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['deleted'])): ?>
            <div class="bg-admin-success/10 border border-admin-success text-admin-success px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined">check_circle</span>
                Data berhasil dihapus!
            </div>
        <?php endif; ?>

        <?php if ($action === 'add' || $action === 'edit'): ?>
            <div class="bg-admin-surface border border-admin-border rounded-xl shadow-sm">
                <div class="p-6">
                    <form action="api/save.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="type" value="product">
                        <?php if ($editProduct): ?>
                            <input type="hidden" name="id" value="<?= $editProduct['id'] ?>">
                        <?php endif; ?>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-admin-text-muted mb-2">Nama Produk</label>
                                <input type="text" name="name" value="<?= htmlspecialchars($editProduct['name'] ?? '') ?>" required 
                                       class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-2 text-admin-text focus:outline-none focus:border-admin-primary focus:ring-1 focus:ring-admin-primary">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-admin-text-muted mb-2">Kategori</label>
                                <input type="text" name="category" value="<?= htmlspecialchars($editProduct['category'] ?? '') ?>" required
                                       class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-2 text-admin-text focus:outline-none focus:border-admin-primary focus:ring-1 focus:ring-admin-primary">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-admin-text-muted mb-2">Sub Kategori</label>
                                <input type="text" name="sub_category" value="<?= htmlspecialchars($editProduct['sub_category'] ?? '') ?>" 
                                       class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-2 text-admin-text focus:outline-none focus:border-admin-primary focus:ring-1 focus:ring-admin-primary">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-admin-text-muted mb-2">Harga (Rp)</label>
                                <input type="number" name="price" value="<?= $editProduct['price'] ?? '' ?>" required
                                       class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-2 text-admin-text focus:outline-none focus:border-admin-primary focus:ring-1 focus:ring-admin-primary">
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-admin-text-muted mb-2">Deskripsi Singkat</label>
                                <textarea name="description" rows="3" required
                                          class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-2 text-admin-text focus:outline-none focus:border-admin-primary focus:ring-1 focus:ring-admin-primary"><?= htmlspecialchars($editProduct['description'] ?? '') ?></textarea>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-admin-text-muted mb-2">Deskripsi Lengkap</label>
                                <textarea name="full_description" rows="5" required
                                          class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-2 text-admin-text focus:outline-none focus:border-admin-primary focus:ring-1 focus:ring-admin-primary"><?= htmlspecialchars($editProduct['full_description'] ?? '') ?></textarea>
                            </div>

                            <!-- Image Upload & Preview Section -->
                            <div class="md:col-span-2 bg-admin-bg/60 p-4 rounded-xl border border-admin-border/80">
                                <label class="block text-sm font-semibold text-admin-text mb-3">Gambar Produk</label>
                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                                    <!-- Image Preview Box -->
                                    <div class="flex flex-col items-center justify-center p-3 bg-admin-surface border border-admin-border rounded-lg h-44 relative group">
                                        <?php 
                                        $currentImg = get_image_url($editProduct['image'] ?? '');
                                        ?>
                                        <img id="img_preview" src="<?= htmlspecialchars($currentImg) ?>" alt="Preview" 
                                             class="<?= empty($currentImg) ? 'hidden' : '' ?> max-h-36 max-w-full object-contain rounded">
                                        <div id="no_img_placeholder" class="<?= !empty($currentImg) ? 'hidden' : '' ?> text-center text-admin-text-muted">
                                            <span class="material-symbols-outlined text-4xl block mb-1">image</span>
                                            <span class="text-xs">Belum ada gambar</span>
                                        </div>
                                    </div>

                                    <!-- Upload Options -->
                                    <div class="md:col-span-2 space-y-4">
                                        <!-- File Upload Input -->
                                        <div>
                                            <label class="block text-xs font-medium text-admin-text-muted mb-1.5">1. Upload Gambar dari Komputer</label>
                                            <div class="flex items-center gap-3">
                                                <label class="cursor-pointer bg-admin-primary hover:bg-admin-primary-light text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors inline-flex items-center gap-2">
                                                    <span class="material-symbols-outlined text-lg">cloud_upload</span>
                                                    <span>Pilih File Gambar</span>
                                                    <input type="file" name="image_file" accept="image/*" onchange="previewImageFile(this)" class="hidden">
                                                </label>
                                                <span id="selected_file_name" class="text-xs text-admin-text-muted italic truncate max-w-xs">Tidak ada file baru dipilih</span>
                                            </div>
                                            <p class="text-[11px] text-admin-text-muted/70 mt-1">Format didukung: JPG, PNG, WEBP, GIF (Maks. 5MB)</p>
                                        </div>

                                        <!-- URL / Path Input -->
                                        <div>
                                            <label class="block text-xs font-medium text-admin-text-muted mb-1.5">2. Atau Gunakan URL / Path Gambar (Opsional)</label>
                                            <input type="text" name="image" id="image_url_input" value="<?= htmlspecialchars($editProduct['image'] ?? '') ?>"
                                                   oninput="previewImageUrl(this.value)"
                                                   placeholder="contoh: gambar/produk1.png atau https://..."
                                                   class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-2 text-sm text-admin-text focus:outline-none focus:border-admin-primary focus:ring-1 focus:ring-admin-primary">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-admin-text-muted mb-2">Badge</label>
                                <input type="text" name="badge" value="<?= htmlspecialchars($editProduct['badge'] ?? '') ?>" 
                                       class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-2 text-admin-text focus:outline-none focus:border-admin-primary focus:ring-1 focus:ring-admin-primary" placeholder="e.g. Best Seller">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-admin-text-muted mb-2">Tag</label>
                                <input type="text" name="tag" value="<?= htmlspecialchars($editProduct['tag'] ?? '') ?>" 
                                       class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-2 text-admin-text focus:outline-none focus:border-admin-primary focus:ring-1 focus:ring-admin-primary">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-admin-text-muted mb-2">Target Tanaman</label>
                                <input type="text" name="crop_target" value="<?= htmlspecialchars($editProduct['crop_target'] ?? '') ?>" 
                                       class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-2 text-admin-text focus:outline-none focus:border-admin-primary focus:ring-1 focus:ring-admin-primary">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-admin-text-muted mb-2">Dosis</label>
                                <input type="text" name="dosage" value="<?= htmlspecialchars($editProduct['dosage'] ?? '') ?>" 
                                       class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-2 text-admin-text focus:outline-none focus:border-admin-primary focus:ring-1 focus:ring-admin-primary">
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-admin-text-muted mb-2">Manfaat (Pisahkan dengan koma)</label>
                                <?php
                                $benefitsStr = '';
                                if ($editProduct && !empty($editProduct['benefits'])) {
                                    $benefitsStr = implode(', ', $editProduct['benefits']);
                                }
                                ?>
                                <textarea name="benefits" rows="3"
                                          class="w-full bg-admin-bg border border-admin-border rounded-lg px-4 py-2 text-admin-text focus:outline-none focus:border-admin-primary focus:ring-1 focus:ring-admin-primary"><?= htmlspecialchars($benefitsStr) ?></textarea>
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end gap-4">
                            <a href="products.php" class="px-6 py-2 rounded-lg font-medium text-admin-text hover:bg-admin-surface-light border border-admin-border transition-colors">Batal</a>
                            <button type="submit" class="px-6 py-2 rounded-lg font-medium bg-admin-primary hover:bg-admin-primary-light text-white transition-colors">
                                Simpan Produk
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        <?php else: ?>
            <div class="bg-admin-surface border border-admin-border rounded-xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-admin-surface-light border-b border-admin-border">
                                <th class="py-4 px-6 text-sm font-semibold text-admin-text-muted">Gambar</th>
                                <th class="py-4 px-6 text-sm font-semibold text-admin-text-muted">Nama</th>
                                <th class="py-4 px-6 text-sm font-semibold text-admin-text-muted">Kategori</th>
                                <th class="py-4 px-6 text-sm font-semibold text-admin-text-muted">Harga</th>
                                <th class="py-4 px-6 text-sm font-semibold text-admin-text-muted">Badge</th>
                                <th class="py-4 px-6 text-sm font-semibold text-admin-text-muted text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-admin-border">
                            <?php if (empty($products)): ?>
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-admin-text-muted">Belum ada produk.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($products as $product): ?>
                                    <tr class="hover:bg-admin-surface-light/50 transition-colors">
                                        <td class="py-4 px-6">
                                            <?php if (!empty($product['image'])): ?>
                                                <img src="<?= htmlspecialchars(get_image_url($product['image'])) ?>" alt="<?= htmlspecialchars($product['name'] ?? '') ?>" class="w-12 h-12 rounded object-cover border border-admin-border bg-admin-bg">
                                            <?php else: ?>
                                                <div class="w-12 h-12 rounded border border-admin-border bg-admin-bg flex items-center justify-center text-admin-text-muted">
                                                    <span class="material-symbols-outlined text-[20px]">image</span>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="py-4 px-6">
                                            <div class="font-medium text-admin-text"><?= htmlspecialchars($product['name'] ?? '') ?></div>
                                            <div class="text-xs text-admin-text-muted mt-1 truncate max-w-xs"><?= htmlspecialchars($product['sub_category'] ?? '') ?></div>
                                        </td>
                                        <td class="py-4 px-6">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-admin-bg border border-admin-border text-admin-text-muted">
                                                <?= htmlspecialchars($product['category'] ?? '') ?>
                                            </span>
                                        </td>
                                        <td class="py-4 px-6 font-medium text-admin-text">
                                            <?= format_rupiah_admin($product['price'] ?? 0) ?>
                                        </td>
                                        <td class="py-4 px-6">
                                            <?php if (!empty($product['badge'])): ?>
                                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-admin-primary/10 text-admin-primary border border-admin-primary/20">
                                                    <?= htmlspecialchars($product['badge']) ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="text-admin-text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="py-4 px-6">
                                            <div class="flex justify-end gap-2">
                                                <a href="?edit=<?= $product['id'] ?>" class="p-2 text-admin-text-muted hover:text-admin-primary hover:bg-admin-primary/10 rounded-lg transition-colors" title="Edit">
                                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                                </a>
                                                <form action="api/delete.php" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                                    <input type="hidden" name="type" value="products">
                                                    <input type="hidden" name="id" value="<?= $product['id'] ?>">
                                                    <button type="submit" class="p-2 text-admin-text-muted hover:text-admin-danger hover:bg-admin-danger/10 rounded-lg transition-colors" title="Hapus">
                                                        <span class="material-symbols-outlined text-[20px]">delete</span>
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
function previewImageFile(input) {
    const file = input.files[0];
    const preview = document.getElementById('img_preview');
    const placeholder = document.getElementById('no_img_placeholder');
    const fileNameSpan = document.getElementById('selected_file_name');

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

function previewImageUrl(url) {
    const preview = document.getElementById('img_preview');
    const placeholder = document.getElementById('no_img_placeholder');
    
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
