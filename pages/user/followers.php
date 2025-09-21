<?php

require_once 'system/main.php';
require_once 'system/response.php';
require_once 'system/tables/post.php';
require_once 'components/post.php';

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

<div>
    <h1>Pengikut (<?= h($followNum) ?>)</h1>

    <?php while ($user = $follows->fetch_assoc()): ?>
        <div class="border m-2">
            <a href="/user/view.php?user=<?= urlencode($user['id']) ?>">
                <b><?= h($user['name']) ?></b>
                <i><?= h('@' . $user['username']) ?></i>
            </a>
        </div>
    <?php endwhile; ?>
</div>
