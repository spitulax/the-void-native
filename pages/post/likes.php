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
    <div class="flex gap-2 items-center">
        <div class="flex w-full items-center">
            <button type="button" onclick="history.back();" class="cursor-pointer hover:bg-dark-gray w-fit p-1 rounded-full flex items-center transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-8">
                  <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 9-3 3m0 0 3 3m-3-3h7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </button>
            <h1 class="font-bold text-3xl mx-2">Like (<?= h($likeNum) ?>)</h1>
        </div>
        <?php button(
            'get',
            '/post/view.php',
            '
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-8">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                </svg>
            ',
            'cursor-pointer hover:bg-dark-gray w-fit p-1 rounded-xs flex items-center transition',
            data: [
                'post' => $postId,
            ],
        ); ?>
    </div>

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
