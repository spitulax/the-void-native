<?php

require_once 'system/main.php';
require_once 'system/response.php';
require_once 'system/tables/notif.php';
require_once 'components/topNav.php';

$user = Auth::user();
if (!$user) {
    Response::notFound();
}

$notifs = NotifTable::getNotifs($user['id']);

$layout = new HTML('The Void: Notifikasi');

?>

<div class="flex-1 p-2 md:p-4">
    <?php topNav('', '
        <button id="clear-all" type="button" class="flex justify-center items-center hover:text-red cursor-pointer transition">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd" />
            </svg>
        </button>
    '); ?>

    <div
        id="container"
        data-userId="<?= $user['id'] ?>"
        class="flex flex-col items-center gap-2 py-2"
    >
        <?php $hasNotifs = false; ?>
        <?php while ($notif = $notifs->fetch_assoc()): ?>
            <?php $hasNotifs = true; ?>
            <?php $class = 'flex flex-col min-h-16 justify-center gap-2 border rounded-xs p-2 w-full border-light-gray'; ?>

            <div 
                id="notif"
                data-id="<?= $notif['id'] ?>"
                class="<?= $class ?>"
            >
                <div class="flex items-center justify-center">
                    <h1 class="font-bold">
                        <?= h($notif['heading']) ?>
                    </h1>
                    <div class="flex-1"></div>
                    <span class="italic text-light-gray mx-2">
                        <?= h(date_format(date_create($notif['timestamp']), 'd/m/y H:i')) ?>
                    </span>
                    <button id="delete" type="button" class="flex items-center justify-center p-1 hover:text-red cursor-pointer transition">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                            <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
                <?php if ($text = $notif['text']): ?>
                    <hr class="text-gray">
                    <span class="flex-1 text-sm">
                        <?= h($text) ?>
                    </span>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>

        <?php if (!$hasNotifs): ?>
            <div class="italic text-light-gray flex flex-col w-full items-center">
                <span>¯\_(ツ)_/¯</span>
                <span>Belum ada notifikasi.</span>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="/src/js/notifs.ts"></script>
