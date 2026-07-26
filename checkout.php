<?php
require_once 'includes/products.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// If cart is empty, redirect to catalog
if (empty($_SESSION['cart'])) {
    header('Location: catalog.php');
    exit;
}

$settingsJsonPath = __DIR__ . '/admin/data/settings.json';
$whatsapp_phone = '6281123456789'; // Target WhatsApp number (without +)
if (file_exists($settingsJsonPath)) {
    $st = json_decode(file_get_contents($settingsJsonPath), true);
    if (!empty($st['whatsapp_number'])) {
        $whatsapp_phone = preg_replace('/[^0-9]/', '', $st['whatsapp_number']);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $wa_number = trim($_POST['wa']);
    $lokasi = trim($_POST['lokasi']);
    $catatan = trim($_POST['catatan']);
    
    if (empty($nama) || empty($wa_number) || empty($lokasi)) {
        $error = 'Harap isi semua kolom wajib (Nama, WhatsApp, Lokasi).';
    } else {
        // Construct the WhatsApp message text
        $msg = "Halo Sarana Pertanian, saya ingin mengajukan inquiry untuk produk berikut:\n\n";
        
        $item_list = "";
        $idx = 1;
        $totalCart = 0;
        foreach ($_SESSION['cart'] as $productId => $qty) {
            if (isset($products[$productId])) {
                $p = $products[$productId];
                $subtotal = $p['price'] * $qty;
                $totalCart += $subtotal;
                $price_fmt = format_rupiah($p['price']);
                $sub_fmt = format_rupiah($subtotal);
                $item_list .= "{$idx}. {$p['name']} - Qty: {$qty} x {$price_fmt} = {$sub_fmt}\n";
                $idx++;
            }
        }
        
        $msg .= $item_list;
        $msg .= "\n*Total Estimasi:* " . format_rupiah($totalCart) . "\n\n";
        $msg .= "*Detail Pemesan:*\n";
        $msg .= "• Nama: {$nama}\n";
        $msg .= "• No. WA Pemesan: {$wa_number}\n";
        $msg .= "• Lokasi / Alamat: {$lokasi}\n";
        if (!empty($catatan)) {
            $msg .= "• Catatan Tambahan: {$catatan}\n";
        }
        
        // Clear the cart
        unset($_SESSION['cart']);
        
        // Encode message and redirect
        $wa_url = "https://api.whatsapp.com/send?phone={$whatsapp_phone}&text=" . urlencode($msg);
        header('Location: ' . $wa_url);
        exit;
    }
}

require_once 'includes/header.php';
?>

<main class="py-12 bg-background">
    <div class="px-margin-mobile md:px-margin-desktop max-w-max-container mx-auto w-full flex flex-col gap-8">
        <div>
            <nav class="flex items-center gap-2 text-label-sm text-outline mb-2">
                <a class="hover:text-primary transition-colors" href="index.php">Home</a>
                <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                <a class="hover:text-primary transition-colors" href="cart.php">Inquiry Cart</a>
                <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                <span class="text-primary font-medium">Checkout</span>
            </nav>
            <h1 class="font-manrope font-bold text-headline-lg text-primary">Inquiry Form</h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left Side: Order Form -->
            <div class="lg:col-span-7 flex flex-col gap-6">
                <div class="bg-surface-container-lowest border border-outline-variant/60 rounded-2xl p-8 shadow-sm">
                    <h2 class="font-manrope font-bold text-headline-md text-primary mb-6" style="font-size: 20px;">Detail Kontak &amp; Lokasi</h2>
                    
                    <?php if (!empty($error)): ?>
                    <div class="bg-error-container text-on-error-container px-5 py-3 rounded-lg text-sm mb-6 font-medium">
                        <?= htmlspecialchars($error) ?>
                    </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="checkout.php" class="flex flex-col gap-5">
                        <div class="flex flex-col gap-2">
                            <label for="nama" class="text-label-md text-on-surface font-semibold text-sm">Nama Lengkap / Instansi <span class="text-error">*</span></label>
                            <input id="nama" type="text" name="nama" required placeholder="Contoh: Budi Santoso / PT. Tani Subur" class="w-full rounded-lg border border-outline-variant/80 bg-surface px-4 py-3 text-body-md focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none"/>
                        </div>
                        
                        <div class="flex flex-col gap-2">
                            <label for="wa" class="text-label-md text-on-surface font-semibold text-sm">Nomor WhatsApp Aktif <span class="text-error">*</span></label>
                            <input id="wa" type="tel" name="wa" required placeholder="Contoh: 08123456789" class="w-full rounded-lg border border-outline-variant/80 bg-surface px-4 py-3 text-body-md focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none"/>
                        </div>
                        
                        <div class="flex flex-col gap-2">
                            <label for="lokasi" class="text-label-md text-on-surface font-semibold text-sm">Lokasi Lahan / Alamat Pengiriman <span class="text-error">*</span></label>
                            <input id="lokasi" type="text" name="lokasi" required placeholder="Contoh: Batu, Jawa Timur" class="w-full rounded-lg border border-outline-variant/80 bg-surface px-4 py-3 text-body-md focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none"/>
                        </div>
                        
                        <div class="flex flex-col gap-2">
                            <label for="catatan" class="text-label-md text-on-surface font-semibold text-sm">Catatan Inquiry Tambahan (Opsional)</label>
                            <textarea id="catatan" name="catatan" rows="4" placeholder="Tuliskan spesifikasi khusus, negosiasi volume, atau pertanyaan teknis di sini..." class="w-full rounded-lg border border-outline-variant/80 bg-surface px-4 py-3 text-body-md focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none"></textarea>
                        </div>
                        
                        <button type="submit" class="w-full bg-[#214D36] text-white rounded-xl py-4 flex items-center justify-center gap-2 hover:bg-primary transition-colors duration-200 shadow-md font-bold mt-4">
                            <span class="material-symbols-outlined icon-fill text-[24px]">chat</span> Kirim Inquiry ke WhatsApp
                        </button>
                    </form>
                </div>
            </div>

            <!-- Right Side: Order Summary Checklist -->
            <div class="lg:col-span-5 flex flex-col gap-6 lg:sticky lg:top-28">
                <div class="bg-surface-container-lowest rounded-xl border border-outline-variant/60 shadow-sm overflow-hidden flex flex-col">
                    <!-- Summary Header -->
                    <div class="bg-[#EFF4EF] px-6 py-5 border-b border-surface-variant flex justify-between items-center">
                        <h3 class="font-headline-md text-headline-md text-primary m-0" style="font-size: 18px; line-height: 28px;">Daftar Inquiry</h3>
                        <span class="bg-primary-container text-on-primary text-xs font-bold px-3 py-1 rounded-full">
                            <?= count($_SESSION['cart']) ?> Produk
                        </span>
                    </div>
                    <!-- Items List -->
                    <div class="p-6 flex flex-col gap-4 max-h-[350px] overflow-y-auto">
                        <?php 
                        $totalCart = 0;
                        foreach ($_SESSION['cart'] as $productId => $qty): 
                            if (!isset($products[$productId])) continue;
                            $p = $products[$productId];
                            $subtotal = $p['price'] * $qty;
                            $totalCart += $subtotal;
                        ?>
                        <!-- Item -->
                        <div class="flex items-center gap-4 pb-4 border-b border-outline-variant last:border-0 last:pb-0">
                            <div class="w-14 h-14 rounded-lg bg-surface-container flex items-center justify-center shrink-0 border border-outline-variant overflow-hidden p-1.5">
                                <img class="max-w-full max-h-full object-contain" src="<?= htmlspecialchars($p['image']) ?>"/>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-label-md text-label-md text-on-surface font-bold text-sm truncate"><?= htmlspecialchars($p['name']) ?></h4>
                                <p class="text-xs text-on-surface-variant mt-0.5"><?= format_rupiah($p['price']) ?> × <?= $qty ?></p>
                            </div>
                            <div class="font-label-md text-label-md text-primary bg-surface-container-low px-3 py-1 rounded-md text-xs font-bold whitespace-nowrap">
                                <?= format_rupiah($subtotal) ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <!-- Footer Info -->
                    <div class="bg-surface px-6 py-5 flex flex-col gap-4 border-t border-outline-variant">
                        <div class="flex flex-col gap-2 text-sm border-b border-outline-variant pb-4">
                            <div class="flex justify-between">
                                <span class="text-on-surface-variant font-medium">Subtotal</span>
                                <span class="text-on-surface font-semibold"><?= format_rupiah($totalCart) ?></span>
                            </div>
                            <div class="flex justify-between text-base">
                                <span class="text-primary font-bold">Total Est.</span>
                                <span class="text-primary font-extrabold text-lg"><?= format_rupiah($totalCart) ?></span>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 bg-surface-container-low p-4 rounded-lg">
                            <span class="material-symbols-outlined text-primary mt-0.5">verified_user</span>
                            <p class="text-xs leading-relaxed text-on-surface-variant">
                                Inquiry Anda akan langsung terkirim ke Tim Agronomis kami. Kami akan merespons rincian pengiriman dan penawaran B2B terbaik dalam waktu singkat.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>
