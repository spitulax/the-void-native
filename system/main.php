<?php

require_once 'components/nav.php';

class HTML
{
    protected null|string $logStr = null;

    public function __construct(
        public string $title,
        public string $lang = 'id',
    ) {
        ob_start();
    }

    public function __destruct()
    {
        $output = ob_get_clean();

        ob_start();

        ?>
        <!DOCTYPE html>
        <html lang="<?= $this->lang ?>">
            <head>
                <meta charset="UTF-8" />
                <meta http-equiv="X-UA-Compatible" content="IE=edge" />
                <meta name="viewport" content="width=device-width, initial-scale=1.0" />

                <title><?= h($this->title) ?></title>

                <link href="/src/css/tailwind.css" rel="stylesheet" />
                <link href="/src/css/global.css" rel="stylesheet" />
                <link rel="icon" href="/favicon.svg" sizes="any" type="image/svg+xml">
            </head>

            <body class="w-screen h-screen bg-gradient-to-r from-base-light from-[-50%] md:from-[-25%] via-base via-50% to-base-light to-150% md:to-125% fg-text text-text [&::-webkit-scrollbar]:hidden">
                <?php nav(); ?>
                <main class="min-h-screen pb-10 flex">
                    <?= $output ?>
                </main>
            </body>
        </html>
        <?php

        $result = ob_get_clean();
        ob_end_clean();
        Response::accept($result);
    }
}
