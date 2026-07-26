<?php
// Central product database - loads from admin JSON if available, falls back to hardcoded array
$jsonPath = __DIR__ . '/../admin/data/products.json';
if (file_exists($jsonPath)) {
    $jsonData = json_decode(file_get_contents($jsonPath), true);
    if (is_array($jsonData) && !empty($jsonData)) {
        $products = [];
        foreach ($jsonData as $p) {
            $products[$p['id']] = $p;
        }
        // Helper to format price to Rupiah currency
        if (!function_exists('format_rupiah')) {
            function format_rupiah($number) {
                return 'Rp ' . number_format($number, 0, ',', '.');
            }
        }
        return; // Skip the hardcoded array below
    }
}

// Fallback: Central product database array with pricing
$products = [
    1 => [
        'id' => 1,
        'name' => 'Kalingga 526 SL',
        'category' => 'Nutrisi',
        'sub_category' => 'Nutrisi Cair',
        'price' => 85000,
        'description' => 'Kalium cair konsentrasi tinggi untuk pembesaran umbi dan buah.',
        'full_description' => 'Kalingga 526 SL adalah pupuk kalium cair konsentrasi tinggi yang dirancang khusus untuk merangsang pembesaran umbi dan buah pada berbagai jenis tanaman pertanian. Formulasi cair uniknya memungkinkan penyerapan cepat oleh stomata daun dan akar tanaman.',
        'image' => 'gambar/image_from_https_assets.zyrosite.com_cdn_cgi_image_format_auto_w_399_h_424_fit/screen.png',
        'badge' => 'Best Seller',
        'tag' => 'Nutrisi',
        'crop_target' => 'Padi, Bawang Merah, Kentang, Melon, Cabai',
        'dosage' => '1.5 - 2 ml per liter air',
        'benefits' => [
            'Meningkatkan berat, ukuran, dan kemanisan buah/umbi',
            'Memperkuat dinding sel tanaman agar tahan rebah',
            'Membantu transportasi karbohidrat dan hasil fotosintesis',
            'Meningkatkan ketahanan tanaman terhadap cekaman kekeringan'
        ]
    ],
    2 => [
        'id' => 2,
        'name' => 'Barikade 180 EC',
        'category' => 'Fungisida',
        'sub_category' => 'Fungisida & ZPT',
        'price' => 115000,
        'description' => 'Anti jamur spektrum luas untuk perlindungan tanaman padi dan sayuran.',
        'full_description' => 'Barikade 180 EC adalah fungisida sistemik spektrum luas dengan aksi protektif dan kuratif yang dilengkapi Zat Pengatur Tumbuh (ZPT) tanaman. Melindungi secara total dari serangan jamur pathogen sekaligus membuat tanaman lebih hijau dan sehat.',
        'image' => 'gambar/image_from_https_assets.zyrosite.com_cdn_cgi_image_format_auto_w_400_h_424_fit_2/screen.png',
        'badge' => 'Original',
        'tag' => 'Fungisida & ZPT',
        'crop_target' => 'Padi, Sayuran, Cabai, Tomat, Bawang Merah',
        'dosage' => '1 - 1.5 ml per liter air',
        'benefits' => [
            'Mengendalikan penyakit blas padi, bercak daun, dan busuk buah',
            'Meningkatkan bobot gabah dan persentase beras kepala',
            'Mengandung ZPT untuk menjaga daun bendera tetap hijau',
            'Melindungi tanaman secara sistemik hingga ke tunas baru'
        ]
    ],
    3 => [
        'id' => 3,
        'name' => 'ImSmell 400 EC',
        'category' => 'Insektisida',
        'sub_category' => 'Insektisida',
        'price' => 95000,
        'description' => 'Penumpas hama lalat buah efektif dengan bahan aktif Dimethoate.',
        'full_description' => 'ImSmell 400 EC adalah insektisida kontak dan lambung berspektrum luas dengan bau khas yang menyengat untuk mengusir dan mengendalikan hama lalat buah (Bactrocera sp.) serta kutu-kutuan pada tanaman hortikultura.',
        'image' => 'gambar/image_from_https_assets.zyrosite.com_cdn_cgi_image_format_auto_w_400_h_424_fit_1/screen.png',
        'badge' => 'Terlaris',
        'tag' => 'Insektisida',
        'crop_target' => 'Cabai, Mangga, Jeruk, Melon, Semangka, Tomat',
        'dosage' => '2 ml per liter air',
        'benefits' => [
            'Aksi kontak cepat menumpas hama sasaran',
            'Bau khas repelent yang mengusir lalat buah dari area lahan',
            'Mengendalikan hama kutu daun (aphids), thrips, dan tungau',
            'Daya rekat kuat pada permukaan daun tanaman'
        ]
    ],
    4 => [
        'id' => 4,
        'name' => 'Jagung Hibrida Bisi-18',
        'category' => 'Benih Premium',
        'sub_category' => 'Benih',
        'price' => 75000,
        'description' => 'Benih jagung hibrida tahan penyakit dengan potensi hasil panen tinggi.',
        'full_description' => 'Benih Jagung Hibrida Bisi-18 merupakan benih jagung unggul pilihan nasional dengan potensi hasil panen sangat tinggi. Memiliki vigor tanaman yang kokoh dan perakaran yang sangat kuat sehingga toleran terhadap angin kencang.',
        'image' => 'gambar/image_from_https_images.unsplash.com_photo_1579893538973_f5e18745c8f7_auto/screen.png',
        'badge' => 'Unggul',
        'tag' => 'Benih Premium',
        'crop_target' => 'Lahan Kering, Sawah Tadah Hujan',
        'dosage' => '15 - 20 kg benih per hektar',
        'benefits' => [
            'Potensi hasil panen mencapai 12 ton per hektar pipilan kering',
            'Tahan terhadap penyakit bulai dan karat daun',
            'Tongkol terisi penuh hingga ujung (mulus)',
            'Kadar air saat panen rendah, memudahkan penyimpanan'
        ]
    ],
    5 => [
        'id' => 5,
        'name' => 'Precision Sprayer Nozzle',
        'category' => 'Alat Pertanian',
        'sub_category' => 'Alat Pertanian',
        'price' => 25000,
        'description' => 'Nozzle sprayer presisi tinggi untuk distribusi cairan yang merata.',
        'full_description' => 'Precision Sprayer Nozzle dirancang khusus untuk mengoptimalkan aplikasi pestisida dan pupuk daun. Menghasilkan butiran semprot (droplet) yang konsisten dan merata untuk menutupi seluruh tajuk tanaman tanpa membuang banyak bahan aktif.',
        'image' => 'gambar/image_from_https_images.unsplash.com_photo_1691767247958_5c0d1505ac79_auto/screen.png',
        'badge' => 'Promo',
        'tag' => 'Alat Pertanian',
        'crop_target' => 'Semua jenis alat semprot (sprayer gendong/mesin)',
        'dosage' => 'Pasangkan pada stik sprayer standar',
        'benefits' => [
            'Bahan kuningan berlapis tahan karat kimia',
            'Mengurangi pemborosan input cairan hingga 25%',
            'Pola semprotan misting (kabut) sangat halus',
            'Mudah dibersihkan jika terjadi penyumbatan'
        ]
    ],
    6 => [
        'id' => 6,
        'name' => 'AgriSense Soil Monitor',
        'category' => 'Sensor & IoT',
        'sub_category' => 'Alat Pertanian',
        'price' => 295000,
        'description' => 'Monitor kelembapan dan pH tanah digital untuk presisi pertanian.',
        'full_description' => 'AgriSense Soil Monitor adalah sensor tanah digital portabel untuk mengukur kelembapan (moisture), temperatur, dan tingkat keasaman (pH) tanah secara instan dan akurat. Menunjang keputusan irigasi dan pemupukan presisi.',
        'image' => 'gambar/image_from_https_images.unsplash.com_photo_1687295278526_075528ea7abe_auto/screen.png',
        'badge' => 'IoT Smart',
        'tag' => 'Sensor & IoT',
        'crop_target' => 'Tanah bedengan, media tanam greenhouse, sawah',
        'dosage' => 'Tancapkan probe ke dalam tanah selama 1-2 menit',
        'benefits' => [
            'Layar LCD digital dengan lampu latar untuk pembacaan mudah',
            'Akurasi tinggi untuk pengukuran pH (toleransi +-0.2)',
            'Probe stainless steel panjang tahan korosi',
            'Membantu mencegah pembusukan akar akibat kelebihan air'
        ]
    ]
];

// Helper to format price to Rupiah currency
function format_rupiah($number) {
    return 'Rp ' . number_format($number, 0, ',', '.');
}
?>
