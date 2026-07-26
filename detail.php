<?php
require_once 'includes/products.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get product ID or default to 1 (Kalingga)
$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;
if (!isset($products[$id])) {
    $id = 1;
}

$product = $products[$id];

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
    // Redirect to same detail page to prevent resubmission
    header('Location: detail.php?id=' . $productId . '&added=true');
    exit;
}

require_once 'includes/header.php';
?>

<main class="py-12 bg-background">
    <div class="px-margin-mobile md:px-margin-desktop max-w-max-container mx-auto w-full flex flex-col gap-12">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-label-sm text-outline">
            <a class="hover:text-primary transition-colors" href="index.php">Home</a>
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            <a class="hover:text-primary transition-colors" href="catalog.php">Products</a>
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            <a class="hover:text-primary transition-colors" href="catalog.php?category=<?= urlencode($product['category']) ?>"><?= htmlspecialchars($product['category']) ?></a>
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            <span class="text-primary font-medium"><?= htmlspecialchars($product['name']) ?></span>
        </nav>

        <?php if (isset($_GET['added'])): ?>
        <!-- Success Alert -->
        <div class="bg-[#EFF4EF] border border-primary/20 text-primary px-6 py-4 rounded-xl flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined icon-fill text-[24px]">check_circle</span>
                <span class="font-medium text-sm">Produk berhasil ditambahkan ke Inquiry Cart!</span>
            </div>
            <a href="cart.php" class="bg-primary text-on-primary font-manrope font-bold text-label-sm px-4 py-2 rounded-lg hover:opacity-90 transition-opacity">
                Lihat Keranjang
            </a>
        </div>
        <?php endif; ?>

        <!-- Product Gallery & Buy Box -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <!-- Left: Images -->
            <div class="lg:col-span-6 flex flex-col gap-6">
                <!-- Large Image Display -->
                <div class="aspect-square bg-surface-container-low rounded-2xl border border-outline-variant/60 flex items-center justify-center p-12 overflow-hidden shadow-sm relative">
                    <img id="main-display" alt="<?= htmlspecialchars($product['name']) ?>" class="max-w-full max-h-full object-contain transition-all duration-300" src="<?= htmlspecialchars($product['image']) ?>">
                </div>
                <!-- Thumbnails -->
                <div class="grid grid-cols-4 gap-4">
                    <button onclick="setMainImage('<?= htmlspecialchars($product['image']) ?>')" class="aspect-square rounded-xl border-2 border-primary bg-surface-container-lowest flex items-center justify-center p-3 overflow-hidden shadow-sm hover:opacity-90 transition-all thumbnail-btn">
                        <img alt="thumbnail" class="max-w-full max-h-full object-contain" src="<?= htmlspecialchars($product['image']) ?>">
                    </button>
                    <button onclick="setMainImage('gambar/image_from_https_images.unsplash.com_photo_1691767247958_5c0d1505ac79_auto/screen.png')" class="aspect-square rounded-xl border border-outline-variant bg-surface-container-lowest flex items-center justify-center p-3 overflow-hidden shadow-sm hover:opacity-90 transition-all thumbnail-btn">
                        <img alt="thumbnail" class="max-w-full max-h-full object-contain" src="gambar/image_from_https_images.unsplash.com_photo_1691767247958_5c0d1505ac79_auto/screen.png">
                    </button>
                    <button onclick="setMainImage('gambar/image_from_https_images.unsplash.com_photo_1651478211539_0728e04a7e5c_auto/screen.png')" class="aspect-square rounded-xl border border-outline-variant bg-surface-container-lowest flex items-center justify-center p-3 overflow-hidden shadow-sm hover:opacity-90 transition-all thumbnail-btn">
                        <img alt="thumbnail" class="max-w-full max-h-full object-contain" src="gambar/image_from_https_images.unsplash.com_photo_1651478211539_0728e04a7e5c_auto/screen.png">
                    </button>
                    <button onclick="setMainImage('gambar/image_from_https_images.unsplash.com_photo_1593463897552_69da7e8343eb_auto/screen.png')" class="aspect-square rounded-xl border border-outline-variant bg-surface-container-lowest flex items-center justify-center p-3 overflow-hidden shadow-sm hover:opacity-90 transition-all thumbnail-btn">
                        <img alt="thumbnail" class="max-w-full max-h-full object-contain" src="gambar/image_from_https_images.unsplash.com_photo_1593463897552_69da7e8343eb_auto/screen.png">
                    </button>
                </div>
            </div>

            <!-- Right: Order Box -->
            <div class="lg:col-span-6 flex flex-col gap-6 justify-between py-2">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <?php if (!empty($product['badge'])): ?>
                        <span class="bg-secondary-container text-on-secondary-container px-3 py-1 rounded-full font-label-sm font-bold text-xs shadow-sm">
                            <?= htmlspecialchars($product['badge']) ?>
                        </span>
                        <?php endif; ?>
                        <span class="bg-[#EFF4EF] text-primary px-3 py-1 rounded-full font-inter font-medium text-xs">
                            <?= htmlspecialchars($product['category']) ?>
                        </span>
                    </div>
                    <h1 class="font-manrope text-display-lg-mobile md:text-headline-lg font-bold text-primary mb-4 leading-tight">
                        <?= htmlspecialchars($product['name']) ?>
                    </h1>
                    <p class="font-inter text-body-lg text-on-surface-variant leading-relaxed mb-4">
                        <?= htmlspecialchars($product['description']) ?>
                    </p>
                    <div class="text-primary font-manrope font-bold text-3xl mb-6"><?= format_rupiah($product['price']) ?></div>
                    
                    <div class="bg-surface-container-low p-5 rounded-xl border border-outline-variant/40 flex flex-col gap-3 mb-6">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-on-surface-variant font-medium">Bahan Aktif / Spesifikasi</span>
                            <span class="text-primary font-bold"><?= htmlspecialchars($product['sub_category']) ?></span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-on-surface-variant font-medium">Rekomendasi Tanaman</span>
                            <span class="text-on-surface font-semibold text-right"><?= htmlspecialchars($product['crop_target']) ?></span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-on-surface-variant font-medium">Dosis Aplikasi</span>
                            <span class="text-on-surface font-semibold"><?= htmlspecialchars($product['dosage']) ?></span>
                        </div>
                    </div>
                </div>

                <form method="POST" action="detail.php?id=<?= $id ?>" class="flex flex-col gap-4 bg-surface-container-lowest p-6 rounded-xl border border-outline-variant/60 shadow-sm">
                    <input type="hidden" name="action" value="add_to_cart">
                    <input type="hidden" name="product_id" value="<?= $id ?>">
                    
                    <div class="flex items-center justify-between gap-4">
                        <span class="font-manrope font-bold text-primary text-body-lg">Jumlah Inquiry</span>
                        <div class="flex items-center border border-outline-variant rounded-lg overflow-hidden bg-surface">
                            <button type="button" onclick="decrementQty()" class="px-3 py-2 text-on-surface-variant hover:bg-surface-container-high transition-colors font-bold">-</button>
                            <input id="qty-input" type="number" name="qty" value="1" min="1" class="w-12 text-center border-0 bg-transparent text-on-surface font-bold p-0 focus:ring-0 focus:outline-none"/>
                            <button type="button" onclick="incrementQty()" class="px-3 py-2 text-on-surface-variant hover:bg-surface-container-high transition-colors font-bold">+</button>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-primary text-on-primary font-manrope font-bold text-label-md py-4 rounded-lg hover:opacity-90 transition-opacity flex items-center justify-center gap-3 shadow-md mt-2">
                        <span class="material-symbols-outlined text-[24px]">add_shopping_cart</span> Add to Inquiry Cart
                    </button>
                </form>
            </div>
        </div>

        <!-- Tabbed Information -->
        <section class="bg-surface-container-lowest rounded-2xl border border-outline-variant/60 p-8 shadow-sm flex flex-col gap-6">
            <div class="border-b border-outline-variant pb-4 flex gap-8">
                <button id="btn-desc" onclick="switchTab('desc')" class="font-manrope font-bold text-primary border-b-2 border-primary pb-4 -mb-5 text-body-lg focus:outline-none transition-all duration-200">Deskripsi Detail</button>
                <button id="btn-benefits" onclick="switchTab('benefits')" class="font-manrope font-medium text-on-surface-variant hover:text-primary pb-4 -mb-5 text-body-lg focus:outline-none transition-all duration-200">Manfaat Utama</button>
            </div>
            
            <div class="pt-4">
                <div id="tab-desc" class="transition-all duration-300">
                    <p class="font-inter text-body-md text-on-surface-variant leading-relaxed">
                        <?= nl2br(htmlspecialchars($product['full_description'])) ?>
                    </p>
                </div>
                <div id="tab-benefits" class="hidden transition-all duration-300">
                    <h3 class="font-manrope font-bold text-primary text-body-lg mb-4">Manfaat Utama</h3>
                    <ul class="space-y-3">
                        <?php foreach ($product['benefits'] as $benefit): ?>
                        <li class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-primary mt-0.5 text-[20px] font-bold">check</span>
                            <span class="font-inter text-body-md text-on-surface-variant text-sm"><?= htmlspecialchars($benefit) ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Related Products -->
        <section class="flex flex-col gap-6">
            <h2 class="font-manrope font-bold text-headline-lg text-primary">Solusi Terkait</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
                <?php 
                $counter = 0;
                foreach ($products as $pId => $p): 
                    if ($pId === $id) continue;
                    if ($counter >= 3) break;
                    $counter++;
                ?>
                <!-- Related Product Card -->
                <div class="bg-surface rounded-xl border border-outline-variant/50 overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between">
                    <div class="aspect-square bg-surface-container-low p-6 flex items-center justify-center relative overflow-hidden">
                        <a href="detail.php?id=<?= $pId ?>" class="w-full h-full flex items-center justify-center">
                            <img alt="<?= htmlspecialchars($p['name']) ?>" class="max-w-full max-h-full object-contain" src="<?= htmlspecialchars($p['image']) ?>">
                        </a>
                    </div>
                    <div class="p-6">
                        <h3 class="font-manrope text-body-lg font-bold text-on-surface mb-1">
                            <a href="detail.php?id=<?= $pId ?>" class="hover:text-primary transition-colors"><?= htmlspecialchars($p['name']) ?></a>
                        </h3>
                        <p class="font-inter text-body-md text-on-surface-variant text-sm line-clamp-2"><?= htmlspecialchars($p['description']) ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
</main>

<script>
function switchTab(tabName) {
    const tabDesc = document.getElementById('tab-desc');
    const tabBenefits = document.getElementById('tab-benefits');
    const btnDesc = document.getElementById('btn-desc');
    const btnBenefits = document.getElementById('btn-benefits');
    
    if (tabName === 'desc') {
        tabDesc.classList.remove('hidden');
        tabBenefits.classList.add('hidden');
        
        btnDesc.classList.add('font-bold', 'text-primary', 'border-b-2', 'border-primary');
        btnDesc.classList.remove('font-medium', 'text-on-surface-variant');
        
        btnBenefits.classList.remove('font-bold', 'text-primary', 'border-b-2', 'border-primary');
        btnBenefits.classList.add('font-medium', 'text-on-surface-variant');
    } else {
        tabDesc.classList.add('hidden');
        tabBenefits.classList.remove('hidden');
        
        btnDesc.classList.remove('font-bold', 'text-primary', 'border-b-2', 'border-primary');
        btnDesc.classList.add('font-medium', 'text-on-surface-variant');
        
        btnBenefits.classList.add('font-bold', 'text-primary', 'border-b-2', 'border-primary');
        btnBenefits.classList.remove('font-medium', 'text-on-surface-variant');
    }
}

function setMainImage(src) {
    document.getElementById('main-display').src = src;
    
    // Toggle active border styling on thumbnail buttons
    const buttons = document.querySelectorAll('.thumbnail-btn');
    buttons.forEach(btn => {
        const img = btn.querySelector('img');
        if (img.getAttribute('src') === src) {
            btn.classList.add('border-primary');
            btn.classList.remove('border-outline-variant');
        } else {
            btn.classList.remove('border-primary');
            btn.classList.add('border-outline-variant');
        }
    });
}

function incrementQty() {
    const input = document.getElementById('qty-input');
    input.value = parseInt(input.value) + 1;
}

function decrementQty() {
    const input = document.getElementById('qty-input');
    const val = parseInt(input.value);
    if (val > 1) {
        input.value = val - 1;
    }
}
</script>

<?php require_once 'includes/footer.php'; ?>
