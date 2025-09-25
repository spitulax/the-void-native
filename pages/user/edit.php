<?php

require_once 'system/auth.php';
require_once 'system/main.php';
require_once 'system/response.php';
require_once 'system/tables/user.php';
require_once 'components/backButton.php';

$user = Auth::user();
if (!$user) {
    Response::login();
}

$userId = get('user');
if (!$userId) {
    Response::notFound();
}

if (!UserTable::canEdit($userId, $user)) {
    Response::notFound();
}

$user = UserTable::fromId($userId);
if (!$user) {
    Response::notFound();
}

$errors = flash('validation_errors') ?? [];

$layout = new HTML('The Void: Edit Profil');

// TODO: Retain form values after refresh
?>

<div class="flex-1">
    <div class="mt-1 ml-2">
        <?php backButton(); ?>
    </div>

    <div class="flex gap-2 items-center justify-center py-2">
        <span class="font-bold"><?= $user['name'] ?> </span>
        <span class="font-bold text-xl">·</span>
        <span class="text-light-gray"><?= h('@' . $user['username']) ?></span>
    </div>

    <form method="post" action="/user/edit" class="mx-4">
        <input type="hidden" name="id" value="<?= $userId ?>">

        <input type="text" name="username" value="<?= $user['username'] ?>" required />
        <?php if ($errors['username'] ?? false): ?>
            <div class="my-error"><?= h($errors['username']) ?></div>
        <?php endif; ?>

        <input type="text" name="name" value="<?= $user['name'] ?>" required />
        <?php if ($errors['name'] ?? false): ?>
            <div class="my-error"><?= h($errors['name']) ?></div>
        <?php endif; ?>

        <textarea class="min-h-10 h-[30vh]" name="bio" placeholder="Tulis biomu di sini..."><?= h($user['bio'] ?? '') ?></textarea>
        <?php if ($errors['bio'] ?? false): ?>
            <div class="my-error"><?= h($errors['bio']) ?></div>
        <?php endif; ?>

        <button type="submit" class="my-button">EDIT</button>
    </form>
<div>
