<?php

function button(string $method, string $href, string $child, string $class = '', array $data = [])
{
    switch ($method) {
        case 'get':
            if (!empty($data)) {
                $href .= '?' . http_build_query($data);
            }

            ?>
            <a href="<?= $href ?>" class="<?= $class ?>">
                <button type="button" class="cursor-inherit"><?= $child ?></button>
            </a>
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
