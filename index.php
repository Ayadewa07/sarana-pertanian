<?php
require_once 'includes/products.php';

// Load articles from JSON
$articlesJsonPath = __DIR__ . '/admin/data/articles.json';
$articles = [];
if (file_exists($articlesJsonPath)) {
    $articles = json_decode(file_get_contents($articlesJsonPath), true) ?: [];
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Handle Add to Inquiry form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_to_cart') {
    $productId = (int)$_POST['product_id'];
    $qty = isset($_POST['qty']) ? (int)$_POST['qty'] : 1;
    if (isset($products[$productId])) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId] += $qty;
        } else {
            $_SESSION['cart'][$productId] = $qty;
        }
    }
    // Redirect to same page to prevent resubmission
    header('Location: index.php');
    exit;
}

require_once 'includes/header.php';
?>

<!-- Main Content -->
<main>
    <!-- 1. Hero Section -->
    <section class="relative w-full h-[80vh] min-h-[600px] flex items-center bg-surface-container-high overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center w-full h-full opacity-40" 
             style="background-image: url('gambar/image_from_https_images.unsplash.com_photo_1579893538973_f5e18745c8f7_auto/screen.png')"></div>
        <div class="relative z-10 w-full px-margin-mobile md:px-margin-desktop max-w-max-container mx-auto">
            <div class="max-w-2xl bg-surface/80 backdrop-blur-md p-8 md:p-12 rounded-xl shadow-lg border border-outline-variant/30">
                <h1 class="font-manrope text-display-lg-mobile md:text-display-lg font-bold text-primary mb-stack-md leading-tight">
                    Yield Certainty through Precision Stewardship
                </h1>
                <p class="font-inter text-body-lg text-on-surface-variant mb-stack-lg">
                    The official distributor for Indonesia's most trusted agricultural brands. Elevating harvest potential with science-backed solutions.
                </p>
                <div class="flex flex-col sm:flex-row gap-stack-md">
                    <a href="catalog.php" class="bg-primary-container text-on-primary font-manrope font-label-md text-label-md px-8 py-3.5 rounded-lg hover:opacity-90 transition-opacity w-full sm:w-auto text-center">
                        Explore Catalog
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. Trusted Partners -->
    <section class="py-12 border-b border-surface-variant bg-surface-container-lowest">
        <div class="px-margin-mobile md:px-margin-desktop max-w-max-container mx-auto">
            <p class="text-center font-inter text-label-sm text-on-surface-variant uppercase tracking-wider mb-8">Trusted by Industry Leaders</p>
            <div class="flex flex-wrap justify-center items-center gap-12 opacity-60 grayscale hover:grayscale-0 transition-all duration-500">
                <span class="material-symbols-outlined text-4xl">agriculture</span>
                <span class="material-symbols-outlined text-4xl">eco</span>
                <span class="material-symbols-outlined text-4xl">science</span>
                <span class="material-symbols-outlined text-4xl">compost</span>
                <span class="material-symbols-outlined text-4xl">local_florist</span>
            </div>
        </div>
    </section>

    <!-- 4. Featured Products -->
    <section class="py-section-padding px-margin-mobile md:px-margin-desktop max-w-max-container mx-auto bg-surface-container-lowest">
        <div class="flex justify-between items-end mb-12">
            <div>
                <h2 class="font-manrope text-headline-lg font-bold text-primary mb-2">Premium Solutions</h2>
                <p class="font-inter text-body-md text-on-surface-variant">Engineered for maximum efficacy and yield protection.</p>
            </div>
            <a class="hidden md:flex items-center gap-2 font-inter text-label-md text-primary hover:text-surface-tint transition-colors" href="catalog.php">
                View Full Catalog <span class="material-symbols-outlined text-sm">arrow_forward</span>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
            <?php 
            // Display first 3 products as featured
            $featuredProducts = array_slice($products, 0, 3, true);
            foreach ($featuredProducts as $id => $product): 
            ?>
            <!-- Product Card -->
            <div class="bg-surface rounded-xl border border-outline-variant/50 overflow-hidden shadow-[0_4px_20px_rgba(0,0,0,0.05)] group hover:shadow-[0_12px_40px_rgba(23,54,36,0.08)] transition-all duration-300 flex flex-col justify-between">
                <div class="aspect-square bg-surface-container-low relative overflow-hidden flex items-center justify-center p-6">
                    <a href="detail.php?id=<?= $id ?>" class="w-full h-full flex items-center justify-center">
                        <img alt="<?= htmlspecialchars($product['name']) ?>" class="max-w-full max-h-full object-contain group-hover:scale-105 transition-transform duration-500" src="<?= htmlspecialchars($product['image']) ?>">
                    </a>
                    <?php if (!empty($product['tag'])): ?>
                    <div class="absolute top-4 left-4 bg-[#EFF4EF] text-primary px-3 py-1 rounded-full font-inter text-label-sm"><?= htmlspecialchars($product['tag']) ?></div>
                    <?php endif; ?>
                </div>
                <div class="p-6 flex-grow flex flex-col justify-between">
                    <div>
                        <h3 class="font-manrope text-headline-md font-bold text-on-surface mb-1 hover:text-primary transition-colors">
                            <a href="detail.php?id=<?= $id ?>"><?= htmlspecialchars($product['name']) ?></a>
                        </h3>
                        <p class="font-inter text-body-md text-on-surface-variant mb-4"><?= htmlspecialchars($product['description']) ?></p>
                        <div class="text-primary font-manrope font-bold text-headline-md mb-6"><?= format_rupiah($product['price']) ?></div>
                    </div>
                    <form method="POST" action="index.php">
                        <input type="hidden" name="action" value="add_to_cart">
                        <input type="hidden" name="product_id" value="<?= $id ?>">
                        <button type="submit" class="w-full border border-primary text-primary font-manrope font-label-md text-label-md px-4 py-2.5 rounded-lg hover:bg-primary-container hover:text-on-primary transition-colors flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-sm">add_shopping_cart</span> Add to Inquiry
                        </button>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- 5. About Company -->
    <section class="py-section-padding bg-[#F8F6F2]" id="about">
        <div class="px-margin-mobile md:px-margin-desktop max-w-max-container mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="relative rounded-2xl overflow-hidden aspect-[4/5] shadow-[0_12px_40px_rgba(23,54,36,0.08)]">
                    <img alt="Agricultural Field" class="w-full h-full object-cover" src="gambar/image_from_https_images.unsplash.com_photo_1593463897552_69da7e8343eb_auto/screen.png">
                    <div class="absolute inset-0 bg-primary/10 mix-blend-multiply"></div>
                </div>
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-px w-8 bg-primary"></div>
                        <span class="font-inter text-label-sm uppercase tracking-widest text-primary">Corporate Heritage</span>
                    </div>
                    <h2 class="font-manrope text-display-lg-mobile md:text-display-lg font-bold text-on-surface mb-6 leading-tight">
                        Deep Roots, <br><span class="text-primary">Future Focused</span>
                    </h2>
                    <p class="font-inter text-body-lg text-on-surface-variant mb-6 leading-relaxed">
                        Serving as the vital bridge between nature's potential and scientific rigor. We supply industrial-scale operations with the precise chemical and biological tools required to guarantee yield certainty in a volatile climate.
                    </p>
                    <p class="font-inter text-body-lg text-on-surface-variant mb-10 leading-relaxed">
                        Our stewardship ensures that every input is optimized for maximum output, minimizing ecological impact while maximizing economic return.
                    </p>
                    <a href="about.php" class="inline-block border border-primary text-primary font-manrope font-label-md text-label-md px-8 py-3 rounded-lg hover:bg-primary-container hover:text-on-primary transition-colors">
                        Discover Our Methodology
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- 8. Latest Articles -->
    <section class="py-section-padding bg-surface-container-lowest" id="articles">
        <div class="px-margin-mobile md:px-margin-desktop max-w-max-container mx-auto">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h2 class="font-manrope text-headline-lg font-bold text-primary mb-4">Agronomic Insights</h2>
                <p class="font-inter text-body-lg text-on-surface-variant">Data-driven strategies and technical updates for modern agricultural operations.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php 
                // Use JSON articles if available, otherwise fallback
                $displayArticles = !empty($articles) ? $articles : [
                    ['id' => 1, 'title' => 'Optimizing Nitrogen Retention in Volcanic Soils', 'category' => 'Research', 'date' => '2024-10-12', 'excerpt' => 'New studies reveal the impact of targeted biostimulants on nutrient uptake efficiency.', 'image' => 'gambar/image_from_https_images.unsplash.com_photo_1668491028217_2ba01ec8b0bf_auto/screen.png'],
                    ['id' => 2, 'title' => 'Drone-Assisted Canopy Mapping for Fungicide Application', 'category' => 'Technology', 'date' => '2024-10-05', 'excerpt' => 'Reducing input costs through variable-rate precision spraying based on real-time data.', 'image' => 'gambar/image_from_https_images.unsplash.com_photo_1651478211539_0728e04a7e5c_auto/screen.png'],
                    ['id' => 3, 'title' => 'Forecasting Commodity Pressures in Q4', 'category' => 'Market Analysis', 'date' => '2024-09-28', 'excerpt' => 'Strategic procurement advice for large-scale operators navigating global supply chain shifts.', 'image' => 'gambar/image_from_https_images.unsplash.com_photo_1690292885661_3818e5fe9067_auto/screen.png']
                ];
                foreach ($displayArticles as $article): 
                    $dateFormatted = date('M d, Y', strtotime($article['date']));
                    $artId = $article['id'] ?? 1;
                ?>
                <div onclick="openArticleModal(<?= $artId ?>)" class="group block cursor-pointer">
                    <article class="h-full flex flex-col justify-between p-4 rounded-2xl hover:bg-surface-container-low transition-colors duration-300">
                        <div>
                            <div class="rounded-xl overflow-hidden aspect-[4/3] mb-6 relative">
                                <img alt="<?= htmlspecialchars($article['title']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" src="<?= htmlspecialchars($article['image']) ?>">
                            </div>
                            <div class="flex items-center gap-4 text-label-sm text-on-surface-variant mb-3">
                                <span class="bg-[#EFF4EF] text-primary px-2.5 py-1 rounded font-medium"><?= htmlspecialchars($article['category']) ?></span>
                                <span class=""><?= $dateFormatted ?></span>
                            </div>
                            <h3 class="font-manrope text-headline-md font-bold text-on-surface mb-2 group-hover:text-primary transition-colors"><?= htmlspecialchars($article['title']) ?></h3>
                            <p class="font-inter text-body-md text-on-surface-variant line-clamp-2"><?= htmlspecialchars($article['excerpt']) ?></p>
                        </div>
                        <div class="mt-4 flex items-center gap-2 text-primary font-manrope font-semibold text-sm group-hover:translate-x-1 transition-transform">
                            <span>Baca Artikel</span>
                            <span class="material-symbols-outlined text-base">arrow_forward</span>
                        </div>
                    </article>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Article Popup Modal -->
    <div id="article-modal" onclick="if(event.target === this) closeArticleModal()" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 sm:p-6 bg-black/70 backdrop-blur-sm transition-opacity duration-300">
        <div class="bg-surface-container-lowest text-on-surface rounded-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto shadow-2xl border border-outline-variant/40 p-6 md:p-8 relative">
            <!-- Close Button -->
            <button onclick="closeArticleModal()" class="absolute top-4 right-4 text-on-surface-variant hover:text-primary p-2 rounded-full hover:bg-surface transition-colors">
                <span class="material-symbols-outlined text-2xl">close</span>
            </button>

            <div class="flex items-center gap-3 text-xs text-on-surface-variant mb-3">
                <span id="modal-category" class="bg-[#EFF4EF] text-primary px-2.5 py-1 rounded font-medium"></span>
                <span id="modal-date"></span>
            </div>

            <h2 id="modal-title" class="font-manrope text-2xl md:text-3xl font-bold text-primary mb-4 leading-tight"></h2>

            <div id="modal-image-container" class="rounded-xl overflow-hidden aspect-[16/9] mb-6 hidden border border-outline-variant/30">
                <img id="modal-image" src="" alt="" class="w-full h-full object-cover">
            </div>

            <div id="modal-excerpt" class="font-inter text-body-md text-on-surface-variant italic mb-6 border-l-4 border-primary pl-4 py-1.5 bg-surface-container-low/50 rounded-r-lg"></div>

            <div id="modal-content" class="font-inter text-body-md text-on-surface space-y-4 leading-relaxed"></div>

            <div class="mt-8 pt-4 border-t border-outline-variant/40 flex items-center justify-between gap-4">
                <a id="modal-full-link" href="#" class="inline-flex items-center gap-1.5 text-primary text-sm font-semibold hover:underline">
                    <span>Buka Halaman Penuh</span>
                    <span class="material-symbols-outlined text-base">open_in_new</span>
                </a>
                <button onclick="closeArticleModal()" class="bg-primary text-on-primary font-manrope font-semibold px-6 py-2.5 rounded-xl text-sm hover:opacity-90 transition-opacity">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <script>
    const articlesData = <?= json_encode($displayArticles, JSON_UNESCAPED_UNICODE) ?>;

    function openArticleModal(articleId) {
        const article = articlesData.find(a => (a.id == articleId)) || articlesData[0];
        if (!article) return;

        document.getElementById('modal-title').textContent = article.title || '';
        document.getElementById('modal-category').textContent = article.category || 'Insight';
        
        let dateStr = article.date || '';
        if (dateStr) {
            try {
                const d = new Date(dateStr);
                dateStr = d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
            } catch(e) {}
        }
        document.getElementById('modal-date').textContent = dateStr;
        document.getElementById('modal-excerpt').textContent = article.excerpt || '';

        // Formatted Content
        const contentEl = document.getElementById('modal-content');
        const text = article.content || article.excerpt || '';
        const paragraphs = text.split("\n\n");
        contentEl.innerHTML = paragraphs.map(p => `<p class="leading-relaxed">${escapeHtml(p.trim())}</p>`).join('');

        // Image
        const imgContainer = document.getElementById('modal-image-container');
        const imgEl = document.getElementById('modal-image');
        if (article.image) {
            imgEl.src = article.image;
            imgContainer.classList.remove('hidden');
        } else {
            imgContainer.classList.add('hidden');
        }

        // Full Link
        document.getElementById('modal-full-link').href = `article-detail.php?id=${article.id}`;

        // Show Modal
        const modal = document.getElementById('article-modal');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeArticleModal() {
        const modal = document.getElementById('article-modal');
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    </script>
</main>

<?php require_once 'includes/footer.php'; ?>
