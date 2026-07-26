<?php
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['type'])) {
    $type = $_POST['type'];
    $redirect = $_SERVER['HTTP_REFERER'] ?? '../index.php';
    // Remove query params from redirect
    $redirect = explode('?', $redirect)[0];

    if ($type === 'product') {
        $products = read_json('products.json');
        
        $benefits = isset($_POST['benefits']) ? explode(',', $_POST['benefits']) : [];
        $benefits = array_map('trim', $benefits);
        $benefits = array_filter($benefits);

        $imageUrl = handle_image_upload('image_file', $_POST['image'] ?? '');

        $productData = [
            'name' => $_POST['name'] ?? '',
            'category' => $_POST['category'] ?? '',
            'sub_category' => $_POST['sub_category'] ?? '',
            'price' => isset($_POST['price']) ? (int)$_POST['price'] : 0,
            'description' => $_POST['description'] ?? '',
            'full_description' => $_POST['full_description'] ?? '',
            'image' => $imageUrl,
            'badge' => $_POST['badge'] ?? '',
            'tag' => $_POST['tag'] ?? '',
            'crop_target' => $_POST['crop_target'] ?? '',
            'dosage' => $_POST['dosage'] ?? '',
            'benefits' => array_values($benefits)
        ];

        if (!empty($_POST['id'])) {
            // Update
            $id = (int)$_POST['id'];
            $productData['id'] = $id;
            foreach ($products as $key => $p) {
                if ($p['id'] === $id) {
                    $products[$key] = array_merge($p, $productData);
                    break;
                }
            }
        } else {
            // Create
            $productData['id'] = get_next_id($products);
            $products[] = $productData;
        }

        write_json('products.json', $products);
        header("Location: {$redirect}?success=1");
        exit;
    }

    if ($type === 'article') {
        $articles = read_json('articles.json');
        
        $imageUrl = handle_image_upload('image_file', $_POST['image'] ?? '');

        $articleData = [
            'title' => $_POST['title'] ?? '',
            'category' => $_POST['category'] ?? '',
            'date' => $_POST['date'] ?? date('Y-m-d'),
            'excerpt' => $_POST['excerpt'] ?? '',
            'content' => $_POST['content'] ?? '',
            'image' => $imageUrl
        ];

        if (!empty($_POST['id'])) {
            $id = (int)$_POST['id'];
            $articleData['id'] = $id;
            foreach ($articles as $key => $a) {
                if ($a['id'] === $id) {
                    $articles[$key] = array_merge($a, $articleData);
                    break;
                }
            }
        } else {
            $articleData['id'] = get_next_id($articles);
            $articles[] = $articleData;
        }

        write_json('articles.json', $articles);
        header("Location: {$redirect}?success=1");
        exit;
    }

    if ($type === 'faq') {
        $faqs = read_json('faq.json');
        
        $faqData = [
            'question' => $_POST['question'] ?? '',
            'answer' => $_POST['answer'] ?? ''
        ];

        if (!empty($_POST['id'])) {
            $id = (int)$_POST['id'];
            $faqData['id'] = $id;
            foreach ($faqs as $key => $f) {
                if ($f['id'] === $id) {
                    $faqs[$key] = array_merge($f, $faqData);
                    break;
                }
            }
        } else {
            $faqData['id'] = get_next_id($faqs);
            $faqs[] = $faqData;
        }

        write_json('faq.json', $faqs);
        header("Location: {$redirect}?success=1");
        exit;
    }

    if ($type === 'about') {
        $storyImage = handle_image_upload('story_image_file', $_POST['story_image'] ?? '');
        $about = [
            'hero_title' => $_POST['hero_title'] ?? '',
            'hero_subtitle' => $_POST['hero_subtitle'] ?? '',
            'story_title' => $_POST['story_title'] ?? '',
            'story_p1' => $_POST['story_p1'] ?? '',
            'story_p2' => $_POST['story_p2'] ?? '',
            'story_image' => $storyImage,
            'vision' => $_POST['vision'] ?? '',
            'mission1' => $_POST['mission1'] ?? '',
            'mission2' => $_POST['mission2'] ?? '',
            'mission3' => $_POST['mission3'] ?? ''
        ];
        write_json('about.json', $about);
        header("Location: {$redirect}?success=1");
        exit;
    }

    if ($type === 'contact') {
        $contact = [
            'address' => $_POST['address'] ?? '',
            'whatsapp' => $_POST['whatsapp'] ?? '',
            'whatsapp_display' => $_POST['whatsapp_display'] ?? '',
            'email' => $_POST['email'] ?? '',
            'maps_embed' => $_POST['maps_embed'] ?? ''
        ];
        write_json('contact.json', $contact);
        header("Location: {$redirect}?success=1");
        exit;
    }

    if ($type === 'hero') {
        $indexImage = handle_image_upload('index_image_file', $_POST['index_image'] ?? '');
        $aboutImage = handle_image_upload('about_image_file', $_POST['about_image'] ?? '');
        $contactImage = handle_image_upload('contact_image_file', $_POST['contact_image'] ?? '');

        $heroData = [
            'index' => [
                'title' => $_POST['index_title'] ?? '',
                'subtitle' => $_POST['index_subtitle'] ?? '',
                'image' => $indexImage,
                'cta_text' => $_POST['index_cta_text'] ?? '',
                'cta_link' => $_POST['index_cta_link'] ?? ''
            ],
            'about' => [
                'title' => $_POST['about_title'] ?? '',
                'subtitle' => $_POST['about_subtitle'] ?? '',
                'image' => $aboutImage
            ],
            'contact' => [
                'title' => $_POST['contact_title'] ?? '',
                'subtitle' => $_POST['contact_subtitle'] ?? '',
                'image' => $contactImage
            ]
        ];
        write_json('hero.json', $heroData);
        header("Location: {$redirect}?success=1");
        exit;
    }

    if ($type === 'settings') {
        $currentSettings = get_settings();
        
        $settings = [
            'site_name' => $_POST['site_name'] ?? $currentSettings['site_name'],
            'site_tagline' => $_POST['site_tagline'] ?? $currentSettings['site_tagline'],
            'footer_tagline' => $_POST['footer_tagline'] ?? $currentSettings['footer_tagline'],
            'copyright' => $_POST['copyright'] ?? $currentSettings['copyright'],
            'whatsapp_number' => $_POST['whatsapp_number'] ?? $currentSettings['whatsapp_number'],
            'admin_username' => $currentSettings['admin_username'],
            'admin_password_hash' => $currentSettings['admin_password_hash']
        ];

        // Handle credential changes
        $credentialError = '';
        if (!empty($_POST['new_username']) || !empty($_POST['new_password'])) {
            // Verify current password
            $currentPassword = $_POST['current_password'] ?? '';
            if (empty($currentPassword) || !password_verify($currentPassword, $currentSettings['admin_password_hash'])) {
                header("Location: {$redirect}?error=" . urlencode('Password saat ini salah!'));
                exit;
            }
            
            // Update username if provided
            if (!empty($_POST['new_username'])) {
                $settings['admin_username'] = trim($_POST['new_username']);
                $_SESSION['admin_username'] = $settings['admin_username'];
            }
            
            // Update password if provided
            if (!empty($_POST['new_password'])) {
                $confirmPassword = $_POST['confirm_password'] ?? '';
                if ($_POST['new_password'] !== $confirmPassword) {
                    header("Location: {$redirect}?error=" . urlencode('Konfirmasi password tidak cocok!'));
                    exit;
                }
                $settings['admin_password_hash'] = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
            }
        }

        write_json('settings.json', $settings);
        header("Location: {$redirect}?success=1");
        exit;
    }

    header("Location: {$redirect}");
    exit;
}

header("Location: ../index.php");
exit;
