<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Calculate cart count
$cartCount = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $productId => $qty) {
        $cartCount += $qty;
    }
}

// Load site settings
$headerSettingsPath = __DIR__ . '/../admin/data/settings.json';
$siteName = 'Sarana Pertanian';
$siteTagline = 'Yield Certainty through Precision Stewardship';
if (file_exists($headerSettingsPath)) {
    $hs = json_decode(file_get_contents($headerSettingsPath), true);
    if (!empty($hs['site_name'])) $siteName = $hs['site_name'];
    if (!empty($hs['site_tagline'])) $siteTagline = $hs['site_tagline'];
}

// Determine active page
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title><?= htmlspecialchars($siteName) ?> - <?= htmlspecialchars($siteTagline) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.tailwindcss.com">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;family=Manrope:wght@600;700;800&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
    <script id="tailwind-config">
        tailwind.config = {
          darkMode: "class",
          theme: {
            extend: {
              "colors": {
                      "surface-container": "#eeeeec",
                      "surface": "#f9f9f7",
                      "on-secondary-container": "#795204",
                      "on-secondary": "#ffffff",
                      "on-background": "#1a1c1b",
                      "secondary-container": "#ffc875",
                      "secondary": "#7e570a",
                      "primary-container": "#214d36",
                      "inverse-on-surface": "#f1f1ef",
                      "tertiary-fixed-dim": "#c3c8c3",
                      "error": "#ba1a1a",
                      "on-tertiary": "#ffffff",
                      "tertiary": "#2a302d",
                      "on-error-container": "#93000a",
                      "on-tertiary-fixed": "#171d1a",
                      "on-secondary-fixed": "#281800",
                      "tertiary-fixed": "#dfe4df",
                      "surface-container-high": "#e8e8e6",
                      "outline": "#717972",
                      "on-surface-variant": "#414943",
                      "surface-dim": "#dadad8",
                      "on-surface": "#1a1c1b",
                      "background": "#f9f9f7",
                      "inverse-surface": "#2f3130",
                      "surface-container-low": "#f4f4f2",
                      "secondary-fixed-dim": "#f3bd6b",
                      "primary-fixed-dim": "#a2d1b3",
                      "on-tertiary-container": "#aeb4af",
                      "primary": "#063621",
                      "on-primary-fixed": "#002112",
                      "tertiary-container": "#414643",
                      "error-container": "#ffdad6",
                      "surface-container-lowest": "#ffffff",
                      "secondary-fixed": "#ffddaf",
                      "inverse-primary": "#a2d1b3",
                      "on-primary": "#ffffff",
                      "on-error": "#ffffff",
                      "primary-fixed": "#bdeece",
                      "outline-variant": "#c1c9c1",
                      "on-primary-fixed-variant": "#234f38",
                      "on-primary-container": "#8ebd9f"
              },
              "borderRadius": {
                      "DEFAULT": "0.5rem",
                      "lg": "0.75rem",
                      "xl": "1.5rem",
                      "full": "9999px"
              },
              "spacing": {
                      "stack-md": "16px",
                      "gutter": "24px",
                      "stack-sm": "8px",
                      "stack-lg": "24px",
                      "margin-desktop": "40px",
                      "section-padding": "120px",
                      "margin-mobile": "16px",
                      "max-container": "1280px"
              },
              "fontFamily": {
                      "label-sm": ["Inter"],
                      "display-lg-mobile": ["Manrope"],
                      "body-lg": ["Inter"],
                      "label-md": ["Inter"],
                      "headline-lg": ["Manrope"],
                      "headline-md": ["Manrope"],
                      "display-lg": ["Manrope"],
                      "body-md": ["Inter"]
              },
              "fontSize": {
                      "label-sm": ["12px", {"lineHeight": "16px", "fontWeight": "500"}],
                      "display-lg-mobile": ["40px", {"lineHeight": "48px", "letterSpacing": "-0.01em", "fontWeight": "700"}],
                      "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
                      "label-md": ["14px", {"lineHeight": "20px", "letterSpacing": "0.05em", "fontWeight": "600"}],
                      "headline-lg": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "600"}],
                      "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                      "display-lg": ["56px", {"lineHeight": "64px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                      "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}]
              }
            },
          },
        }
    </script>
    <style>
        html, body {
            background-color: #f9f9f7;
            color: #1a1c1b;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .icon-fill {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        /* Mobile menu slide transitions */
        #mobile-menu {
            transition: transform 0.3s ease-in-out;
        }
    </style>
</head>
<body class="bg-background text-on-surface font-body-md antialiased selection:bg-primary-container selection:text-on-primary-container">
<!-- TopNavBar -->
<nav class="bg-surface border-b border-outline-variant shadow-sm w-full top-0 sticky z-50">
    <div class="flex justify-between items-center w-full px-margin-mobile md:px-margin-desktop max-w-max-container mx-auto h-20">
        <a href="index.php" class="font-manrope text-headline-md font-bold text-primary flex items-center gap-2">
            <span><?= htmlspecialchars($siteName) ?></span>
        </a>
        <!-- Desktop Nav -->
        <ul class="hidden md:flex gap-gutter items-center">
            <li>
                <a class="<?= ($currentPage === 'index.php') ? 'text-primary border-b-2 border-primary pb-1 font-semibold' : 'text-on-surface-variant hover:text-primary transition-colors duration-200' ?> font-manrope text-label-md font-label-md" href="index.php">Home</a>
            </li>
            <li>
                <a class="<?= ($currentPage === 'catalog.php' || $currentPage === 'detail.php') ? 'text-primary border-b-2 border-primary pb-1 font-semibold' : 'text-on-surface-variant hover:text-primary transition-colors duration-200' ?> font-manrope text-label-md font-label-md" href="catalog.php">Product</a>
            </li>
            <li>
                <a class="<?= ($currentPage === 'about.php') ? 'text-primary border-b-2 border-primary pb-1 font-semibold' : 'text-on-surface-variant hover:text-primary transition-colors duration-200' ?> font-manrope text-label-md font-label-md" href="about.php">About Us</a>
            </li>
            <li>
                <a class="<?= ($currentPage === 'contact.php') ? 'text-primary border-b-2 border-primary pb-1 font-semibold' : 'text-on-surface-variant hover:text-primary transition-colors duration-200' ?> font-manrope text-label-md font-label-md" href="contact.php">Kontak</a>
            </li>
        </ul>
        <!-- Actions & Icons -->
        <div class="flex items-center gap-stack-md">
            <a href="cart.php" class="hidden md:flex bg-primary-container text-on-primary font-manrope font-label-md text-label-md px-6 py-2.5 rounded-lg hover:opacity-90 transition-opacity">
                Inquiry Cart
            </a>
            <!-- Shopping Cart Icon -->
            <a href="cart.php" class="relative text-on-surface-variant hover:text-primary transition-colors p-2 flex items-center justify-center">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">shopping_cart</span>
                <?php if ($cartCount > 0): ?>
                    <span class="absolute top-0 right-0 bg-[#ffc875] text-[#281800] text-[10px] font-bold rounded-full w-5 h-5 flex items-center justify-center border border-surface shadow-sm">
                        <?= $cartCount ?>
                    </span>
                <?php endif; ?>
            </a>
            <!-- Account Icon -->
            <button class="text-on-surface-variant hover:text-primary transition-colors hidden md:block p-2">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">account_circle</span>
            </button>
            <!-- Mobile Menu Toggle -->
            <button onclick="toggleMobileMenu()" class="md:hidden text-on-surface-variant hover:text-primary p-2 flex items-center justify-center">
                <span class="material-symbols-outlined">menu</span>
            </button>
        </div>
    </div>
</nav>

<!-- Mobile Navigation Drawer -->
<div id="mobile-menu-overlay" onclick="toggleMobileMenu()" class="hidden fixed inset-0 bg-black/50 z-50 backdrop-blur-sm transition-opacity duration-300"></div>
<div id="mobile-menu" class="fixed top-0 right-0 h-full w-64 bg-surface z-50 shadow-2xl transform translate-x-full flex flex-col p-6 border-l border-outline-variant">
    <div class="flex justify-between items-center mb-8">
        <span class="font-manrope font-bold text-primary text-body-lg">Menu</span>
        <button onclick="toggleMobileMenu()" class="text-on-surface-variant hover:text-primary">
            <span class="material-symbols-outlined">close</span>
        </button>
    </div>
    <ul class="flex flex-col gap-6 font-manrope text-headline-md text-base">
        <li>
            <a class="<?= ($currentPage === 'index.php') ? 'text-primary font-bold' : 'text-on-surface-variant hover:text-primary' ?> block py-2 border-b border-outline-variant/30" href="index.php">Home</a>
        </li>
        <li>
            <a class="<?= ($currentPage === 'catalog.php' || $currentPage === 'detail.php') ? 'text-primary font-bold' : 'text-on-surface-variant hover:text-primary' ?> block py-2 border-b border-outline-variant/30" href="catalog.php">Product</a>
        </li>
        <li>
            <a class="<?= ($currentPage === 'about.php') ? 'text-primary font-bold' : 'text-on-surface-variant hover:text-primary' ?> block py-2 border-b border-outline-variant/30" href="about.php">About Us</a>
        </li>
        <li>
            <a class="<?= ($currentPage === 'contact.php') ? 'text-primary font-bold' : 'text-on-surface-variant hover:text-primary' ?> block py-2 border-b border-outline-variant/30" href="contact.php">Kontak</a>
        </li>
        <li class="mt-4">
            <a href="cart.php" class="w-full bg-primary text-on-primary font-manrope font-label-md text-label-md py-3 rounded-lg text-center block shadow-sm">
                Inquiry Cart (<?= $cartCount ?>)
            </a>
        </li>
    </ul>
</div>

<script>
function toggleMobileMenu() {
    const menu = document.getElementById('mobile-menu');
    const overlay = document.getElementById('mobile-menu-overlay');
    if (menu.classList.contains('translate-x-full')) {
        menu.classList.remove('translate-x-full');
        menu.classList.add('translate-x-0');
        overlay.classList.remove('hidden');
    } else {
        menu.classList.remove('translate-x-0');
        menu.classList.add('translate-x-full');
        overlay.classList.add('hidden');
    }
}
</script>
