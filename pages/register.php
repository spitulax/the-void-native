<?php

require_once 'system/main.php';

$errors = flash('validation_errors') ?? [];

$layout = new HTML('The Void: Daftar');

// TODO: Retain form values after refresh
?>

<div class="flex flex-1 justify-center items-center gap-8 md:gap-20 flex-col md:flex-row py-10">
    <div class="flex items-center justify-center gap-1 flex-row md:flex-col">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 4.233 4.233" class="size-16 md:size-64">
          <path d="M2.12.617a1.5 1.5 0 0 0-.773.212l.305.518a.9.9 0 0 1 .468-.127.9.9 0 0 1 .461.127L2.893.83A1.5 1.5 0 0 0 2.12.617M.915 1.22a1.5 1.5 0 0 0-.298.9A1.504 1.504 0 0 0 2.12 3.617 1.504 1.504 0 0 0 3.617 2.12a1.5 1.5 0 0 0-.298-.9l-.369.553a.9.9 0 0 1 .07.347.9.9 0 0 1-.9.9.9.9 0 0 1-.9-.9.9.9 0 0 1 .063-.347Zm1.205.418a.48.48 0 0 0-.482.482.48.48 0 0 0 .482.475.48.48 0 0 0 .475-.475.48.48 0 0 0-.475-.482" style="fill:#fff"/>
        </svg>
        <span class="font-extrabold text-3xl my-heading">The Void</span>
    </div>

    <div class="p-10 lg:p-12 w-3/4 md:w-1/2 bg-base-light rounded-xs shadow-md shadow-black flex flex-col justify-center items-center gap-10">
        <h1 class="uppercase font-bold text-3xl text-center w-full my-heading">Daftar</h1>

        <form method="post" action="/register" class="w-full px-2">
            <input type="text" name="username" placeholder="Masukkan username" required />
            <?php if ($errors['username'] ?? false): ?>
                <div class="my-error"><?= h($errors['username']) ?></div>
            <?php endif; ?>

            <input type="text" name="name" placeholder="Masukkan nama" required />
            <?php if ($errors['name'] ?? false): ?>
                <div class="my-error"><?= h($errors['name']) ?></div>
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

            <input
                type="password"
                name="confirm_password"
                placeholder="Konfirmasi password"
                required
            />
            <?php if ($errors['confirm_password'] ?? false): ?>
                <div class="my-error"><?= h($errors['confirm_password']) ?></div>
            <?php endif; ?>

            <?php if ($msg = flash('error')): ?>
                <div class="my-error"><?= h($msg) ?></div>
            <?php endif; ?>

            <button type="submit" class="px-3 py-1 text-lg rounded-xs border-2 border-accent bg-transparent text-white font-bold cursor-pointer hover:border-transparent hover:bg-accent-dark transition mt-4">DAFTAR</button>
        </form>
    </div>
</div>
