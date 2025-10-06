<?php

require_once 'system/auth.php';
require_once 'system/main.php';
require_once 'system/redirect.php';
require_once 'system/response.php';
require_once 'system/tables/user.php';
require_once 'components/button.php';
require_once 'components/confirmDialog.php';
require_once 'components/topNav.php';

if (!Auth::isAdmin()) {
    Response::notFound();
}

$user_query = UserTable::all();

$layout = new HTML('The Void: Dashboard Admin');

?>

<script src="/src/js/confirmDialog.ts"></script>
<script src="/src/js/confirmUserDelete.ts"></script>

<div class="flex-1 p-2 md:p-4 flex flex-col">
    <?php topNav('Dashboard Admin'); ?>

    <div class="flex flex-col gap-4 divide-y-2 divide-gray">
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
                    <td><?= '<div class="flex items-center justify-center">'
                    . ($user['admin'] ? '
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="size-5 fill-accent">
                              <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                            </svg>
                        ' : '
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="size-5 fill-gray">
                              <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd" />
                            </svg>
                        ')
                        . '</div>' ?></td>
                    <td>
                        <div class="flex items-center justify-center">
                            <?php confirmDialog(
                                strval($user['id']),
                                'Apakah Anda yakin ingin menghapus pengguna?',
                                'confirmUserDelete',
                                true,
                            ); ?>
                            <?php $class = 'p-1 cursor-pointer transition'; ?>
                            <button type="button" onclick="showConfirm('<?= $user['id'] ?>')" class="<?= $class ?> hover:text-red">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                                    <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <?php button(
                                'get',
                                '/admin/notify.php',
                                '
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                                    <path d="M5.85 3.5a.75.75 0 0 0-1.117-1 9.719 9.719 0 0 0-2.348 4.876.75.75 0 0 0 1.479.248A8.219 8.219 0 0 1 5.85 3.5ZM19.267 2.5a.75.75 0 1 0-1.118 1 8.22 8.22 0 0 1 1.987 4.124.75.75 0 0 0 1.48-.248A9.72 9.72 0 0 0 19.266 2.5Z" />
                                    <path fill-rule="evenodd" d="M12 2.25A6.75 6.75 0 0 0 5.25 9v.75a8.217 8.217 0 0 1-2.119 5.52.75.75 0 0 0 .298 1.206c1.544.57 3.16.99 4.831 1.243a3.75 3.75 0 1 0 7.48 0 24.583 24.583 0 0 0 4.83-1.244.75.75 0 0 0 .298-1.205 8.217 8.217 0 0 1-2.118-5.52V9A6.75 6.75 0 0 0 12 2.25ZM9.75 18c0-.034 0-.067.002-.1a25.05 25.05 0 0 0 4.496 0l.002.1a2.25 2.25 0 1 1-4.5 0Z" clip-rule="evenodd" />
                                </svg>
                                ',
                                $class . ' hover:text-accent',
                                [
                                    'user' => $user['username'],
                                ],
                            ); ?>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <?php if ($msg = flash('error')): ?>
        <div class="my-error"><?= h($msg) ?></div>
    <?php elseif ($msg = flash('success')): ?>
        <div class="my-error"><?= h($msg) ?></div>
    <?php endif; ?>
</div>
