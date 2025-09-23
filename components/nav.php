<?php

require_once 'components/button.php';

function nav(): void
{
    $user = Auth::user();
    ?>
    <header class="fixed bottom-0 left-0 w-full bg-base-dark shadow-md z-50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-10 items-center justify-between">
                <a href="/" class="flex items-center text-accent-light hover:text-accent gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 4.23 4.23">
                        <path d="M2.12 0a2.1 2.1 0 0 0-1.09.3l.43.73a1.27 1.27 0 0 1 .66-.18 1.27 1.27 0 0 1 .65.18L3.21.3A2.1 2.1 0 0 0 2.12 0M.42.85A2.12 2.12 0 0 0 0 2.12a2.12 2.12 0 0 0 2.12 2.11 2.12 2.12 0 0 0 2.11-2.11A2.12 2.12 0 0 0 3.81.85l-.52.78a1.3 1.3 0 0 1 .1.49 1.27 1.27 0 0 1-1.27 1.27A1.27 1.27 0 0 1 .85 2.12a1.3 1.3 0 0 1 .09-.49zm1.7.59a.68.68 0 0 0-.68.68.68.68 0 0 0 .68.67.68.68 0 0 0 .67-.67.68.68 0 0 0-.67-.68" />
                    </svg>
                </a>

                <div class="flex items-center space-x-4 gap-0 md:gap-1">
                    <?php $buttonClass = 'px-3 py-1 text-xs rounded-xs border-2 border-accent bg-transparent text-white font-bold cursor-pointer hover:border-transparent hover:bg-accent-dark transition'; ?>
                    <?php if ($user): ?>
                        <a
                            href="/user/view.php?<?= http_build_query(['user' => $user['id']]) ?>"
                            class="flex gap-1 font-bold hover:underline cursor-pointer"
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
        </div>
    </header>
    <?php
}
