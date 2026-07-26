<?php
/**
 * Admin Dashboard - Main Page
 */
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/functions.php';

$pageTitle = 'Dashboard';

// Get counts
$productCount = get_count('products.json');
$articleCount = get_count('articles.json');
$faqCount = get_count('faq.json');
$messageCount = get_count('messages.json');
$unreadMessages = get_unread_count();

// Get recent messages
$messages = read_json('messages.json');
$recentMessages = array_slice(array_reverse($messages), 0, 5);

// Get products for quick view
$products = read_json('products.json');

require_once __DIR__ . '/includes/admin_header.php';
require_once __DIR__ . '/includes/sidebar.php';
?>

<!-- Main Content -->
<main class="lg:ml-64 min-h-screen">
    <!-- Top Bar -->
    <header class="sticky top-0 z-30 bg-admin-bg/80 backdrop-blur-xl border-b border-admin-border px-6 py-4">
        <div class="flex items-center justify-between">
            <div class="lg:ml-0 ml-12">
                <h1 class="text-xl font-bold text-admin-text font-manrope">Dashboard</h1>
                <p class="text-sm text-admin-text-muted">Selamat datang kembali, <?= sanitize($settings['admin_username'] ?? 'Admin') ?> 👋</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="messages.php" class="relative p-2 text-admin-text-muted hover:text-admin-text transition-colors">
                    <span class="material-symbols-outlined">notifications</span>
                    <?php if ($unreadMessages > 0): ?>
                    <span class="absolute top-0 right-0 w-5 h-5 bg-admin-danger text-white text-[10px] font-bold rounded-full flex items-center justify-center"><?= $unreadMessages ?></span>
                    <?php endif; ?>
                </a>
                <a href="../index.php" target="_blank" class="hidden sm:flex items-center gap-2 text-sm text-admin-text-muted hover:text-admin-accent transition-colors px-3 py-2 rounded-lg border border-admin-border hover:border-admin-accent/30">
                    <span class="material-symbols-outlined text-base">open_in_new</span>
                    Lihat Website
                </a>
            </div>
        </div>
    </header>

    <div class="p-6 space-y-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Products -->
            <a href="products.php" class="group bg-admin-surface rounded-xl border border-admin-border p-5 hover:border-admin-primary/50 transition-all hover:shadow-lg hover:shadow-admin-primary/5">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-indigo-500/20 to-indigo-600/20 flex items-center justify-center">
                        <span class="material-symbols-outlined text-indigo-400 text-xl">inventory_2</span>
                    </div>
                    <span class="material-symbols-outlined text-admin-text-muted text-lg group-hover:text-admin-primary transition-colors">arrow_forward</span>
                </div>
                <p class="text-2xl font-bold text-admin-text font-manrope"><?= $productCount ?></p>
                <p class="text-sm text-admin-text-muted">Total Produk</p>
            </a>

            <!-- Articles -->
            <a href="articles.php" class="group bg-admin-surface rounded-xl border border-admin-border p-5 hover:border-admin-accent/50 transition-all hover:shadow-lg hover:shadow-admin-accent/5">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-cyan-500/20 to-cyan-600/20 flex items-center justify-center">
                        <span class="material-symbols-outlined text-cyan-400 text-xl">article</span>
                    </div>
                    <span class="material-symbols-outlined text-admin-text-muted text-lg group-hover:text-admin-accent transition-colors">arrow_forward</span>
                </div>
                <p class="text-2xl font-bold text-admin-text font-manrope"><?= $articleCount ?></p>
                <p class="text-sm text-admin-text-muted">Total Artikel</p>
            </a>

            <!-- FAQ -->
            <a href="faq.php" class="group bg-admin-surface rounded-xl border border-admin-border p-5 hover:border-admin-success/50 transition-all hover:shadow-lg hover:shadow-admin-success/5">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-emerald-500/20 to-emerald-600/20 flex items-center justify-center">
                        <span class="material-symbols-outlined text-emerald-400 text-xl">quiz</span>
                    </div>
                    <span class="material-symbols-outlined text-admin-text-muted text-lg group-hover:text-admin-success transition-colors">arrow_forward</span>
                </div>
                <p class="text-2xl font-bold text-admin-text font-manrope"><?= $faqCount ?></p>
                <p class="text-sm text-admin-text-muted">Total FAQ</p>
            </a>

            <!-- Messages -->
            <a href="messages.php" class="group bg-admin-surface rounded-xl border border-admin-border p-5 hover:border-admin-warning/50 transition-all hover:shadow-lg hover:shadow-admin-warning/5">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-amber-500/20 to-amber-600/20 flex items-center justify-center">
                        <span class="material-symbols-outlined text-amber-400 text-xl">mail</span>
                    </div>
                    <span class="material-symbols-outlined text-admin-text-muted text-lg group-hover:text-admin-warning transition-colors">arrow_forward</span>
                </div>
                <p class="text-2xl font-bold text-admin-text font-manrope"><?= $messageCount ?></p>
                <p class="text-sm text-admin-text-muted">Pesan Masuk <?php if ($unreadMessages > 0): ?><span class="text-admin-warning">(<?= $unreadMessages ?> baru)</span><?php endif; ?></p>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Quick Actions -->
            <div class="bg-admin-surface rounded-xl border border-admin-border p-6">
                <h2 class="text-lg font-semibold text-admin-text font-manrope mb-4">Aksi Cepat</h2>
                <div class="space-y-2">
                    <a href="products.php?action=add" class="flex items-center gap-3 p-3 rounded-lg hover:bg-admin-bg transition-colors group">
                        <div class="w-9 h-9 rounded-lg bg-indigo-500/10 flex items-center justify-center group-hover:bg-indigo-500/20 transition-colors">
                            <span class="material-symbols-outlined text-indigo-400 text-lg">add_circle</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-admin-text">Tambah Produk</p>
                            <p class="text-xs text-admin-text-muted">Tambah produk baru ke katalog</p>
                        </div>
                    </a>
                    <a href="articles.php?action=add" class="flex items-center gap-3 p-3 rounded-lg hover:bg-admin-bg transition-colors group">
                        <div class="w-9 h-9 rounded-lg bg-cyan-500/10 flex items-center justify-center group-hover:bg-cyan-500/20 transition-colors">
                            <span class="material-symbols-outlined text-cyan-400 text-lg">edit_note</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-admin-text">Tulis Artikel</p>
                            <p class="text-xs text-admin-text-muted">Buat artikel insight baru</p>
                        </div>
                    </a>
                    <a href="hero.php" class="flex items-center gap-3 p-3 rounded-lg hover:bg-admin-bg transition-colors group">
                        <div class="w-9 h-9 rounded-lg bg-purple-500/10 flex items-center justify-center group-hover:bg-purple-500/20 transition-colors">
                            <span class="material-symbols-outlined text-purple-400 text-lg">photo_library</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-admin-text">Edit Hero Banner</p>
                            <p class="text-xs text-admin-text-muted">Ubah tampilan hero section</p>
                        </div>
                    </a>
                    <a href="settings.php" class="flex items-center gap-3 p-3 rounded-lg hover:bg-admin-bg transition-colors group">
                        <div class="w-9 h-9 rounded-lg bg-slate-500/10 flex items-center justify-center group-hover:bg-slate-500/20 transition-colors">
                            <span class="material-symbols-outlined text-slate-400 text-lg">settings</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-admin-text">Pengaturan</p>
                            <p class="text-xs text-admin-text-muted">Kelola pengaturan situs</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Recent Messages -->
            <div class="lg:col-span-2 bg-admin-surface rounded-xl border border-admin-border p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-admin-text font-manrope">Pesan Terbaru</h2>
                    <a href="messages.php" class="text-sm text-admin-primary hover:text-admin-primary-light transition-colors">Lihat Semua</a>
                </div>
                <?php if (empty($recentMessages)): ?>
                <div class="text-center py-8">
                    <span class="material-symbols-outlined text-4xl text-admin-text-muted/30">inbox</span>
                    <p class="text-admin-text-muted text-sm mt-2">Belum ada pesan masuk</p>
                </div>
                <?php else: ?>
                <div class="space-y-3">
                    <?php foreach ($recentMessages as $msg): ?>
                    <div class="flex items-start gap-3 p-3 rounded-lg <?= empty($msg['read']) ? 'bg-admin-primary/5 border border-admin-primary/10' : 'hover:bg-admin-bg' ?> transition-colors">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-admin-primary to-admin-accent flex items-center justify-center flex-shrink-0 mt-0.5">
                            <span class="text-white text-xs font-bold"><?= strtoupper(substr($msg['nama'] ?? '?', 0, 1)) ?></span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <p class="text-sm font-medium text-admin-text truncate"><?= sanitize($msg['nama'] ?? 'Anonim') ?></p>
                                <?php if (empty($msg['read'])): ?>
                                <span class="w-2 h-2 rounded-full bg-admin-primary flex-shrink-0"></span>
                                <?php endif; ?>
                            </div>
                            <p class="text-xs text-admin-text-muted truncate"><?= sanitize($msg['subjek'] ?? $msg['pesan'] ?? '') ?></p>
                            <p class="text-[10px] text-admin-text-muted/70 mt-1"><?= isset($msg['created_at']) ? time_ago($msg['created_at']) : '' ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Products Table -->
        <div class="bg-admin-surface rounded-xl border border-admin-border p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-admin-text font-manrope">Daftar Produk</h2>
                <a href="products.php" class="text-sm text-admin-primary hover:text-admin-primary-light transition-colors">Kelola Produk</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-admin-border">
                            <th class="text-left py-3 px-4 text-admin-text-muted font-medium">Produk</th>
                            <th class="text-left py-3 px-4 text-admin-text-muted font-medium">Kategori</th>
                            <th class="text-left py-3 px-4 text-admin-text-muted font-medium">Harga</th>
                            <th class="text-left py-3 px-4 text-admin-text-muted font-medium">Badge</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                        <tr class="border-b border-admin-border/50 hover:bg-admin-bg/50 transition-colors">
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <img src="<?= htmlspecialchars(get_image_url($product['image'] ?? '')) ?>" alt="" class="w-10 h-10 rounded-lg object-contain bg-white/5 border border-admin-border">
                                    <span class="font-medium text-admin-text"><?= sanitize($product['name']) ?></span>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="bg-admin-primary/10 text-admin-primary-light px-2 py-1 rounded-md text-xs"><?= sanitize($product['category']) ?></span>
                            </td>
                            <td class="py-3 px-4 text-admin-text"><?= format_rupiah_admin($product['price']) ?></td>
                            <td class="py-3 px-4">
                                <?php if (!empty($product['badge'])): ?>
                                <span class="bg-admin-success/10 text-admin-success px-2 py-1 rounded-md text-xs"><?= sanitize($product['badge']) ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

</body>
</html>
