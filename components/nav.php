<?php

require_once 'components/button.php';

function nav(): void
{
    function shortcut(string $page, string $icon, string $tooltip, string $extraClass = ''): void
    {
        $class = 'hover:[&_svg]:fill-accent-light cursor-pointer hover:scale-110 transition ' . $extraClass;

        ?>
        <div class="flex flex-row group relative">
            <?php button('get', $page, $icon, $class); ?>
            <div
                class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3
                       opacity-0 group-hover:opacity-100 group-hover:visible transition duration-200
                       bg-base-light text-sm rounded-xs px-2 py-1 whitespace-nowrap shadow-lg font-bold"
            >
                <?= h($tooltip) ?>
            </div>
        </div>
        <?php
    }

    $user = Auth::user();
    ?>
    <header
        id="bottom-nav"
        class="fixed bottom-0 left-0 w-screen bg-base-light z-50"
        <?= $user ? 'data-user-id="' . $user['id'] . '"' : '' ?>
        <?= $user ? 'data-user-admin="' . $user['admin'] . '"' : '' ?>
    >
        <div class="flex px-4 sm:px-6 lg:px-8 h-12 items-center justify-between">
            <a href="/" class="flex items-center text-accent hover:text-accent-light gap-2 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4.23 4.23" class="size-7">
                    <path d="M2.12 0a2.1 2.1 0 0 0-1.09.3l.43.73a1.27 1.27 0 0 1 .66-.18 1.27 1.27 0 0 1 .65.18L3.21.3A2.1 2.1 0 0 0 2.12 0M.42.85A2.12 2.12 0 0 0 0 2.12a2.12 2.12 0 0 0 2.12 2.11 2.12 2.12 0 0 0 2.11-2.11A2.12 2.12 0 0 0 3.81.85l-.52.78a1.3 1.3 0 0 1 .1.49 1.27 1.27 0 0 1-1.27 1.27A1.27 1.27 0 0 1 .85 2.12a1.3 1.3 0 0 1 .09-.49zm1.7.59a.68.68 0 0 0-.68.68.68.68 0 0 0 .68.67.68.68 0 0 0 .67-.67.68.68 0 0 0-.67-.68" />
                </svg>
            </a>

            <div class="h-full flex flex-1 items-center justify-start mx-8 gap-4">
                <?php $class = 'hover:[&_svg]:fill-accent-light cursor-pointer hover:scale-110 transition'; ?>

                <?php if ($user): ?>
                    <?php shortcut('/post.php', '
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                            <path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                        </svg>
                    ', 'Buat Postingan'); ?>

                    <?php shortcut('/notifs.php', '
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                          <path fill-rule="evenodd" d="M5.25 9a6.75 6.75 0 0 1 13.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 0 1-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 1 1-7.48 0 24.585 24.585 0 0 1-4.831-1.244.75.75 0 0 1-.298-1.205A8.217 8.217 0 0 0 5.25 9.75V9Zm4.502 8.9a2.25 2.25 0 1 0 4.496 0 25.057 25.057 0 0 1-4.496 0Z" clip-rule="evenodd" />
                        </svg>
                        <span id="notif-alert" class="absolute bg-red h-2 w-2 top-0 right-0 rounded-full z-20 hidden"></span>
                    ', 'Notifikasi', 'relative'); ?>

                    <?php if ($user['admin']): ?>
                        <?php shortcut('/admin/dashboard.php', '
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path fill-rule="evenodd" d="M11.078 2.25c-.917 0-1.699.663-1.85 1.567L9.05 4.889c-.02.12-.115.26-.297.348a7.493 7.493 0 0 0-.986.57c-.166.115-.334.126-.45.083L6.3 5.508a1.875 1.875 0 0 0-2.282.819l-.922 1.597a1.875 1.875 0 0 0 .432 2.385l.84.692c.095.078.17.229.154.43a7.598 7.598 0 0 0 0 1.139c.015.2-.059.352-.153.43l-.841.692a1.875 1.875 0 0 0-.432 2.385l.922 1.597a1.875 1.875 0 0 0 2.282.818l1.019-.382c.115-.043.283-.031.45.082.312.214.641.405.985.57.182.088.277.228.297.35l.178 1.071c.151.904.933 1.567 1.85 1.567h1.844c.916 0 1.699-.663 1.85-1.567l.178-1.072c.02-.12.114-.26.297-.349.344-.165.673-.356.985-.57.167-.114.335-.125.45-.082l1.02.382a1.875 1.875 0 0 0 2.28-.819l.923-1.597a1.875 1.875 0 0 0-.432-2.385l-.84-.692c-.095-.078-.17-.229-.154-.43a7.614 7.614 0 0 0 0-1.139c-.016-.2.059-.352.153-.43l.84-.692c.708-.582.891-1.59.433-2.385l-.922-1.597a1.875 1.875 0 0 0-2.282-.818l-1.02.382c-.114.043-.282.031-.449-.083a7.49 7.49 0 0 0-.985-.57c-.183-.087-.277-.227-.297-.348l-.179-1.072a1.875 1.875 0 0 0-1.85-1.567h-1.843ZM12 15.75a3.75 3.75 0 1 0 0-7.5 3.75 3.75 0 0 0 0 7.5Z" clip-rule="evenodd" />
                            </svg>
                        ', 'Dashboard Admin'); ?>

                        <?php shortcut(
                            '/admin/approve.php',
                            '
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                              <path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z" clip-rule="evenodd" />
                              <path fill-rule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375Zm9.586 4.594a.75.75 0 0 0-1.172-.938l-2.476 3.096-.908-.907a.75.75 0 0 0-1.06 1.06l1.5 1.5a.75.75 0 0 0 1.116-.062l3-3.75Z" clip-rule="evenodd" />
                            </svg>
                            <span id="approve-alert" class="absolute bg-red h-2 w-2 top-0 right-0 rounded-full z-20 hidden"></span>
                            ',
                            'Setujui Postingan',
                            'relative',
                        ); ?>
                    <?php else: ?>
                        <?php shortcut('/user/pendingPosts.php', '
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                              <path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z" clip-rule="evenodd" />
                              <path fill-rule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375Zm9.586 4.594a.75.75 0 0 0-1.172-.938l-2.476 3.096-.908-.907a.75.75 0 0 0-1.06 1.06l1.5 1.5a.75.75 0 0 0 1.116-.062l3-3.75Z" clip-rule="evenodd" />
                            </svg>
                            ', 'Antrean Postingan'); ?>
                    <?php endif; ?>
                <?php endif; ?>

                <?php shortcut('/about.php', '
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 0 1 .67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 1 1-.671-1.34l.041-.022ZM12 9a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                    </svg>
                ', 'Tentang'); ?>
            </div>

            <div class="flex items-center space-x-4 gap-0 md:gap-1">
                <?php $buttonClass = 'my-button px-3 py-1 text-sm text-bold text-white'; ?>
                <?php if ($user): ?>
                    <a
                        href="/user/view.php?<?= http_build_query(['user' => $user['username']]) ?>"
                        class="flex gap-1 font-bold hover:underline cursor-pointer items-center justify-center"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" clip-rule="evenodd" />
                        </svg>
                        <?= h('@' . $user['username']) ?>
                    </a>
                    <?php button('post', '/logout', 'KELUAR', $buttonClass); ?>
                <?php else: ?>
                    <?php button('get', '/login.php', 'MASUK', $buttonClass); ?>
                    <?php button('get', '/register.php', 'DAFTAR', $buttonClass); ?>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <script src="/src/js/components/nav.ts"></script>
    <?php
}
