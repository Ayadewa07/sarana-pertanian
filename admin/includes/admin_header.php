<?php
/**
 * Admin Header - HTML head and Tailwind config for dark theme
 */
$pageTitle = isset($pageTitle) ? $pageTitle . ' — Admin' : 'Admin Dashboard';
require_once __DIR__ . '/functions.php';
$unreadCount = get_unread_count();
$settings = get_settings();
?>
<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= sanitize($pageTitle) ?> | Sarana Pertanian</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
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
                        'admin-success': '#10b981',
                        'admin-warning': '#f59e0b',
                        'admin-danger': '#ef4444',
                        'admin-text': '#f1f5f9',
                        'admin-text-muted': '#94a3b8',
                    },
                    fontFamily: {
                        'inter': ['Inter', 'sans-serif'],
                        'manrope': ['Manrope', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        html, body {
            background-color: #0f172a;
            color: #f1f5f9;
        }
    </style>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .icon-fill {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body { font-family: 'Inter', sans-serif; }
        
        /* Scrollbar styling */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #1e293b; }
        ::-webkit-scrollbar-thumb { background: #475569; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #64748b; }
        
        /* Modal animation */
        .modal-backdrop {
            transition: opacity 0.2s ease;
        }
        .modal-content {
            transition: transform 0.2s ease, opacity 0.2s ease;
        }
        .modal-backdrop.hidden { opacity: 0; pointer-events: none; }
        .modal-backdrop.hidden .modal-content { transform: scale(0.95); opacity: 0; }
        
        /* Toast notification */
        .toast {
            animation: slideIn 0.3s ease, fadeOut 0.3s ease 2.7s forwards;
        }
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
        
        /* Sidebar active */
        .sidebar-link.active {
            background: linear-gradient(135deg, rgba(99,102,241,0.2), rgba(99,102,241,0.1));
            border-left: 3px solid #6366f1;
            color: #818cf8;
        }
        .sidebar-link:hover:not(.active) {
            background: rgba(255,255,255,0.05);
        }
    </style>
</head>
<body class="bg-admin-bg text-admin-text antialiased">
