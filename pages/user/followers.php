<?php

require_once 'system/main.php';
require_once 'system/response.php';
require_once 'system/tables/post.php';
require_once 'components/post.php';
require_once 'components/backButton.php';
require_once 'components/userList.php';
require_once 'components/topNav.php';

$userId = get('user');
if (!$userId) {
    Response::notFound();
}

$user = UserTable::fromId($userId);
if (!$user) {
    Response::notFound();
}

$followNum = UserTable::follows($userId);
$follows = UserTable::getFollows($userId);

$layout = new HTML('The Void: @' . $user['username']);

?>

<div class="flex-1 p-2 md:p-4">
    <?php topNav('@' . $user['username']); ?>

    <div class="flex gap-2 items-center">
        <div class="flex w-full items-center">
            <h1 class="font-bold text-3xl mx-2 my-heading"> Pengikut (<?= h($followNum) ?>)</h1>
        </div>
    </div>

    <hr class="text-gray my-2" />

    <?php userList($follows, Auth::user(), 'Belum ada pengikut.'); ?>
</div>
