<?php
/**
 * Article Detail Page - Sarana Pertanian
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load articles from JSON
$articlesJsonPath = __DIR__ . '/admin/data/articles.json';
$articles = [];
if (file_exists($articlesJsonPath)) {
    $articles = json_decode(file_get_contents($articlesJsonPath), true) ?: [];
}

// Fallback articles if JSON is empty
if (empty($articles)) {
    $articles = [
        [
            'id' => 1,
            'title' => 'Optimizing Nitrogen Retention in Volcanic Soils',
            'category' => 'Research',
            'date' => '2024-10-12',
            'excerpt' => 'New studies reveal the impact of targeted biostimulants on nutrient uptake efficiency.',
            'content' => 'Pengelolaan hara nitrogen pada tanah vulkanik merupakan tantangan utama dalam pertanian komersial. Sifat tanah vulkanik yang memiliki permeabilitas tinggi sering menyebabkan pencucian (leaching) unsur N sebelum sempat diserap secara optimal oleh sistem perakaran tanaman.',
            'image' => 'gambar/image_from_https_images.unsplash.com_photo_1668491028217_2ba01ec8b0bf_auto/screen.png'
        ]
    ];
}

$articleId = isset($_GET['id']) ? (int)$_GET['id'] : 1;
$currentArticle = null;

foreach ($articles as $art) {
    if (isset($art['id']) && $art['id'] === $articleId) {
        $currentArticle = $art;
        break;
    }
}

// Fallback to first article if ID not found
if (!$currentArticle && !empty($articles)) {
    $currentArticle = $articles[0];
}

// Get related articles (exclude current)
$relatedArticles = [];
foreach ($articles as $art) {
    if (isset($art['id']) && $art['id'] !== $currentArticle['id']) {
        $relatedArticles[] = $art;
    }
}
$relatedArticles = array_slice($relatedArticles, 0, 3);

require_once 'includes/header.php';
?>

<main class="bg-surface py-12">
    <div class="px-margin-mobile md:px-margin-desktop max-w-4xl mx-auto">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-sm text-on-surface-variant mb-8">
            <a href="index.php" class="hover:text-primary transition-colors">Home</a>
            <span class="material-symbols-outlined text-xs">chevron_right</span>
            <span class="text-on-surface-variant/70">Agronomic Insights</span>
            <span class="material-symbols-outlined text-xs">chevron_right</span>
            <span class="text-primary font-medium truncate max-w-xs"><?= htmlspecialchars($currentArticle['title'] ?? '') ?></span>
        </nav>

        <!-- Article Header -->
        <div class="mb-8">
            <div class="flex flex-wrap items-center gap-4 text-sm text-on-surface-variant mb-4">
                <span class="bg-[#EFF4EF] text-primary px-3 py-1 rounded-full font-inter font-medium text-xs">
                    <?= htmlspecialchars($currentArticle['category'] ?? 'Insight') ?>
                </span>
                <span class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-base">calendar_today</span>
                    <?= isset($currentArticle['date']) ? date('M d, Y', strtotime($currentArticle['date'])) : date('M d, Y') ?>
                </span>
                <span class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-base">schedule</span>
                    3 menit baca
                </span>
            </div>

            <h1 class="font-manrope text-headline-lg md:text-display-lg-mobile font-bold text-on-surface leading-tight mb-6">
                <?= htmlspecialchars($currentArticle['title'] ?? '') ?>
            </h1>

            <p class="font-inter text-body-lg text-on-surface-variant italic border-l-4 border-primary pl-4 py-1 bg-surface-container-low/50 rounded-r-lg">
                <?= htmlspecialchars($currentArticle['excerpt'] ?? '') ?>
            </p>
        </div>

        <!-- Hero Image -->
        <?php if (!empty($currentArticle['image'])): ?>
        <div class="rounded-2xl overflow-hidden shadow-lg aspect-[16/9] mb-12 border border-outline-variant/30">
            <img src="<?= htmlspecialchars($currentArticle['image']) ?>" alt="<?= htmlspecialchars($currentArticle['title'] ?? '') ?>" class="w-full h-full object-cover">
        </div>
        <?php endif; ?>

        <!-- Article Body Content -->
        <div class="prose max-w-none font-inter text-body-lg text-on-surface space-y-6 leading-relaxed bg-surface-container-lowest p-8 md:p-12 rounded-2xl border border-outline-variant/40 shadow-sm">
            <?php 
            $content = $currentArticle['content'] ?? $currentArticle['excerpt'] ?? '';
            $paragraphs = explode("\n\n", $content);
            foreach ($paragraphs as $para): 
                if (trim($para) === '') continue;
            ?>
            <p><?= nl2br(htmlspecialchars(trim($para))) ?></p>
            <?php endforeach; ?>
        </div>

        <!-- Back Button & Actions -->
        <div class="mt-8 pt-6 border-t border-outline-variant/40 flex flex-wrap items-center justify-between gap-4">
            <a href="index.php#articles" class="inline-flex items-center gap-2 text-primary font-manrope font-semibold text-sm hover:underline">
                <span class="material-symbols-outlined text-base">arrow_back</span>
                Kembali ke Beranda
            </a>
            
            <div class="flex items-center gap-3">
                <span class="text-xs text-on-surface-variant">Bagikan:</span>
                <a href="https://wa.me/?text=<?= urlencode($currentArticle['title'] . ' - ' . 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>" target="_blank" 
                   class="w-9 h-9 rounded-full bg-[#EFF4EF] text-primary hover:bg-primary hover:text-white transition-colors flex items-center justify-center" title="Bagikan ke WhatsApp">
                    <span class="material-symbols-outlined text-base">share</span>
                </a>
            </div>
        </div>

        <!-- Related Articles Section -->
        <?php if (!empty($relatedArticles)): ?>
        <div class="mt-16 pt-12 border-t border-outline-variant/50">
            <h2 class="font-manrope text-headline-md font-bold text-primary mb-8">Artikel Terkait</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <?php foreach ($relatedArticles as $rel): ?>
                <a href="article-detail.php?id=<?= $rel['id'] ?>" class="group bg-surface-container-lowest rounded-xl border border-outline-variant/50 overflow-hidden shadow-sm hover:shadow-md transition-all">
                    <div class="aspect-[16/9] overflow-hidden">
                        <img src="<?= htmlspecialchars($rel['image'] ?? '') ?>" alt="<?= htmlspecialchars($rel['title'] ?? '') ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-5">
                        <span class="bg-[#EFF4EF] text-primary px-2.5 py-0.5 rounded text-[11px] font-medium inline-block mb-2">
                            <?= htmlspecialchars($rel['category'] ?? 'Insight') ?>
                        </span>
                        <h3 class="font-manrope font-bold text-on-surface group-hover:text-primary transition-colors text-base line-clamp-2 mb-2">
                            <?= htmlspecialchars($rel['title'] ?? '') ?>
                        </h3>
                        <p class="font-inter text-xs text-on-surface-variant line-clamp-2">
                            <?= htmlspecialchars($rel['excerpt'] ?? '') ?>
                        </p>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>
