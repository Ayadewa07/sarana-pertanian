<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'includes/header.php';
?>

<main>
    <!-- Hero Section -->
    <section class="relative w-full h-[614px] min-h-[500px] flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img class="w-full h-full object-cover" src="gambar/image_from_https_images.unsplash.com_photo_1687295278526_075528ea7abe_auto/screen.png"/>
            <div class="absolute inset-0 bg-primary/40 backdrop-blur-[2px]"></div>
        </div>
        <div class="relative z-10 text-center px-margin-mobile md:px-margin-desktop max-w-3xl mx-auto">
            <h1 class="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg text-on-primary mb-stack-md">Tentang Sarana Pertanian</h1>
            <p class="font-body-lg text-body-lg text-surface-container-low max-w-2xl mx-auto">Pelopor solusi agroteknologi presisi untuk kepastian panen dan keberlanjutan pertanian komersial.</p>
        </div>
    </section>

    <!-- Company Story Section -->
    <section class="py-section-padding px-margin-mobile md:px-margin-desktop max-w-max-container mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="font-headline-lg text-headline-lg text-primary mb-stack-lg">Membangun Kepercayaan Melalui Keahlian Agronomi Modern</h2>
                <p class="font-body-lg text-body-lg text-on-surface-variant mb-stack-md leading-relaxed">
                    Kami memahami bahwa pertanian bukan sekadar mengolah tanah, melainkan sebuah industri yang membutuhkan presisi, sains, dan keandalan tingkat tinggi. Sebagai 'Agronom Modern', Sarana Pertanian hadir menjembatani kearifan lokal dengan inovasi teknologi terkini.
                </p>
                <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
                    Komitmen kami adalah menyediakan input pertanian berkualitas premium—dari benih hingga perlindungan tanaman—yang menjamin produktivitas maksimal. Kami tidak sekadar mendistribusikan produk, kami bermitra dengan para pelaku agribisnis untuk mengelola risiko cuaca dan hama, memastikan setiap hektar lahan memberikan hasil yang pasti.
                </p>
            </div>
            <div class="rounded-xl overflow-hidden shadow-[0_4px_20px_rgba(0,0,0,0.05)] aspect-[4/5] h-full">
                <img class="w-full h-full object-cover" src="gambar/image_from_https_images.unsplash.com_photo_1691767247958_5c0d1505ac79_auto/screen.png"/>
            </div>
        </div>
    </section>

    <!-- Vision & Mission -->
    <section class="py-section-padding px-margin-mobile md:px-margin-desktop bg-surface-container-low w-full">
        <div class="max-w-max-container mx-auto">
            <div class="text-center mb-16">
                <h2 class="font-headline-lg text-headline-lg text-primary">Visi & Misi Kami</h2>
                <p class="font-body-lg text-body-lg text-on-surface-variant mt-stack-sm">Arah strategis kami dalam memberdayakan pertanian institusional.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-gutter">
                <!-- Vision Card -->
                <div class="bg-surface p-8 rounded-xl shadow-[0_4px_20px_rgba(0,0,0,0.05)] border-t-4 border-primary">
                    <div class="w-12 h-12 bg-primary-container/10 rounded-full flex items-center justify-center mb-stack-md">
                        <span class="material-symbols-outlined text-primary-container text-[28px]">visibility</span>
                    </div>
                    <h3 class="font-headline-md text-headline-md text-on-surface mb-stack-sm">Visi</h3>
                    <p class="font-body-md text-body-md text-on-surface-variant">
                        Menjadi mitra agroteknologi paling terpercaya di Asia Tenggara, memimpin transformasi pertanian menuju efisiensi, presisi, dan keberlanjutan global.
                    </p>
                </div>
                <!-- Mission Card -->
                <div class="bg-surface p-8 rounded-xl shadow-[0_4px_20px_rgba(0,0,0,0.05)] border-t-4 border-secondary-fixed-dim">
                    <div class="w-12 h-12 bg-secondary-fixed-dim/10 rounded-full flex items-center justify-center mb-stack-md">
                        <span class="material-symbols-outlined text-secondary text-[28px]">rocket_launch</span>
                    </div>
                    <h3 class="font-headline-md text-headline-md text-on-surface mb-stack-sm">Misi</h3>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <span class="material-symbols-outlined text-primary mr-3 text-[20px] mt-1">check_circle</span>
                            <span class="font-body-md text-body-md text-on-surface-variant">Menyediakan input pertanian presisi berbasis data dan riset.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="material-symbols-outlined text-primary mr-3 text-[20px] mt-1">check_circle</span>
                            <span class="font-body-md text-body-md text-on-surface-variant">Mengedukasi dan mendampingi petani komersial untuk kepastian panen.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="material-symbols-outlined text-primary mr-3 text-[20px] mt-1">check_circle</span>
                            <span class="font-body-md text-body-md text-on-surface-variant">Memastikan standar kualitas dan keamanan pangan internasional.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-section-padding px-margin-mobile md:px-margin-desktop bg-primary-container w-full relative overflow-hidden">
        <div class="absolute inset-0 opacity-10"></div>
        <div class="max-w-4xl mx-auto text-center relative z-10">
            <h2 class="font-headline-lg text-headline-lg text-on-primary mb-stack-md">Tingkatkan Kepastian Panen Anda Hari Ini</h2>
            <p class="font-body-lg text-body-lg text-primary-fixed mb-stack-lg max-w-2xl mx-auto">
                Bermitra dengan Sarana Pertanian untuk akses ke input pertanian premium dan konsultasi agronomi ahli.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="contact.php" class="bg-secondary-container text-on-secondary-container font-label-md text-label-md px-8 py-4 rounded-xl hover:bg-secondary-fixed transition-colors shadow-sm text-center">
                    Mulai Konsultasi Anda
                </a>
                <a href="catalog.php" class="bg-transparent text-on-primary border-[1.5px] border-on-primary font-label-md text-label-md px-8 py-4 rounded-xl hover:bg-primary transition-colors text-center">
                    Lihat Katalog Produk
                </a>
            </div>
        </div>
    </section>
</main>

<?php require_once 'includes/footer.php'; ?>
