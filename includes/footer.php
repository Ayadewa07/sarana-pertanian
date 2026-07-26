<?php
$footerSettingsPath = __DIR__ . '/../admin/data/settings.json';
$footerSettings = [
    'site_name' => 'Sarana Pertanian',
    'footer_tagline' => 'Precision Stewardship through Scientific Rigor.',
    'copyright' => '© 2024 Sarana Pertanian. All rights reserved.'
];
if (file_exists($footerSettingsPath)) {
    $fs = json_decode(file_get_contents($footerSettingsPath), true);
    if ($fs) {
        $footerSettings = array_merge($footerSettings, $fs);
    }
}
?>
<!-- Footer -->
<footer class="bg-surface-container-lowest border-t border-outline-variant w-full">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-stack-lg w-full px-margin-desktop py-section-padding max-w-max-container mx-auto">
        <div class="col-span-1 md:col-span-1">
            <div class="font-manrope text-headline-md font-bold text-primary mb-4">
                <?= htmlspecialchars($footerSettings['site_name']) ?>
             </div>
            <p class="font-inter text-body-md text-on-surface-variant mb-6">
                <?= htmlspecialchars($footerSettings['footer_tagline']) ?>
             </p>
            <p class="font-inter text-label-sm text-on-surface-variant">
                <?= htmlspecialchars($footerSettings['copyright']) ?>
             </p>
        </div>
        <div class="col-span-1">
            <h4 class="font-inter text-label-md font-semibold text-primary mb-4">Legal &amp; Compliance</h4>
            <ul class="space-y-3">
                <li><a class="font-inter text-body-md text-on-surface-variant hover:text-secondary transition-all underline underline-offset-4" href="#">Privacy Policy</a></li>
                <li><a class="font-inter text-body-md text-on-surface-variant hover:text-secondary transition-all underline underline-offset-4" href="#">Terms of Service</a></li>
            </ul>
        </div>
        <div class="col-span-1">
            <h4 class="font-inter text-label-md font-semibold text-primary mb-4">Certifications</h4>
            <ul class="space-y-3">
                <li><a class="font-inter text-body-md text-on-surface-variant hover:text-secondary transition-all underline underline-offset-4" href="#">ISO 9001 Certified</a></li>
                <li><a class="font-inter text-body-md text-on-surface-variant hover:text-secondary transition-all underline underline-offset-4" href="#">Global GAP</a></li>
            </ul>
        </div>
        <div class="col-span-1">
            <h4 class="font-inter text-label-md font-semibold text-primary mb-4">Support</h4>
            <ul class="space-y-3">
                <li><a class="font-inter text-body-md text-on-surface-variant hover:text-secondary transition-all underline underline-offset-4" href="contact.php">Contact Support</a></li>
            </ul>
        </div>
    </div>
</footer>

</body>
</html>
