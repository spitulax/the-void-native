<?php

require_once 'system/auth.php';
require_once 'system/main.php';
require_once 'system/tables/post.php';
require_once 'components/button.php';
require_once 'components/post.php';

$user = Auth::user();

$posts = PostTable::all();

$layout = new HTML('The Void');

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

    <?php while ($post = $posts->fetch_assoc()): ?>
        <?php post($post) ?>
    <?php endwhile; ?>
</div>
