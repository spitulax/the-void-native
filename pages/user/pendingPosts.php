
<?php

require_once 'system/main.php';
require_once 'system/response.php';
require_once 'system/tables/post.php';
require_once 'components/post.php';
require_once 'components/backButton.php';
require_once 'components/userList.php';
require_once 'components/topNav.php';

$user = Auth::user();

if (!$user) {
    Response::notFound();
}

$posts = PostTable::allNotApproved(authorId: $user['id']);

$layout = new HTML('The Void: Antrean Postingan');

?>

<div class="flex-1 p-2 md:p-4">
    <?php topNav('Antrean Postingan'); ?>

    <div class="flex flex-col">
        <?php $hasPost = false; ?>
        <?php while ($post = $posts->fetch_assoc()): ?>
            <?php $hasPost = true; ?>
            <?php post($post); ?>
        <?php endwhile; ?>

        <?php if (!$hasPost): ?>
        <span
            class="text-center text-light-gray w-full italic"
        >
            Belum ada postingan.
            <br />
            Silahkan memposting terlebih dahulu.
        </span>
        <?php endif; ?>
    </div>
</div>
