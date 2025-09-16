<?php

function button(string $method, string $href, string $child, string $class = '')
{
    switch ($method) {
        case 'get':
            ?>
            <button class="<?= $class ?>" type="button" onclick="window.location.href = '<?= $href ?>'"><?= $child ?></button>
            <?php

            break;
        case 'post':
            ?>
            <form class="inline" method="post" action="<?= $href ?>">
                <button class="<?= $class ?>" type="submit"><?= $child ?></button>
            </form>
            <?php

            break;
        default:
            throw new Exception("Unkown method `$method`");
    }
}
