<?php

require_once 'system/auth.php';
require_once 'system/main.php';
require_once 'system/response.php';
require_once 'components/topNav.php';

$user = Auth::user();

if (!$user) {
    Response::login();
}

$errors = flash('validation_errors') ?? [];

$layout = new HTML('The Void: Posting');

// TODO: Retain form values after refresh
?>

<div class="flex-1">
    <?php topNav('Posting'); ?>

    <div class="border rounded-xs border-gray m-4 lg:m-8 px-1">
        <div class="flex justify-between items-center h-10 px-1 py-1">
            <div class=" flex items-center rounded-xs px-1 h-full">
                <span class="font-bold"><?= h($user['name']) ?></span>
                <span class="font-bold text-xl mx-1">·</span>
                <?= h('@' . $user['username']) ?>
            </div>
        </div>

        <hr class="text-gray" />

        <form method="post" action="/post">
            <div class="flex flex-col w-full px-4 py-4 justify-center items-center gap-4">
                <div class="flex w-fit justify-start gap-2 items-center self-start">
                    <input type="checkbox" id="private" name="private" />
                    <label for="private" class="font-bold">Pribadi</label>
                </div>
                <?php if ($errors['private'] ?? false): ?>
                    <div class="my-error"><?= h($errors['private']) ?></div>
                <?php endif; ?>

                <textarea class="min-h-10 h-[50vh]" name="text" placeholder="Tulis postinganmu di sini..."
                ></textarea>
                <?php if ($errors['text'] ?? false): ?>
                    <div class="my-error"><?= h($errors['text']) ?></div>
                <?php endif; ?>

                <button type="submit" class="my-button text-lg my-4">POST</button>
            </div>
        </form>
    </div>
</div>
