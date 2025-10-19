<?php

require_once 'system/main.php';
require_once 'system/tables/like.php';
require_once 'system/tables/post.php';

$layout = new HTML('The Void: Tentang');

function info(string $label, string $value, string $icon): void
{ ?>
    <div class="flex justify-center items-stretch border-2 border-gray rounded-xs px-2 gap-2 md:gap-4 w-[80vw] md:w-[40vw]">
        <div class="flex py-8 items-center justify-center">
            <?= $icon ?>
        </div>
        <div class="w-[2px] my-2 bg-gray"></div>
        <div class="flex flex-col py-8 items-center justify-center font-bold">
            <span><?= h($label) ?></span>
            <span class="text-3xl"><?= h($value) ?></span>
        </div>
    </div>
<?php }

$totalPosts = PostTable::len();
$totalLikes = LikeTable::len();
$totalViews = Database::fetch('SELECT SUM(views) AS count FROM posts')->fetch_assoc()['count'];
$totalViews = $totalViews ? intval($totalViews) : 0;
$totalUsers = UserTable::len();

?>

<div class="flex flex-1 justify-center items-center gap-8 flex-col py-10">
    <div class="flex items-center justify-center gap-1 flex-row md:flex-col">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 4.233 4.233" class="size-16 md:size-24">
          <path d="M2.12.617a1.5 1.5 0 0 0-.773.212l.305.518a.9.9 0 0 1 .468-.127.9.9 0 0 1 .461.127L2.893.83A1.5 1.5 0 0 0 2.12.617M.915 1.22a1.5 1.5 0 0 0-.298.9A1.504 1.504 0 0 0 2.12 3.617 1.504 1.504 0 0 0 3.617 2.12a1.5 1.5 0 0 0-.298-.9l-.369.553a.9.9 0 0 1 .07.347.9.9 0 0 1-.9.9.9.9 0 0 1-.9-.9.9.9 0 0 1 .063-.347Zm1.205.418a.48.48 0 0 0-.482.482.48.48 0 0 0 .482.475.48.48 0 0 0 .475-.475.48.48 0 0 0-.475-.482" style="fill:#fff"/>
        </svg>
        <span class="font-extrabold text-3xl my-heading">The Void</span>
    </div>

    <div class="flex flex-col justify-center items-center gap-10">
        <div class="flex flex-col md:flex-row justify-center items-stretch gap-2">
            <div class="flex flex-col items-center justify-center gap-2">
                <?php info('Jumlah Postingan', strval($totalPosts), '
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-12">
                        <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                        <path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                    </svg>
                '); ?>

                <?php info('Jumlah Pengguna', strval($totalUsers), '
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-12">
                        <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" clip-rule="evenodd" />
                    </svg>
                '); ?>
            </div>

            <div class="flex flex-col items-center justify-center gap-2">
                <?php info('Like Total', strval($totalLikes), '
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-12">
                        <path d="m11.645 20.91-.007-.003-.022-.012a15.247 15.247 0 0 1-.383-.218 25.18 25.18 0 0 1-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0 1 12 5.052 5.5 5.5 0 0 1 16.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 0 1-4.244 3.17 15.247 15.247 0 0 1-.383.219l-.022.012-.007.004-.003.001a.752.752 0 0 1-.704 0l-.003-.001Z" />
                    </svg>
                '); ?>

                <?php info('View Total', strval($totalViews), '
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-12">
                        <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                        <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z" clip-rule="evenodd" />
                    </svg>
                '); ?>
            </div>
        </div>

        <div class="flex items-center justify-between w-full">
            <span class="text-gray italic">Copyright &copy; 2025 The Void</span>
            <a class="font-bold text-gray" target="_blank" href="https://codeberg.org/spitulax/the-void-native">Source Code</a>
        </div>
    </div>
</div>
