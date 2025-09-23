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

PostTable::view($post);

$user = Auth::user();
$author = PostTable::author($postId);

$layout = new HTML('The Void: Postingan oleh @' . $author['username']);

post($post, true);
