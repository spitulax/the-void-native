<?php

require_once 'system/main.php';
require_once 'system/response.php';
require_once 'system/tables/post.php';
require_once 'components/post.php';

$postId = get('post');
if (!$postId) {
    Response::notFound();
}

$post = PostTable::fromId($postId);
if (!$post) {
    Response::notFound();
} elseif ($post && !PostTable::canView($post, Auth::user())) {
    Response::notFound();
}

$author = PostTable::author($postId);
$likeNum = PostTable::likes($postId);
$likes = PostTable::getLikes($postId);

$layout = new HTML('The Void: Postingan oleh @' . $author['username']);

?>

<div class="flex-1 p-2 md:p-4">
    <h1 class="font-bold text-3xl">Like (<?= h($likeNum) ?>)</h1>

    <hr class="text-gray my-2" />

    <div class="flex flex-col items-center gap-2 py-2">
        <?php $hasLikes = false; ?>
        <?php while ($user = $likes->fetch_assoc()): ?>
            <?php $hasLikes = true; ?>
            <a href="/user/view.php?user=<?= urlencode($user['id']) ?>" class="flex gap-2 border border-light-gray rounded-xs p-2 w-full hover:border-text hover:bg-dark-gray transition items-center">
                <span class="font-bold"><?= h($user['name']) ?></span>
                <span class="font-bold text-xl">·</span>
                <span class="text-light-gray"><?= h('@' . $user['username']) ?></span>
                <!-- TODO: Add follow button here -->
            </a>
        <?php endwhile; ?>

        <?php if (!$hasLikes): ?>
            <span class="italic text-light-gray">Belum ada like.</span>
        <?php endif; ?>
    </div>
</div>
