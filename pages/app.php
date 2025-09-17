<?php

require_once 'system/main.php';
require_once 'system/auth.php';
require_once 'components/button.php';

$layout = new HTML('The Void');

$user = Auth::user();
?>

<div>
    <h1>The Void</h1>
    <?php if ($user): ?>
        <h2>Welcome <?= h($user['name']) ?>!</h2>
        <?php if ($user['admin']): ?>
            <?php button('get', '/admin/dashboard.php', 'DASHBOARD'); ?>
        <?php endif; ?>
        <?php button('post', '/logout', 'KELUAR'); ?>
    <?php else: ?>
        <h2>Welcome Guest!</h2>
        <?php button('get', '/login.php', 'MASUK'); ?>
    <?php endif; ?>
</div>
