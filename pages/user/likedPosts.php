<?php

use Couchbase\UserAndMetadata;

require_once 'system/main.php';
require_once 'system/response.php';
require_once 'system/tables/post.php';
require_once 'components/post.php';
require_once 'components/backButton.php';
require_once 'components/userList.php';
require_once 'components/topNav.php';

$username = get('user');
if (!$username) {
    Response::notFound();
}

$user = UserTable::from('username', $username, 's');
if (!$user) {
    Response::notFound();
}

if (!UserTable::canEdit($user['id'], Auth::user())) {
    Response::notFound();
}

$userId = $user['id'];

$likedPosts = UserTable::getLikedPost($userId);

$layout = new HTML('The Void: Post Disukai');

?>

<div class="flex-1 p-2 md:p-4">
    <?php topNav('Post Disukai'); ?>

    <div class="flex flex-col">
    <?php while ($post = $likedPosts->fetch_assoc()): ?>
        <?php post($post); ?>
    <?php endwhile; ?>
    </div>
</div>
