<?php
require_once 'includes/products.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Handle cart updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'update_qty') {
        $productId = (int)$_POST['product_id'];
        $qty = (int)$_POST['qty'];
        if ($qty > 0) {
            $_SESSION['cart'][$productId] = $qty;
        } else {
            unset($_SESSION['cart'][$productId]);
        }
    } elseif ($_POST['action'] === 'remove') {
        $productId = (int)$_POST['product_id'];
        unset($_SESSION['cart'][$productId]);
    }
    
    // Redirect to self to prevent form resubmission
    header('Location: cart.php');
    exit;
}

require_once 'includes/header.php';
?>

<main class="py-12 bg-background">
    <div class="px-margin-mobile md:px-margin-desktop max-w-max-container mx-auto w-full flex flex-col gap-8">
        <div>
            <nav class="flex items-center gap-2 text-label-sm text-outline mb-2">
                <a class="hover:text-primary transition-colors" href="index.php">Home</a>
                <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                <span class="text-primary font-medium">Inquiry Cart</span>
            </nav>
            <h1 class="font-manrope font-bold text-headline-lg text-primary">Keranjang Inquiry</h1>
        </div>

        <?php if (empty($_SESSION['cart'])): ?>
        <!-- Empty Cart State -->
        <div class="bg-surface-container-lowest border border-outline-variant/60 rounded-2xl p-12 text-center max-w-2xl mx-auto my-8 w-full shadow-sm">
            <span class="material-symbols-outlined text-outline text-6xl mb-4">shopping_cart</span>
            <h3 class="font-manrope font-bold text-headline-md text-primary mb-2">Keranjang Anda Kosong</h3>
            <p class="text-on-surface-variant mb-8">Tambahkan beberapa solusi pertanian premium dari katalog kami untuk berkonsultasi.</p>
            <a href="catalog.php" class="bg-primary text-on-primary font-manrope font-bold text-label-md px-8 py-3 rounded-lg hover:opacity-90 transition-opacity inline-block shadow-sm">
                Lihat Katalog Produk
            </a>
        </div>
        <?php else: ?>
        
        <!-- Cart Items Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left Side: Table of Items -->
            <div class="lg:col-span-8 flex flex-col gap-4">
                <div class="bg-surface-container-lowest border border-outline-variant/60 rounded-2xl overflow-hidden shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-[#EFF4EF] text-primary border-b border-outline-variant">
                                    <th class="p-6 font-manrope font-bold text-sm">Produk</th>
                                    <th class="p-6 font-manrope font-bold text-sm text-right">Harga</th>
                                    <th class="p-6 font-manrope font-bold text-sm text-center">Jumlah</th>
                                    <th class="p-6 font-manrope font-bold text-sm text-right">Total</th>
                                    <th class="p-6 font-manrope font-bold text-sm text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $totalCart = 0;
                                foreach ($_SESSION['cart'] as $productId => $qty): 
                                    if (!isset($products[$productId])) continue;
                                    $p = $products[$productId];
                                    $subtotal = $p['price'] * $qty;
                                    $totalCart += $subtotal;
                                ?>
                                <tr class="border-b border-outline-variant last:border-0 hover:bg-surface-container-lowest/50">
                                    <!-- Product Cell -->
                                    <td class="p-6 flex items-center gap-4 min-w-[280px]">
                                        <div class="w-20 h-20 bg-surface-container-low rounded-xl border border-outline-variant/50 flex items-center justify-center p-2 shrink-0 overflow-hidden">
                                            <img alt="<?= htmlspecialchars($p['name']) ?>" class="max-w-full max-h-full object-contain" src="<?= htmlspecialchars($p['image']) ?>">
                                        </div>
                                        <div>
                                            <h4 class="font-manrope font-bold text-body-lg text-primary mb-1 hover:underline">
                                                <a href="detail.php?id=<?= $productId ?>"><?= htmlspecialchars($p['name']) ?></a>
                                            </h4>
                                            <span class="text-xs bg-[#EFF4EF] text-primary px-2.5 py-1 rounded-full font-medium"><?= ucwords(htmlspecialchars($p['category'])) ?></span>
                                        </div>
                                    </td>
                                    
                                    <!-- Price Cell -->
                                    <td class="p-6 text-right font-semibold text-on-surface-variant text-sm">
                                        <?= format_rupiah($p['price']) ?>
                                    </td>
                                    
                                    <!-- Quantity Cell -->
                                    <td class="p-6 text-center">
                                        <form method="POST" action="cart.php" class="inline-flex items-center border border-outline-variant rounded-lg overflow-hidden bg-surface">
                                            <input type="hidden" name="action" value="update_qty">
                                            <input type="hidden" name="product_id" value="<?= $productId ?>">
                                            <button type="submit" name="qty" value="<?= $qty - 1 ?>" class="px-3 py-1.5 text-on-surface-variant hover:bg-surface-container-high font-bold <?= ($qty <= 1) ? 'opacity-50 cursor-not-allowed' : '' ?>" <?= ($qty <= 1) ? 'disabled' : '' ?>>-</button>
                                            <input type="number" readonly value="<?= $qty ?>" class="w-10 text-center border-0 bg-transparent text-sm text-on-surface font-bold p-0 focus:ring-0 focus:outline-none"/>
                                            <button type="submit" name="qty" value="<?= $qty + 1 ?>" class="px-3 py-1.5 text-on-surface-variant hover:bg-surface-container-high font-bold">+</button>
                                        </form>
                                    </td>
                                    
                                    <!-- Subtotal Cell -->
                                    <td class="p-6 text-right font-bold text-primary text-sm">
                                        <?= format_rupiah($subtotal) ?>
                                    </td>
                                    
                                    <!-- Remove Cell -->
                                    <td class="p-6 text-right">
                                        <form method="POST" action="cart.php" class="inline">
                                            <input type="hidden" name="action" value="remove">
                                            <input type="hidden" name="product_id" value="<?= $productId ?>">
                                            <button type="submit" class="text-error hover:text-error/80 flex items-center justify-center ml-auto p-2 hover:bg-red-50 rounded-full transition-colors">
                                                <span class="material-symbols-outlined text-[20px]">delete</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="flex justify-between items-center mt-2">
                    <a href="catalog.php" class="flex items-center gap-2 text-primary hover:text-primary/80 font-manrope font-bold text-label-md">
                        <span class="material-symbols-outlined text-sm">arrow_back</span> Kembali Belanja
                    </a>
                </div>
            </div>
            
            <!-- Right Side: Order Summary Panel -->
            <div class="lg:col-span-4">
                <div class="bg-surface-container-lowest border border-outline-variant/60 rounded-2xl p-6 shadow-sm flex flex-col gap-6 sticky top-28">
                    <h3 class="font-manrope font-bold text-headline-md text-primary mb-2" style="font-size: 20px;">Ringkasan Inquiry</h3>
                    <div class="flex flex-col gap-4 text-sm border-b border-outline-variant pb-6">
                        <div class="flex justify-between">
                            <span class="text-on-surface-variant font-medium">Total Item</span>
                            <span class="text-primary font-bold"><?= count($_SESSION['cart']) ?> Jenis Produk</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-on-surface-variant font-medium">Subtotal</span>
                            <span class="text-on-surface font-semibold"><?= format_rupiah($totalCart) ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-on-surface-variant font-medium">Konsultasi Agronomis</span>
                            <span class="text-primary font-bold">Gratis</span>
                        </div>
                        <hr class="border-outline-variant my-1">
                        <div class="flex justify-between text-base">
                            <span class="text-primary font-bold">Total Est.</span>
                            <span class="text-primary font-extrabold text-lg"><?= format_rupiah($totalCart) ?></span>
                        </div>
                    </div>
                    
                    <div class="bg-surface-container-low p-4 rounded-lg flex items-start gap-3">
                        <span class="material-symbols-outlined text-primary mt-0.5">info</span>
                        <p class="text-xs text-on-surface-variant leading-relaxed">
                            Order ini berupa daftar inquiry. Harga volume khusus dan ongkos kirim kargo akan didiskusikan dengan tim agronomis kami di WhatsApp.
                        </p>
                    </div>

                    <a href="checkout.php" class="w-full bg-primary text-on-primary font-manrope font-bold text-label-md py-4 rounded-xl text-center shadow-md hover:opacity-90 transition-opacity block mt-2">
                        Lanjut ke Inquiry Form
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>
