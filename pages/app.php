<?php

require_once 'system/auth.php';
require_once 'system/main.php';
require_once 'system/tables/post.php';
require_once 'components/button.php';
require_once 'components/post.php';

$user = Auth::user();

$posts = PostTable::allCanView();

$layout = new HTML('The Void');

?>


<div>
    <h1>The Void</h1>
    <?php if ($user): ?>
        <h2>Selamat Datang <?= h($user['name']) ?>!</h2>
        <?php if ($user['admin']): ?>
            <?php button('get', '/admin/dashboard.php', 'DASHBOARD'); ?>
        <?php endif; ?>
        <?php button('get', '/post.php', 'POST'); ?>
        <?php button('post', '/logout', 'KELUAR'); ?>
    <?php else: ?>
        <h2>Selamat Datang!</h2>
        <?php button('get', '/login.php', 'MASUK'); ?>
        <?php button('get', '/register.php', 'DAFTAR'); ?>
    <?php endif; ?>

    <?php while ($post = $posts->fetch_assoc()): ?>
        <?php post($post) ?>
    <?php endwhile; ?>
</div>
