<?php

function confirmDialog(string $id, string $msg, string $fnName, bool $redButton = false): void
{ ?>
    <div
        data-component="confirm-dialog-<?= $id ?>"
        class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 flex flex-col gap-4 items-center p-4 rounded-xs shadow-black shadow-md bg-base-light justify-center opacity-0 pointer-events-none transition-opacity lg:w-1/3 min-w-80 duration-300 z-100"
    >
        <span class="text-center"><?= h($msg) ?></span>

        <div class="flex gap-3">
            <button onclick="hideConfirm('<?= $id ?>')" class="my-button">Batal</button>
            <button onclick="<?= $fnName ?>('<?= $id ?>')" class="<?= $redButton ? 'my-button-red' : 'my-button-on' ?>">Ya</button>
        </div>
    </div>
<?php }
