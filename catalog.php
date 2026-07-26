<?php
require_once 'includes/products.php';

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
    // Redirect to preserve state
    $redirect = 'catalog.php';
    if (!empty($_GET['category'])) {
        $redirect .= '?category=' . urlencode($_GET['category']);
    }
    header('Location: ' . $redirect);
    exit;
}

// Filter products by category if provided
$selectedCategory = isset($_GET['category']) ? $_GET['category'] : '';
$filteredProducts = $products;
if (!empty($selectedCategory)) {
    $filteredProducts = array_filter($products, function($p) use ($selectedCategory) {
        return $p['category'] === $selectedCategory;
    });
}

// Categories list for the sidebar
$categories = [
    'Nutrisi' => 'Nutrisi',
    'Fungisida' => 'Fungisida',
    'Insektisida' => 'Insektisida',
    'Benih Premium' => 'Benih Premium',
    'Alat Pertanian' => 'Alat Pertanian',
    'Sensor & IoT' => 'Sensor & IoT'
];

require_once 'includes/header.php';
?>

<main class="py-12 bg-background">
    <div class="px-margin-mobile md:px-margin-desktop max-w-max-container mx-auto w-full flex flex-col md:flex-row gap-gutter">
        <!-- Sidebar Filters -->
        <aside class="w-full md:w-1/4 shrink-0">
            <div class="bg-surface-container-lowest rounded-xl p-6 border border-surface-variant flex flex-col gap-6 sticky top-28 shadow-sm">
                <div>
                    <h2 class="font-manrope font-bold text-headline-md text-primary mb-2" style="font-size: 20px;">Filters</h2>
                    <p class="text-body-md text-on-surface-variant text-sm">Narrow down your precision farming requirements.</p>
                </div>
                <hr class="border-outline-variant">
                <!-- Categories -->
                <div>
                    <h3 class="font-manrope font-bold text-body-lg text-primary mb-4">Kategori Produk</h3>
                    <div class="flex flex-col gap-3">
                        <a href="catalog.php" class="flex items-center gap-3 cursor-pointer group">
                            <div class="h-5 w-5 rounded border border-outline-variant flex items-center justify-center <?= empty($selectedCategory) ? 'bg-primary border-primary text-white' : 'bg-surface' ?>">
                                <?php if (empty($selectedCategory)): ?>
                                    <span class="material-symbols-outlined text-[14px]" style="font-variation-settings: 'wght' 700;">check</span>
                                <?php endif; ?>
                            </div>
                            <span class="text-body-md <?= empty($selectedCategory) ? 'text-primary font-bold' : 'text-on-surface-variant group-hover:text-primary' ?> transition-colors">Semua Kategori</span>
                        </a>
                        
                        <?php foreach ($categories as $key => $name): ?>
                        <a href="catalog.php?category=<?= urlencode($key) ?>" class="flex items-center gap-3 cursor-pointer group">
                            <div class="h-5 w-5 rounded border border-outline-variant flex items-center justify-center <?= ($selectedCategory === $key) ? 'bg-primary border-primary text-white' : 'bg-surface' ?>">
                                <?php if ($selectedCategory === $key): ?>
                                    <span class="material-symbols-outlined text-[14px]" style="font-variation-settings: 'wght' 700;">check</span>
                                <?php endif; ?>
                            </div>
                            <span class="text-body-md <?= ($selectedCategory === $key) ? 'text-primary font-bold' : 'text-on-surface-variant group-hover:text-primary' ?> transition-colors"><?= htmlspecialchars($name) ?></span>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <hr class="border-outline-variant">
                <!-- Brand Info -->
                <div>
                    <h3 class="font-manrope font-bold text-body-lg text-primary mb-3">Target Crops</h3>
                    <p class="text-sm text-on-surface-variant">Padi, Jagung, Bawang Merah, Kentang, Hortikultura, Tanaman Hias.</p>
                </div>
                <hr class="border-outline-variant">
                <a href="catalog.php" class="w-full py-2.5 border-2 border-primary-container text-primary-container font-manrope font-bold rounded-lg hover:bg-primary-container hover:text-white transition-colors text-center block text-sm">
                    Reset Filters
                </a>
            </div>
        </aside>

        <!-- Main Product Area -->
        <section class="w-full md:w-3/4 flex flex-col gap-6">
            <!-- Header & Controls -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 pb-4 border-b border-outline-variant">
                <div>
                    <nav class="flex items-center gap-2 text-label-sm text-outline mb-2">
                        <a class="hover:text-primary transition-colors" href="index.php">Home</a>
                        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                        <span class="text-primary font-medium">Products</span>
                    </nav>
                    <h1 class="font-manrope font-bold text-headline-lg text-primary">
                        <?= empty($selectedCategory) ? 'Semua Produk' : htmlspecialchars($selectedCategory) ?>
                    </h1>
                </div>
                <div class="flex flex-col sm:flex-row items-center gap-4 w-full md:w-auto">
                    <span class="text-body-md text-on-surface-variant whitespace-nowrap text-sm">Showing <?= count($filteredProducts) ?> of <?= count($products) ?> products</span>
                </div>
            </div>

            <?php if (empty($filteredProducts)): ?>
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-12 text-center my-8">
                <span class="material-symbols-outlined text-outline text-6xl mb-4">search_off</span>
                <h3 class="font-manrope font-bold text-body-lg text-primary mb-2">No Products Found</h3>
                <p class="text-on-surface-variant mb-6">We couldn't find any products matching your selection.</p>
                <a href="catalog.php" class="bg-primary text-on-primary px-6 py-2.5 rounded-lg hover:opacity-90 font-medium">View All Products</a>
            </div>
            <?php else: ?>
            <!-- Product Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($filteredProducts as $id => $product): ?>
                <!-- Product Card -->
                <div class="bg-surface-container-lowest rounded-[16px] shadow-sm overflow-hidden group hover:-translate-y-1 transition-transform duration-300 flex flex-col border border-surface-variant justify-between relative">
                    <?php if (!empty($product['badge'])): ?>
                    <div class="absolute top-3 left-3 bg-secondary-container text-on-secondary-container px-2.5 py-1 rounded font-label-sm z-10 font-bold shadow-sm">
                        <?= htmlspecialchars($product['badge']) ?>
                    </div>
                    <?php endif; ?>
                    <div class="aspect-square bg-surface-container p-6 flex items-center justify-center relative overflow-hidden">
                        <a href="detail.php?id=<?= $id ?>" class="w-full h-full flex items-center justify-center">
                            <img alt="<?= htmlspecialchars($product['name']) ?>" class="object-contain max-w-full max-h-full mix-blend-multiply group-hover:scale-105 transition-transform duration-500" src="<?= htmlspecialchars($product['image']) ?>">
                        </a>
                    </div>
                    <div class="p-5 flex flex-col flex-grow justify-between">
                        <div>
                            <span class="text-label-sm font-semibold text-surface-tint uppercase tracking-wider mb-1 block"><?= htmlspecialchars($product['sub_category']) ?></span>
                            <h3 class="font-manrope font-bold text-body-lg text-on-surface mb-2 leading-tight hover:text-primary transition-colors">
                                <a href="detail.php?id=<?= $id ?>"><?= htmlspecialchars($product['name']) ?></a>
                            </h3>
                            <p class="text-body-md text-on-surface-variant line-clamp-2 mb-3 text-sm flex-grow"><?= htmlspecialchars($product['description']) ?></p>
                            <div class="text-primary font-manrope font-bold text-body-lg mb-4"><?= format_rupiah($product['price']) ?></div>
                        </div>
                        <form method="POST" action="catalog.php?<?= !empty($selectedCategory) ? 'category='.urlencode($selectedCategory) : '' ?>">
                            <input type="hidden" name="action" value="add_to_cart">
                            <input type="hidden" name="product_id" value="<?= $id ?>">
                            <button type="submit" class="w-full bg-primary-container text-on-primary font-manrope font-bold text-label-md py-2.5 rounded-lg hover:opacity-90 transition-opacity flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-[20px]">add_shopping_cart</span> Add to Inquiry
                            </button>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </section>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>
