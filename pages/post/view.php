<?php

require_once 'system/main.php';
require_once 'system/response.php';
require_once 'system/tables/post.php';
require_once 'components/post.php';
require_once 'components/topNav.php';

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

if ($post['approved']) {
    PostTable::view($post);
}

$user = Auth::user();
$author = PostTable::author($postId);

$layout = new HTML('The Void: Postingan oleh @' . $author['username']);

?>

<div class="flex-1 p-2">
    <?php topNav('Postingan oleh @' . $author['username']); ?>

    <?php post($post, 'detailed'); ?>
</div>
