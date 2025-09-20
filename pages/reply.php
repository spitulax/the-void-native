<?php

require_once 'system/auth.php';
require_once 'system/main.php';
require_once 'system/response.php';
require_once 'components/post.php';

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

$author = PostTable::author($postId);

$errors = flash('validation_errors') ?? [];

$layout = new HTML('The Void: Membalas postingan oleh @' . $author['username']);

// TODO: Retain form values after refresh
?>

<?php post($post); ?>

<h2>Membalas sebagai <b><?= h($user['name']) ?></b> <?= h('@' . $user['username']) ?></h2>

<hr />

<form method="post" action="/post/reply">
    <input type="hidden" name="parent_id" value="<?= $postId ?>">

    <textarea class="block border" name="text" placeholder="Tulis balasanmu di sini..."
    ></textarea>
    <?php if ($errors['text'] ?? false): ?>
        <div><?= h($errors['text']) ?></div>
    <?php endif; ?>

    <button type="submit">BALAS</button>
</form>
