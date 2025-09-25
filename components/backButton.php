<?php

function backButton(int $size = 6): void
{ ?>
    <button type="button" onclick="history.back();" class="cursor-pointer hover:bg-dark-gray w-fit p-1 rounded-full flex items-center transition">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-<?= $size ?>">
            <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 9-3 3m0 0 3 3m-3-3h7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
    </button>
<?php }
