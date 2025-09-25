<?php

function userList(mysqli_result $users, null|array $authUser, string $emptyMsg): void
{ ?>
    <div class="flex flex-col items-center gap-2 py-2">
        <?php $has = false; ?>
        <?php while ($user = $users->fetch_assoc()): ?>
            <?php $has = true; ?>
            <div class="flex items-center justify-between gap-2 border border-light-gray rounded-xs p-2 w-full hover:border-text hover:bg-dark-gray cursor-pointer transition items-center">
                <a href="/user/view.php?user=<?= urlencode($user['id']) ?>" class="flex items-center gap-1">
                    <span class="font-bold"><?= h($user['name']) ?></span>
                    <span class="font-bold text-xl">·</span>
                    <span class="text-light-gray"><?= h('@' . $user['username']) ?></span>
                    <!-- TODO: Add follow button here -->
                </a>
                <div
                    data-component="user-follow"
                    data-id="<?= $user['id'] ?>"
                    data-follows="<?= UserTable::follows($user['id']) ?>"
                    data-followed="<?= $user ? UserTable::userFollowed($user['id'], $authUser['id']) : false ?>"
                >
                    <button type="button" class="my-button w-20 text-sm">IKUTI</button>
                </div>
            </div>
        <?php endwhile; ?>

        <?php if (!$has): ?>
            <span class="italic text-light-gray"><?= h($emptyMsg) ?></span>
        <?php endif; ?>
    </div>

    <script src="/src/js/userFollow.ts"></script>
<?php }
