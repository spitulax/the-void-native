<?php

require_once 'system/auth.php';
require_once 'system/main.php';
require_once 'system/response.php';

$user = Auth::user();
if (!$user) {
    Response::login();
}

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

$errors = flash('validation_errors') ?? [];

$layout = new HTML('The Void: Edit Postingan');

// TODO: Retain form values after refresh
?>

<h2>Memposting sebagai <b><?= h($user['name']) ?></b> <?= h('@' . $user['username']) ?></h2>

<hr />

<form method="post" action="/post/edit">
    <input type="hidden" name="id" value="<?= $postId ?>">
    <input type="hidden" name="parent_id" value="<?= $post['parent_id'] ?? 0 ?>">

    <?php if (!$post['parent_id']): ?>
        <div class="flex">
            <label for="private">Pribadi</label>
            <input
                type="checkbox"
                id="private"
                name="private"
                <?php if ($post['private']): ?>
                    checked
                <?php endif; ?>
            >
        </div>
        <?php if ($errors['private'] ?? false): ?>
            <div><?= h($errors['private']) ?></div>
        <?php endif; ?>
    <?php endif; ?>

    <textarea class="block border" name="text"><?= h($post['text']) ?></textarea>
    <?php if ($errors['text'] ?? false): ?>
        <div><?= h($errors['text']) ?></div>
    <?php endif; ?>

    <button type="submit">EDIT</button>
</form>
