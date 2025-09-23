
<?php

require_once 'system/auth.php';
require_once 'system/main.php';
require_once 'system/response.php';
require_once 'components/button.php';

$userId = get('user');
if (!$userId) {
    Response::notFound();
}

$user = UserTable::fromId($userId);
if (!$user) {
    Response::notFound();
}

$authUser = Auth::user();

$errors = flash('validation_errors') ?? [];

$layout = new HTML('The Void: @' . $user['username']);

?>

<div>
    <div>
        <div class="flex gap-2 items-center">
            <h1><?= $user['name'] ?> </h1>
            <i>@<?= $user['username'] ?></i>
            <?php if ($user['admin']): ?>
                <b>[ADMIN]</b>
            <?php endif; ?>
        </div>
     
        <?php if (UserTable::canEdit($userId, $authUser)): ?>
            <?php button('get', '/user/edit.php', 'EDIT', data: ['user' => $userId]); ?>
        <?php endif; ?>

        <?php if (UserTable::canDelete($userId, $authUser)): ?>
            <div
                data-component="user-delete"
                data-username="<?= $user['username'] ?>"
            >
                <?php button('post', '/user/delete', 'HAPUS', data: ['id' => $userId]); ?>
            </div>
        <?php endif; ?>

        <div
            data-component="user-follow"
            data-id="<?= $userId ?>"
            data-follows="<?= UserTable::follows($userId) ?>"
            data-followed="<?= $user ? UserTable::userFollowed($userId, $authUser['id']) : false ?>"
        >
            <button type="button">IKUTI</button>
            <a href="/user/followers.php?user=<?= urlencode($userId) ?>">
                <span><?= UserTable::follows($userId) ?></span>
            </a>
        </div>

        <?php if ($user['admin']): ?>
            <?php button('get', '/admin/dashboard.php', 'DASHBOARD'); ?>
        <?php endif; ?>
    </div>

    <hr class="my-6">

    <span class="whitespace-pre-wrap"><?= ($bio = $user['bio']) ? h($bio) : '<i>Tidak ada bio.</i>' ?></span>
</div>

<script src="/src/js/confirmUserDelete.ts"></script>
<script src="/src/js/userFollow.ts"></script>
