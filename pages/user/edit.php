<?php

require_once 'system/auth.php';
require_once 'system/main.php';
require_once 'system/response.php';
require_once 'system/tables/user.php';

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

<h2>Mengedit <b><?= h($user['name']) ?></b> <?= h('@' . $user['username']) ?></h2>

<hr />

<form method="post" action="/user/edit">
    <input type="hidden" name="id" value="<?= $userId ?>">

    <input type="text" name="username" value="<?= $user['username'] ?>" required />
    <?php if ($errors['username'] ?? false): ?>
        <div><?= h($errors['username']) ?></div>
    <?php endif; ?>

    <input type="text" name="name" value="<?= $user['name'] ?>" required />
    <?php if ($errors['name'] ?? false): ?>
        <div><?= h($errors['name']) ?></div>
    <?php endif; ?>

    <textarea class="block border" name="bio" placeholder="Tulis biomu di sini..."><?= h($user['bio'] ?? '') ?></textarea>
    <?php if ($errors['bio'] ?? false): ?>
        <div><?= h($errors['bio']) ?></div>
    <?php endif; ?>

    <button type="submit">EDIT</button>
</form>
