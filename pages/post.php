<?php

require_once 'system/auth.php';
require_once 'system/main.php';
require_once 'system/response.php';

$user = Auth::user();

if (!$user) {
    Response::login();
}

$errors = flash('validation_errors') ?? [];

$layout = new HTML('The Void: Posting');

// TODO: Retain form values after refresh
?>

<h2>Memposting sebagai <b><?= h($user['name']) ?></b> <?= h('@' . $user['username']) ?></h2>

<hr />

<form method="post" action="/post">
    <div class="flex">
        <label for="private">Pribadi</label>
        <input type="checkbox" name="private" />
    </div>
    <?php if ($errors['private'] ?? false): ?>
        <div><?= h($errors['private']) ?></div>
    <?php endif; ?>

    <textarea class="block border" name="text" placeholder="Tulis postinganmu di sini..."
    ></textarea>
    <?php if ($errors['text'] ?? false): ?>
        <div><?= h($errors['text']) ?></div>
    <?php endif; ?>

    <button type="submit">POST</button>
</form>
