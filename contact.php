<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$success_msg = '';

// Load contact info from JSON
$contactJsonPath = __DIR__ . '/admin/data/contact.json';
$contactInfo = null;
if (file_exists($contactJsonPath)) {
    $contactInfo = json_decode(file_get_contents($contactJsonPath), true);
}
if (!$contactInfo) {
    $contactInfo = [
        'address' => 'Jl. Agrikultur Premium No. 12, Batu, Jawa Timur 65311',
        'whatsapp' => '6281123456789',
        'whatsapp_display' => '+62 811-2345-6789',
        'email' => 'inquiry@saranapertanian.co.id'
    ];
}

// Load FAQ from JSON
$faqJsonPath = __DIR__ . '/admin/data/faq.json';
$faqItems = null;
if (file_exists($faqJsonPath)) {
    $faqItems = json_decode(file_get_contents($faqJsonPath), true);
}
if (!$faqItems) {
    $faqItems = [
        ['id' => 1, 'question' => 'Bagaimana cara memesan produk di Sarana Pertanian?', 'answer' => 'Anda dapat memilih produk melalui katalog digital kami, menambahkannya ke Keranjang Inquiry, dan mengisi formulir checkout.'],
        ['id' => 2, 'question' => 'Apakah ada minimal pembelian untuk pemesanan B2B?', 'answer' => 'Sebagai distributor resmi skala komersial, kami melayani pemesanan volume besar. Hubungi agronomis kami untuk diskusi lebih lanjut.'],
        ['id' => 3, 'question' => 'Apakah produk yang disediakan dijamin keasliannya?', 'answer' => 'Ya, 100% dijamin asli. Sarana Pertanian adalah distributor resmi terdaftar untuk merek-merek terkemuka di Indonesia.']
    ];
}

// Handle form submission - save message to JSON
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'send_message') {
    $messagesPath = __DIR__ . '/admin/data/messages.json';
    $messages = [];
    if (file_exists($messagesPath)) {
        $messages = json_decode(file_get_contents($messagesPath), true) ?: [];
    }
    
    $maxId = 0;
    foreach ($messages as $m) {
        if (isset($m['id']) && $m['id'] > $maxId) $maxId = $m['id'];
    }
    
    $messages[] = [
        'id' => $maxId + 1,
        'nama' => trim($_POST['nama'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'subjek' => trim($_POST['subjek'] ?? ''),
        'pesan' => trim($_POST['pesan'] ?? ''),
        'created_at' => date('Y-m-d H:i:s'),
        'read' => false
    ];
    
    // Ensure directory exists
    $dir = dirname($messagesPath);
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    
    file_put_contents($messagesPath, json_encode($messages, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    $success_msg = 'Pesan Anda berhasil dikirim! Tim agronomis kami akan segera menghubungi Anda.';
}

require_once 'includes/header.php';
?>

<main>
    <!-- Hero Section -->
    <section class="relative w-full h-[400px] md:h-[500px] flex items-center justify-center bg-surface-container-high overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-primary/90 to-primary/40 z-10"></div>
        <div class="absolute inset-0 bg-cover bg-center z-0" style="background-image: url('gambar/image_from_https_images.unsplash.com_photo_1690292885661_auto/screen.png')"></div>
        <div class="relative z-20 text-center px-margin-mobile md:px-margin-desktop max-w-3xl mx-auto mt-12">
            <h1 class="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg text-white mb-stack-md">
                Hubungi Tim Agronomi Kami
            </h1>
            <p class="font-body-lg text-body-lg text-inverse-on-surface/90">
                Kemitraan strategis untuk hasil panen optimal. Konsultasikan kebutuhan industri pertanian Anda dengan ahli kami.
            </p>
        </div>
    </section>

    <!-- Contact Grid & Form Section -->
    <section class="py-section-padding px-margin-mobile md:px-margin-desktop max-w-max-container mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-gutter">
            <!-- Contact Information (Left Col) -->
            <div class="lg:col-span-5 flex flex-col gap-8">
                <div>
                    <h2 class="font-headline-lg text-headline-lg text-primary mb-stack-sm">Informasi Institusi</h2>
                    <p class="font-body-md text-body-md text-on-surface-variant">
                        Jaringan operasional kami siap mendukung eskalasi bisnis agrikultur Anda dengan presisi.
                    </p>
                </div>
                <div class="flex flex-col gap-6">
                    <!-- Office -->
                    <div class="flex items-start gap-4 p-6 bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/30">
                        <div class="w-12 h-12 rounded-full bg-surface-container flex items-center justify-center shrink-0 text-primary">
                            <span class="material-symbols-outlined icon-fill">domain</span>
                        </div>
                        <div>
                            <h3 class="font-label-md text-label-md text-on-surface mb-1 font-bold">Kantor Pusat</h3>
                            <p class="font-body-md text-body-md text-on-surface-variant text-sm">
                                <?= htmlspecialchars($contactInfo['address']) ?>
                            </p>
                        </div>
                    </div>
                    <!-- WhatsApp -->
                    <div class="flex items-start gap-4 p-6 bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/30">
                        <div class="w-12 h-12 rounded-full bg-surface-container flex items-center justify-center shrink-0 text-primary">
                            <span class="material-symbols-outlined icon-fill">forum</span>
                        </div>
                        <div>
                            <h3 class="font-label-md text-label-md text-on-surface mb-1 font-bold">Konsultasi Langsung</h3>
                            <a class="font-body-md text-body-md text-primary font-bold hover:underline" href="https://api.whatsapp.com/send?phone=<?= htmlspecialchars($contactInfo['whatsapp']) ?>">
                                <?= htmlspecialchars($contactInfo['whatsapp_display'] ?? $contactInfo['whatsapp']) ?>
                            </a>
                            <p class="text-xs text-on-surface-variant mt-1">Respon cepat untuk klien B2B.</p>
                        </div>
                    </div>
                    <!-- Email -->
                    <div class="flex items-start gap-4 p-6 bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/30">
                        <div class="w-12 h-12 rounded-full bg-surface-container flex items-center justify-center shrink-0 text-primary">
                            <span class="material-symbols-outlined icon-fill">mail</span>
                        </div>
                        <div>
                            <h3 class="font-label-md text-label-md text-on-surface mb-1 font-bold">Email Korporat</h3>
                            <a class="font-body-md text-body-md text-primary font-bold hover:underline" href="mailto:<?= htmlspecialchars($contactInfo['email']) ?>">
                                <?= htmlspecialchars($contactInfo['email']) ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form (Right Col) -->
            <div class="lg:col-span-7">
                <div class="bg-surface-container-lowest border border-outline-variant/60 rounded-2xl p-8 shadow-sm">
                    <h2 class="font-manrope font-bold text-headline-md text-primary mb-6" style="font-size: 20px;">Kirim Pesan</h2>
                    
                    <?php if (!empty($success_msg)): ?>
                    <div class="bg-[#EFF4EF] border border-primary/20 text-primary px-5 py-3 rounded-lg text-sm mb-6 font-medium">
                        <?= htmlspecialchars($success_msg) ?>
                    </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="contact.php" class="flex flex-col gap-5">
                        <input type="hidden" name="action" value="send_message">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="flex flex-col gap-2">
                                <label for="nama" class="text-label-md text-on-surface font-semibold text-sm">Nama Anda <span class="text-error">*</span></label>
                                <input id="nama" type="text" name="nama" required class="w-full rounded-lg border border-outline-variant/80 bg-surface px-4 py-3 text-body-md focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none"/>
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="email" class="text-label-md text-on-surface font-semibold text-sm">Email Korporat <span class="text-error">*</span></label>
                                <input id="email" type="email" name="email" required class="w-full rounded-lg border border-outline-variant/80 bg-surface px-4 py-3 text-body-md focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none"/>
                            </div>
                        </div>
                        
                        <div class="flex flex-col gap-2">
                            <label for="subjek" class="text-label-md text-on-surface font-semibold text-sm">Subjek</label>
                            <input id="subjek" type="text" name="subjek" class="w-full rounded-lg border border-outline-variant/80 bg-surface px-4 py-3 text-body-md focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none"/>
                        </div>
                        
                        <div class="flex flex-col gap-2">
                            <label for="pesan" class="text-label-md text-on-surface font-semibold text-sm">Pesan Anda <span class="text-error">*</span></label>
                            <textarea id="pesan" name="pesan" rows="5" required class="w-full rounded-lg border border-outline-variant/80 bg-surface px-4 py-3 text-body-md focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none"></textarea>
                        </div>
                        
                        <button type="submit" class="bg-primary text-on-primary font-manrope font-bold text-label-md py-4 rounded-xl hover:opacity-90 transition-opacity shadow-md mt-2">
                            Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQs Accordion Section -->
    <section class="py-section-padding bg-surface-container-low w-full">
        <div class="max-w-3xl mx-auto px-margin-mobile md:px-margin-desktop">
            <h2 class="font-manrope text-headline-lg font-bold text-primary text-center mb-12">Frequently Asked Questions</h2>
            <div class="flex flex-col gap-4">
                <?php foreach ($faqItems as $faq): ?>
                <div class="faq-item bg-surface-container-lowest rounded-xl border border-outline-variant/60 overflow-hidden shadow-sm">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-5 flex justify-between items-center text-left hover:bg-surface transition-colors">
                        <span class="font-manrope font-bold text-primary text-sm md:text-base"><?= htmlspecialchars($faq['question']) ?></span>
                        <span class="material-symbols-outlined text-outline transition-transform duration-300 faq-icon">expand_more</span>
                    </button>
                    <div class="faq-content max-h-0 overflow-hidden transition-all duration-300 ease-out">
                        <div class="px-6 pb-5 pt-2 text-sm leading-relaxed text-on-surface-variant">
                            <?= htmlspecialchars($faq['answer']) ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>

<script>
function toggleFaq(btn) {
    const faqItem = btn.parentElement;
    const content = faqItem.querySelector('.faq-content');
    const icon = faqItem.querySelector('.faq-icon');
    
    if (content.style.maxHeight && content.style.maxHeight !== '0px') {
        content.style.maxHeight = '0px';
        icon.classList.remove('rotate-180');
    } else {
        // Close other FAQ items if wanted (optional, here we just open the clicked one)
        content.style.maxHeight = content.scrollHeight + 'px';
        icon.classList.add('rotate-180');
    }
}
</script>

<?php require_once 'includes/footer.php'; ?>
