<?php

require_once 'system/auth.php';
require_once 'system/main.php';
require_once 'system/tables/post.php';
require_once 'components/button.php';
require_once 'components/post.php';

$user = Auth::user();

$posts = PostTable::allCanView($user);

$layout = new HTML('The Void');

?>

<?php if ($user): ?>
    <?php button(
        'get',
        '/post.php',
        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-10">
            <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
            <path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
        </svg>',
        'fixed bottom-16 right-10 rounded-xs bg-base border-2 border-accent hover:border-transparent hover:bg-accent-dark p-2 text-2xl shadow-lg hover:scale-125 transition transform cursor-pointer',
    ); ?>
<?php endif; ?>

<div class="flex flex-col mx-4 md:mx-24 lg:mx-32 px-1 border-x-2 border-dark-gray">
    <?php while ($post = $posts->fetch_assoc()): ?>
        <?php post($post) ?>
    <?php endwhile; ?>

    <div class="flex py-4 my-4 border-y-2 border-dark-gray justify-center text-light-gray">
        <a href="https://github.com/spitulax/" target="_blank" class="cursor-pointer">
            <i>¯\_(ツ)_/¯</i>
        </a>
    </div>
</div>
