<?php
/**
 * Admin Sidebar Navigation
 */
$reqPath = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
$currentAdminPage = basename($reqPath) ?: 'index.php';
?>
<!-- Mobile Menu Toggle -->
<button onclick="toggleSidebar()" class="fixed top-4 left-4 z-50 lg:hidden bg-admin-surface p-2 rounded-lg border border-admin-border shadow-lg">
    <span class="material-symbols-outlined text-admin-text">menu</span>
</button>

<!-- Sidebar Overlay (mobile) -->
<div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/60 z-40 hidden lg:hidden backdrop-blur-sm"></div>

<!-- Sidebar -->
<aside id="sidebar" class="fixed top-0 left-0 h-full w-64 bg-admin-surface border-r border-admin-border z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 flex flex-col">
    <!-- Brand -->
    <div class="px-6 py-6 border-b border-admin-border">
        <a href="index.php" class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-admin-primary to-admin-primary-light flex items-center justify-center">
                <span class="material-symbols-outlined icon-fill text-white text-xl">eco</span>
            </div>
            <div>
                <h1 class="font-manrope font-bold text-admin-text text-sm">Sarana Pertanian</h1>
                <p class="text-[11px] text-admin-text-muted">Admin Panel</p>
            </div>
        </a>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
        <p class="px-3 text-[10px] font-semibold uppercase tracking-wider text-admin-text-muted mb-2">Menu Utama</p>
        
        <a href="index.php" class="sidebar-link <?= $currentAdminPage === 'index.php' ? 'active' : '' ?> flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-admin-text-muted transition-all">
            <span class="material-symbols-outlined text-xl">dashboard</span>
            Dashboard
        </a>
        
        <a href="products.php" class="sidebar-link <?= $currentAdminPage === 'products.php' ? 'active' : '' ?> flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-admin-text-muted transition-all">
            <span class="material-symbols-outlined text-xl">inventory_2</span>
            Produk
        </a>
        
        <a href="articles.php" class="sidebar-link <?= $currentAdminPage === 'articles.php' ? 'active' : '' ?> flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-admin-text-muted transition-all">
            <span class="material-symbols-outlined text-xl">article</span>
            Artikel
        </a>
        
        <a href="faq.php" class="sidebar-link <?= $currentAdminPage === 'faq.php' ? 'active' : '' ?> flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-admin-text-muted transition-all">
            <span class="material-symbols-outlined text-xl">quiz</span>
            FAQ
        </a>

        <p class="px-3 text-[10px] font-semibold uppercase tracking-wider text-admin-text-muted mb-2 mt-6">Halaman</p>
        
        <a href="hero.php" class="sidebar-link <?= $currentAdminPage === 'hero.php' ? 'active' : '' ?> flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-admin-text-muted transition-all">
            <span class="material-symbols-outlined text-xl">photo_library</span>
            Hero Sections
        </a>
        
        <a href="about.php" class="sidebar-link <?= $currentAdminPage === 'about.php' ? 'active' : '' ?> flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-admin-text-muted transition-all">
            <span class="material-symbols-outlined text-xl">info</span>
            Halaman About
        </a>
        
        <a href="contact-info.php" class="sidebar-link <?= $currentAdminPage === 'contact-info.php' ? 'active' : '' ?> flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-admin-text-muted transition-all">
            <span class="material-symbols-outlined text-xl">contact_page</span>
            Info Kontak
        </a>

        <p class="px-3 text-[10px] font-semibold uppercase tracking-wider text-admin-text-muted mb-2 mt-6">Lainnya</p>
        
        <a href="messages.php" class="sidebar-link <?= $currentAdminPage === 'messages.php' ? 'active' : '' ?> flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-admin-text-muted transition-all">
            <span class="material-symbols-outlined text-xl">mail</span>
            Pesan Masuk
            <?php if ($unreadCount > 0): ?>
            <span class="ml-auto bg-admin-danger text-white text-[10px] font-bold px-2 py-0.5 rounded-full"><?= $unreadCount ?></span>
            <?php endif; ?>
        </a>
        
        <a href="settings.php" class="sidebar-link <?= $currentAdminPage === 'settings.php' ? 'active' : '' ?> flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-admin-text-muted transition-all">
            <span class="material-symbols-outlined text-xl">settings</span>
            Pengaturan
        </a>
    </nav>

    <!-- Footer -->
    <div class="px-4 py-4 border-t border-admin-border">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-admin-primary to-admin-accent flex items-center justify-center">
                <span class="text-white text-xs font-bold"><?= strtoupper(substr($settings['admin_username'] ?? 'A', 0, 1)) ?></span>
            </div>
            <div>
                <p class="text-xs font-medium text-admin-text"><?= sanitize($settings['admin_username'] ?? 'Admin') ?></p>
                <p class="text-[10px] text-admin-text-muted">Administrator</p>
            </div>
        </div>
        <a href="login.php?logout=1" class="flex items-center gap-2 text-xs text-admin-danger hover:text-red-400 transition-colors">
            <span class="material-symbols-outlined text-base">logout</span>
            Keluar
        </a>
    </div>
</aside>

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    sidebar.classList.toggle('-translate-x-full');
    overlay.classList.toggle('hidden');
}
</script>
