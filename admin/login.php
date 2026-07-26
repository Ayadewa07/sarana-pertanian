<?php
/**
 * Admin Login Page
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/includes/functions.php';

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: /admin/login.php');
    exit;
}

// If already logged in, redirect to dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: /admin/index.php');
    exit;
}

$error = '';

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    $settings = get_settings();
    
    if ($username === $settings['admin_username'] && password_verify($password, $settings['admin_password_hash'])) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        header('Location: index.php');
        exit;
    } else {
        $error = 'Username atau password salah!';
    }
}
?>
<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Admin Panel | Sarana Pertanian</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        'admin-bg': '#0f172a',
                        'admin-surface': '#1e293b',
                        'admin-surface-light': '#334155',
                        'admin-border': '#475569',
                        'admin-primary': '#6366f1',
                        'admin-primary-light': '#818cf8',
                        'admin-accent': '#22d3ee',
                        'admin-danger': '#ef4444',
                        'admin-text': '#f1f5f9',
                        'admin-text-muted': '#94a3b8',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .icon-fill {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .login-bg {
            background: radial-gradient(ellipse at 20% 50%, rgba(99,102,241,0.15) 0%, transparent 50%),
                        radial-gradient(ellipse at 80% 20%, rgba(34,211,238,0.1) 0%, transparent 50%),
                        radial-gradient(ellipse at 50% 80%, rgba(129,140,248,0.08) 0%, transparent 50%);
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .float-anim { animation: float 6s ease-in-out infinite; }
    </style>
</head>
<body class="bg-admin-bg text-admin-text antialiased login-bg min-h-screen flex items-center justify-center p-4">
    
    <div class="w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-8 float-anim">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-admin-primary to-admin-primary-light flex items-center justify-center mx-auto mb-4 shadow-lg shadow-admin-primary/20">
                <span class="material-symbols-outlined icon-fill text-white text-3xl">eco</span>
            </div>
            <h1 class="font-manrope text-2xl font-bold text-admin-text">Sarana Pertanian</h1>
            <p class="text-admin-text-muted text-sm mt-1">Admin Dashboard</p>
        </div>

        <!-- Login Card -->
        <div class="bg-admin-surface rounded-2xl border border-admin-border p-8 shadow-xl shadow-black/20">
            <h2 class="text-xl font-semibold text-admin-text mb-1">Selamat Datang</h2>
            <p class="text-admin-text-muted text-sm mb-6">Masuk untuk mengelola website Anda</p>

            <?php if ($error): ?>
            <div class="bg-admin-danger/10 border border-admin-danger/30 rounded-lg px-4 py-3 mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-admin-danger text-lg">error</span>
                <span class="text-admin-danger text-sm"><?= sanitize($error) ?></span>
            </div>
            <?php endif; ?>

            <form method="POST" action="login.php">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-admin-text-muted mb-2">Username</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-admin-text-muted text-xl">person</span>
                        <input type="text" name="username" required placeholder="Masukkan username"
                            class="w-full bg-admin-bg border border-admin-border rounded-xl pl-11 pr-4 py-3 text-sm text-admin-text placeholder-admin-text-muted/50 focus:border-admin-primary focus:ring-1 focus:ring-admin-primary outline-none transition-all"
                            value="<?= sanitize($_POST['username'] ?? '') ?>">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-admin-text-muted mb-2">Password</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-admin-text-muted text-xl">lock</span>
                        <input type="password" name="password" id="password" required placeholder="Masukkan password"
                            class="w-full bg-admin-bg border border-admin-border rounded-xl pl-11 pr-11 py-3 text-sm text-admin-text placeholder-admin-text-muted/50 focus:border-admin-primary focus:ring-1 focus:ring-admin-primary outline-none transition-all">
                        <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-admin-text-muted hover:text-admin-text transition-colors">
                            <span class="material-symbols-outlined text-xl" id="eye-icon">visibility</span>
                        </button>
                    </div>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-admin-primary to-admin-primary-light text-white font-semibold py-3 rounded-xl hover:opacity-90 transition-opacity shadow-lg shadow-admin-primary/20 flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-xl">login</span>
                    Masuk
                </button>
            </form>
        </div>

        <!-- Footer -->
        <p class="text-center text-admin-text-muted text-xs mt-6">
            &copy; <?= date('Y') ?> Sarana Pertanian. Admin Panel
        </p>
    </div>

    <script>
    function togglePassword() {
        const input = document.getElementById('password');
        const icon = document.getElementById('eye-icon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.textContent = 'visibility_off';
        } else {
            input.type = 'password';
            icon.textContent = 'visibility';
        }
    }
    </script>
</body>
</html>
