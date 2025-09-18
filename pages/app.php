<?php

require_once 'system/auth.php';
require_once 'system/main.php';
require_once 'system/tables/post.php';
require_once 'components/button.php';

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
        <?php $id = intval($post['id']); ?>
        <div class="border m-2">
            <div>
                ID: <?= h($id) ?>
            </div>
            <div>
                Author:
                <?php if ($author = PostTable::author($id)): ?>
                    <b><?= h($author['name']) ?></b>
                    <i><?= h('@' . $author['username']) ?></i>
                    <?php if ($post['private']): ?>
                        <i>(Private)</i>
                    <?php endif; ?>
                <?php else: ?>
                    <i>[Deleted]</i>
                <?php endif; ?>
            </div>
            <hr class="mx-2 text-gray-400" />
            <p><?= h($post['text']) ?></p>
            <!-- <div> -->
            <!--     <button -->
            <!--         use:inertia={{ href: `/posts/${post.id}/like`, method: "post" }} -->
            <!--         onclick={toggleLike} -->
            <!--         class={liked ? "font-bold" : ""}>LIKE</button -->
            <!--     > -->
            <!--     {likes} -->
            <!--     {#if permissions && permissions.delete} -->
            <!--     <button -->
            <!--         use:inertia={{ href: `/posts/${post.id}`, method: "delete" }} -->
            <!--     >DELETE</button -->
            <!--     > -->
            <!--     {/if} -->
            </div>
        </div>
    <?php endwhile; ?>
</div>
