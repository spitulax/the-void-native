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

<div>
    <h1>Like (<?= h($likeNum) ?>)</h1>

    <?php while ($user = $likes->fetch_assoc()): ?>
        <div class="border m-2">
            <a href="/user/view.php?user=<?= urlencode($user['id']) ?>">
                <b><?= h($user['name']) ?></b>
                <i><?= h('@' . $user['username']) ?></i>
            </a>
        </div>
    <?php endwhile; ?>
</div>
