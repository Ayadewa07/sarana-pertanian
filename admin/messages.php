<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/functions.php';

$pageTitle = 'Pesan Masuk';

$messages = read_json('messages.json');
if (!is_array($messages)) $messages = [];

// Reverse to show newest first
$messages = array_reverse($messages);

$viewId = $_GET['view'] ?? null;
$viewItem = null;
$itemIndex = -1;

if ($viewId) {
    foreach ($messages as $idx => $m) {
        if ($m['id'] == $viewId) {
            $viewItem = $m;
            $itemIndex = $idx;
            break;
        }
    }
    
    // Mark as read
    if ($viewItem && empty($viewItem['read'])) {
        $viewItem['read'] = true;
        $messages[$itemIndex]['read'] = true;
        // The file needs to be updated with correct order, we reversed it earlier, so let's read again
        $origMessages = read_json('messages.json');
        foreach ($origMessages as &$om) {
            if ($om['id'] == $viewId) {
                $om['read'] = true;
                break;
            }
        }
        write_json('messages.json', $origMessages);
    }
}

$unreadCount = get_unread_count(); // Assuming this reads from messages.json

require_once __DIR__ . '/includes/admin_header.php';
require_once __DIR__ . '/includes/sidebar.php';
?>
<main class="lg:ml-64 min-h-screen">
  <header class="sticky top-0 z-30 bg-admin-bg/80 backdrop-blur-xl border-b border-admin-border px-6 py-4 flex items-center justify-between">
    <div class="flex items-center gap-3">
        <h1 class="text-2xl font-manrope font-bold text-admin-text"><?= htmlspecialchars($pageTitle) ?></h1>
        <?php if ($unreadCount > 0): ?>
        <span class="bg-admin-danger text-white text-xs font-bold px-2.5 py-1 rounded-full">
            <?= $unreadCount ?> Baru
        </span>
        <?php endif; ?>
    </div>
    <?php if ($viewId): ?>
    <a href="messages.php" class="bg-admin-surface-light border border-admin-border text-admin-text hover:text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
      <span class="material-symbols-outlined text-sm">arrow_back</span>
      <span>Kembali</span>
    </a>
    <?php endif; ?>
  </header>
  <div class="p-6">
    <?php if (isset($_GET['success'])): ?>
    <div class="mb-6 p-4 rounded-lg bg-admin-success/10 border border-admin-success/20 flex items-center gap-3 text-admin-success">
      <span class="material-symbols-outlined">check_circle</span>
      <p><?= htmlspecialchars($_GET['success']) ?></p>
    </div>
    <?php endif; ?>

    <?php if ($viewItem): ?>
    <div class="bg-admin-surface rounded-xl border border-admin-border p-6 max-w-4xl">
        <div class="flex items-start justify-between border-b border-admin-border pb-6 mb-6">
            <div>
                <h2 class="text-xl font-bold text-admin-text mb-1"><?= htmlspecialchars($viewItem['subjek'] ?? '(Tanpa Subjek)') ?></h2>
                <div class="text-sm text-admin-text-muted flex items-center gap-4">
                    <span>Dari: <strong class="text-admin-text"><?= htmlspecialchars($viewItem['nama'] ?? '') ?></strong> (<?= htmlspecialchars($viewItem['email'] ?? '') ?>)</span>
                    <span class="w-1 h-1 rounded-full bg-admin-border"></span>
                    <span><?= htmlspecialchars($viewItem['created_at'] ?? '') ?></span>
                </div>
            </div>
            <form action="api/delete.php" method="POST" onsubmit="return confirm('Yakin ingin menghapus pesan ini?');">
                <input type="hidden" name="type" value="messages">
                <input type="hidden" name="id" value="<?= htmlspecialchars($viewItem['id']) ?>">
                <button type="submit" class="p-2 text-admin-text-muted hover:text-admin-danger transition-colors bg-admin-surface-light rounded-lg border border-admin-border" title="Hapus">
                    <span class="material-symbols-outlined">delete</span>
                </button>
            </form>
        </div>
        <div class="prose prose-invert max-w-none text-admin-text whitespace-pre-wrap">
            <?= htmlspecialchars($viewItem['pesan'] ?? '') ?>
        </div>
        <div class="mt-8 pt-6 border-t border-admin-border">
            <a href="mailto:<?= htmlspecialchars($viewItem['email'] ?? '') ?>?subject=Re: <?= urlencode($viewItem['subjek'] ?? '') ?>" class="inline-flex items-center gap-2 bg-admin-primary hover:bg-admin-primary-light text-white px-5 py-2.5 rounded-lg transition-colors">
                <span class="material-symbols-outlined text-sm">reply</span>
                Balas via Email
            </a>
        </div>
    </div>
    <?php else: ?>
    
    <div class="bg-admin-surface rounded-xl border border-admin-border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-admin-surface-light border-b border-admin-border text-admin-text-muted">
                        <th class="p-4 font-medium text-sm w-10">Status</th>
                        <th class="p-4 font-medium text-sm">Pengirim</th>
                        <th class="p-4 font-medium text-sm">Subjek & Pesan</th>
                        <th class="p-4 font-medium text-sm">Tanggal</th>
                        <th class="p-4 font-medium text-sm text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-admin-border">
                    <?php if (empty($messages)): ?>
                    <tr>
                        <td colspan="5" class="p-8 text-center text-admin-text-muted">Belum ada pesan masuk.</td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($messages as $msg): ?>
                    <?php $isRead = !empty($msg['read']); ?>
                    <tr class="hover:bg-admin-surface-light/50 transition-colors cursor-pointer <?= $isRead ? 'opacity-80' : 'bg-admin-surface-light/20' ?>" onclick="window.location.href='?view=<?= htmlspecialchars($msg['id']) ?>'">
                        <td class="p-4 text-center">
                            <?php if (!$isRead): ?>
                            <span class="w-3 h-3 rounded-full bg-admin-danger inline-block"></span>
                            <?php else: ?>
                            <span class="w-3 h-3 rounded-full bg-admin-border inline-block"></span>
                            <?php endif; ?>
                        </td>
                        <td class="p-4">
                            <div class="font-medium <?= $isRead ? 'text-admin-text-muted' : 'text-admin-text' ?>">
                                <?= htmlspecialchars($msg['nama'] ?? '') ?>
                            </div>
                            <div class="text-xs text-admin-text-muted"><?= htmlspecialchars($msg['email'] ?? '') ?></div>
                        </td>
                        <td class="p-4 max-w-md">
                            <div class="font-medium <?= $isRead ? 'text-admin-text-muted' : 'text-admin-text' ?> truncate">
                                <?= htmlspecialchars($msg['subjek'] ?? '(Tanpa Subjek)') ?>
                            </div>
                            <div class="text-sm text-admin-text-muted truncate">
                                <?= htmlspecialchars($msg['pesan'] ?? '') ?>
                            </div>
                        </td>
                        <td class="p-4 text-sm text-admin-text-muted whitespace-nowrap">
                            <?= htmlspecialchars($msg['created_at'] ?? '') ?>
                        </td>
                        <td class="p-4" onclick="event.stopPropagation();">
                            <div class="flex items-center justify-end gap-2">
                                <form action="api/delete.php" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus pesan ini?');">
                                    <input type="hidden" name="type" value="messages">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($msg['id']) ?>">
                                    <button type="submit" class="p-2 text-admin-text-muted hover:text-admin-danger transition-colors bg-admin-surface-light rounded-lg border border-admin-border" title="Hapus">
                                        <span class="material-symbols-outlined text-sm">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <?php endif; ?>
  </div>
</main>
</body></html>
