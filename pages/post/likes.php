<?php

require_once 'system/main.php';
require_once 'system/response.php';
require_once 'system/tables/post.php';
require_once 'components/post.php';
require_once 'components/backButton.php';
require_once 'components/userList.php';

$postId = get('post');
if (!$postId) {
    Response::notFound();
}

$user = Auth::user();

$post = PostTable::fromId($postId);
if (!$post) {
    Response::notFound();
} elseif ($post && !PostTable::canView($post, $user)) {
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
            <?php backButton(); ?>
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

    <?php userList($likes, $user, 'Belum ada like.'); ?>
</div>
