<?php

require_once 'system/main.php';
require_once 'system/redirect.php';

$errors = flash('validation_errors') ?? [];

$layout = new HTML('The Void: Masuk');

// TODO: Retain form values after refresh
?>

<div class="flex flex-1 justify-center items-center">
    <div class="p-10 lg:p-12 w-1/2 bg-base-dark rounded-xs shadow-md shadow-black flex flex-col justify-center items-center gap-10">
        <h1 class="uppercase font-bold text-3xl text-center w-full">Masuk</h1>

        <form method="post" action="/login" class="w-full px-2">
            <input
                type="text"
                name="username"
                placeholder="Masukkan username"
                required
            />
            <?php if ($errors['username'] ?? false): ?>
                <div class="my-error"><?= h($errors['username']) ?></div>
            <?php endif; ?>

            <input
                type="password"
                name="password"
                placeholder="Masukkan password"
                required
            />
            <?php if ($errors['password'] ?? false): ?>
                <div class="my-error"><?= h($errors['password']) ?></div>
            <?php endif; ?>

            <?php if ($msg = flash('error')): ?>
                <div class="my-error"><?= h($msg) ?></div>
            <?php endif; ?>

            <button type="submit" class="px-3 py-1 text-lg rounded-xs border-2 border-accent bg-transparent text-white font-bold cursor-pointer hover:border-transparent hover:bg-accent-dark transition mt-4">MASUK</button>
        </form>
    </div>
</div>
