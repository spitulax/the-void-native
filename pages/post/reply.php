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

<div class="flex-1">
    <div class="mt-2 ml-2">
        <?php backButton(); ?>
    </div>

    <?php post($post); ?>

    <div class="mx-8">
        <div class="border rounded-xs border-gray m-4 lg:m-8 px-1">
            <div class="flex justify-between items-center h-10 px-1 py-1">
                <div class=" flex items-center rounded-xs px-1 h-full">
                    <span class="font-bold"><?= h($user['name']) ?></span>
                    <span class="font-bold text-xl mx-1">·</span>
                    <?= h('@' . $user['username']) ?>
                </div>
            </div>

            <hr class="text-gray" />

            <form method="post" action="/post/reply">
                <div class="flex flex-col w-full px-4 py-4 justify-center items-center gap-4">
                    <input type="hidden" name="parent_id" value="<?= $postId ?>">

                    <textarea class="min-h-10 h-[30vh]" name="text" placeholder="Tulis balasanmu di sini..."
                    ></textarea>
                    <?php if ($errors['text'] ?? false): ?>
                        <div class="my-error"><?= h($errors['text']) ?></div>
                    <?php endif; ?>

                    <button type="submit" class="my-button text-lg my-4">POST</button>
                </div>
            </form>
        </div>
    </div>
</div>
