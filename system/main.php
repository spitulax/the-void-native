<?php

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
                </head>

                <body class="w-screen h-screen">
                    <?= $output ?>
                </body>
            </html>
        <?php

        $result = ob_get_clean();
        ob_end_clean();
        Response::accept($result);
    }
}
