
<?php

require_once 'system/auth.php';
require_once 'system/main.php';
require_once 'system/response.php';
require_once 'components/button.php';
require_once 'components/topNav.php';
require_once 'components/confirmDialog.php';

$username = get('user');
if (!$username) {
    Response::notFound();
}

$user = UserTable::from('username', $username, 's');
if (!$user) {
    Response::notFound();
}

$userId = $user['id'];

$authUser = Auth::user();

$errors = flash('validation_errors') ?? [];

$layout = new HTML('The Void: @' . $user['username']);

?>

<script src="/src/js/confirmDialog.ts"></script>
<script src="/src/js/confirmUserDelete.ts"></script>
<script src="/src/js/toast.ts"></script>

<div class="flex-1 flex flex-col">
    <?php topNav('@' . $username); ?>

    <div class="flex flex-col p-2 gap-4">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-16 md:size-24 lg:size-32">
            <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" clip-rule="evenodd" />
        </svg>

        <div class="flex items-center justify-between">
            <div class="flex gap-2 items-center justify-center">
                <span class="font-bold"><?= $user['name'] ?> </span>
                <span class="font-bold text-xl">·</span>
                <span class="text-light-gray"><?= h('@' . $user['username']) ?></span>
                <?php if ($user['muted']): ?>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                        <path d="M13.5 4.06c0-1.336-1.616-2.005-2.56-1.06l-4.5 4.5H4.508c-1.141 0-2.318.664-2.66 1.905A9.76 9.76 0 0 0 1.5 12c0 .898.121 1.768.35 2.595.341 1.24 1.518 1.905 2.659 1.905h1.93l4.5 4.5c.945.945 2.561.276 2.561-1.06V4.06ZM17.78 9.22a.75.75 0 1 0-1.06 1.06L18.44 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06l1.72-1.72 1.72 1.72a.75.75 0 1 0 1.06-1.06L20.56 12l1.72-1.72a.75.75 0 1 0-1.06-1.06l-1.72 1.72-1.72-1.72Z" />
                    </svg>
                <?php endif; ?>
            </div>

            <?php if ($user['admin']): ?>
                <div class="flex items-center">
                    <span class="ml-4 font-bold my-heading">ADMIN</span>
                </div>
            <?php endif; ?>

            <div class="flex-1"> </div>

            <button 
                class="flex items-center hover:bg-dark-gray p-1 rounded-xs cursor-pointer transition"
                type="button"
                data-component="share"
                data-url="<?= domain() ?>/user/view.php?user=<?= urlencode($username) ?>"
            >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                  <path fill-rule="evenodd" d="M15.75 4.5a3 3 0 1 1 .825 2.066l-8.421 4.679a3.002 3.002 0 0 1 0 1.51l8.421 4.679a3 3 0 1 1-.729 1.31l-8.421-4.678a3 3 0 1 1 0-4.132l8.421-4.679a3 3 0 0 1-.096-.755Z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
     
        <?php if (UserTable::canFollow($userId, $authUser['id'])): ?>
            <div
                class="flex gap-2 items-center"
                data-component="user-follow"
                data-id="<?= $userId ?>"
                data-follows="<?= UserTable::follows($userId) ?>"
                data-followed="<?= $user ? UserTable::userFollowed($userId, $authUser['id']) : false ?>"
            >
                <button type="button" class="my-button w-20">IKUTI</button>
                <a href="/user/followers.php?user=<?= urlencode($username) ?>" class="px-1 hover:underline font-bold">
                    <span><?= UserTable::follows($userId) ?></span> Pengikut
                </a>
            </div>
        <?php else: ?>
            <div class="flex items-center">
                <a href="/user/followers.php?user=<?= urlencode($username) ?>" class="hover:underline font-bold">
                    <span><?= UserTable::follows($userId) ?></span> Pengikut
                </a>
            </div>
        <?php endif; ?>

        <div class="flex gap-2">
            <?php if (UserTable::canEdit($userId, $authUser)): ?>
                <?php button('get', '/user/edit.php', 'EDIT', 'my-button w-20', data: ['user' => $username]); ?>
            <?php endif; ?>

            <?php if (UserTable::canDelete($userId, $authUser)): ?>
                <?php confirmDialog(
                    strval($userId),
                    'Apakah Anda yakin ingin menghapus pengguna?',
                    'confirmUserDelete',
                    true,
                ); ?>
                <button type="button" onclick="showConfirm('<?= $userId ?>')" class="my-button w-20">
                    HAPUS
                </button>
            <?php endif; ?>

            <div class="flex gap-2">
                <?php if (Auth::isAdmin()): ?>
                <?php button('post', '/user/mute', 'MUTE', 'w-20 ' . ($user['muted'] ? 'my-button-on' : 'my-button'), [
                    'id' => $userId,
                ]) ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <span class="whitespace-pre-wrap m-2 p-4 border border-gray rounded-xs"><?= ($bio = $user['bio'])
        ? h($bio)
        : '<span class="italic text-light-gray">Tidak ada bio.</span>' ?></span>
</div>

<div 
    id="share-toast" 
    class="fixed bottom-20 left-10 bg-accent-dark px-4 py-2 rounded-xs shadow-black shadow-md opacity-0 transition-opacity duration-500 cursor-pointer"
    onclick="hideToast('share-toast')"
>
    Tersalin ke clipboard
</div>

<script src="/src/js/userFollow.ts"></script>
<script src="/src/js/share.ts"></script>
