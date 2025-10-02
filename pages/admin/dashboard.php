<?php

require_once 'system/auth.php';
require_once 'system/main.php';
require_once 'system/redirect.php';
require_once 'system/response.php';
require_once 'system/tables/user.php';
require_once 'components/button.php';
require_once 'components/confirmDialog.php';

if (!Auth::isAdmin()) {
    Response::notFound();
}

$user_query = UserTable::all();

$layout = new HTML('The Void: Dashboard Admin');

?>

<script src="/src/js/confirmDialog.ts"></script>
<script src="/src/js/confirmUserDelete.ts"></script>

<div class="flex-1 p-2 md:p-4 flex flex-col gap-4 divide-y-2 divide-dark-gray">
    <h1 class="my-heading text-4xl font-bold">Dashboard Admin</h1>

    <h2 class="my-heading text-2xl font-bold">Pengguna</h2>

    <table class="border-2 border-accent divide-y-2 divide-accent rounded-xs w-full max-w-fit">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Nama</th>
                <th>Admin</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-accent-light">
            <?php while ($user = $user_query->fetch_assoc()): ?>
            <tr>
                <td class="font-bold"><?= h($user['id']) ?> </td>
                <td class="font-bold"><?= h($user['username']) ?> </td>
                <td><?= h($user['name']) ?> </td>
                <td><?= '<div class="flex items-center justify-center">' .
                ($user['admin'] ? '
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="size-5 fill-accent">
                          <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                        </svg>
                    ' : '
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="size-5 fill-gray">
                          <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd" />
                        </svg>
                    ') .
                    '</div>' ?></td>
                <td>
                    <?php confirmDialog(
                        strval($user['id']),
                        'Apakah Anda yakin ingin menghapus pengguna?',
                        'confirmUserDelete',
                        true,
                    ); ?>
                    <button type="button" onclick="showConfirm('<?= $user['id'] ?>')" class="p-1 hover:text-red cursor-pointer transition">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                          <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <?php if ($msg = flash('error')): ?>
        <div class="my-error"><?= h($msg) ?></div>
    <?php elseif ($msg = flash('success')): ?>
        <div class="my-error"><?= h($msg) ?></div>
    <?php endif; ?>
</div>
