<?php

require_once 'system/auth.php';
require_once 'system/main.php';
require_once 'system/response.php';
require_once 'system/tables/user.php';
require_once 'components/backButton.php';
require_once 'components/topNav.php';

$authUser = Auth::user();
if (!$authUser) {
    Response::login();
}

$username = get('user');
if (!$username) {
    Response::notFound();
}

$user = UserTable::from('username', $username, 's');
if (!$user) {
    Response::notFound();
}

if (!UserTable::canEdit($user['id'], $authUser)) {
    Response::notFound();
}

$userId = $user['id'];

$errors = flash('validation_errors') ?? [];

$layout = new HTML('The Void: Ubah Password');

// TODO: Retain form values after refresh
?>

<div class="flex-1">
    <?php topNav('Ubah Password'); ?>

    <div class="flex flex-col gap-2 items-center justify-center py-2">
        <div class="flex gap-2 items-center justify-center">
            <span class="font-bold"><?= $user['name'] ?> </span>
            <span class="font-bold text-xl">·</span>
            <span class="text-light-gray"><?= h('@' . $user['username']) ?></span>
        </div>
    </div>

    <form method="post" action="/user/change-password" class="mx-4">
        <input type="hidden" name="id" value="<?= $userId ?>">

        <input type="password" name="old_password" placeholder="Masukkan password lama..." required />
        <?php if ($errors['old_password'] ?? false): ?>
            <div class="my-error"><?= h($errors['old_password']) ?></div>
        <?php endif; ?>

        <input type="password" name="new_password" placeholder="Masukkan password baru..." required />
        <?php if ($errors['new_password'] ?? false): ?>
            <div class="my-error"><?= h($errors['new_password']) ?></div>
        <?php endif; ?>

        <input type="password" name="confirm_password" placeholder="Konfirmasi password baru..." required />
        <?php if ($errors['confirm_password'] ?? false): ?>
            <div class="my-error"><?= h($errors['confirm_password']) ?></div>
        <?php endif; ?>

        <?php if ($msg = flash('error')): ?>
            <div class="my-error"><?= h($msg) ?></div>
        <?php endif; ?>

        <button type="submit" class="my-button">UBAH</button>
    </form>
</div>
