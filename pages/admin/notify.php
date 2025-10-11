<?php

require_once 'system/auth.php';
require_once 'system/main.php';
require_once 'system/response.php';
require_once 'system/tables/user.php';
require_once 'components/topNav.php';

if (!Auth::isAdmin()) {
    Response::notFound();
}

$username = get('user');
if (!$username) {
    Response::notFound();
}

$user = UserTable::from('username', $username, 's');
if (!$user) {
    Response::notFound();
}

$errors = flash('validation_errors') ?? [];

$layout = new HTML('The Void: Mengirim notifikasi ke @' . $username);

// TODO: Retain form values after refresh
?>

<div class="flex-1">
    <?php topNav('Mengirim notifikasi ke @' . $username); ?>

    <div class="mx-8">
        <div class="border rounded-xs border-gray m-4 lg:m-8 px-1">
            <div class="flex justify-between items-center h-10 px-1 py-1">
                <div class=" flex items-center rounded-xs px-1 h-full">
                    <span class="font-bold">Mengirim ke @<?= h($username) ?></span>
                </div>
            </div>

            <hr class="text-gray" />

            <form id="notify-form" method="post">
                <input type="hidden" name="id" value="<?= $user['id'] ?>">
                <input type="hidden" name="heading" value="Notifikasi dari admin.">

                <div class="flex flex-col w-full px-4 py-4 justify-center items-center gap-4">
                    <textarea class="min-h-10 h-[30vh]" name="text" placeholder="Tulis isi notifikasi di sini..."
                    ></textarea>
                    <?php if ($errors['text'] ?? false): ?>
                        <div class="my-error"><?= h($errors['text']) ?></div>
                    <?php endif; ?>

                    <button type="submit" class="my-button text-lg my-4">KIRIM</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="/src/js/admin/notify.ts"></script>
