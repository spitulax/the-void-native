<?php

function button(string $method, string $href, string $child, string $class = '', array $data = [])
{
    switch ($method) {
        case 'get':
            if (!empty($data)) {
                throw new Exception('Unimplemented');
            }

            ?>
            <button class="<?= $class ?>" type="button" onclick="window.location.href = '<?= $href ?>'"><?= $child ?></button>
            <?php

            break;
        case 'post':
            ?>
            <form class="inline" method="post" action="<?= $href ?>">
                <?php foreach ($data as $key => $value): ?>
                    <input type="hidden" name="<?= $key ?>" value="<?= $value ?>">
                <?php endforeach; ?>

                <button class="<?= $class ?>" type="submit"><?= $child ?></button>
            </form>
            <?php

            break;
        default:
            throw new Exception("Unkown method `$method`");
    }
}
