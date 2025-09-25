<?php

require_once 'components/backButton.php';

function topNav(string $title = ''): void
{ ?>
    <div class="fixed top-0 left-0 bg-base-light w-screen z-50">
        <div class="flex gap-2 px-4 sm:px-6 lg:px-8 h-10 items-center">
            <?php backButton() ?>
            <h1 class="font-bold text-md md:text-xl truncate my-heading"><?= h($title) ?></h1>
        </div>
    </div>
    <div class="pt-10"></div>
<?php }
