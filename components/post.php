<?php

require_once 'components/button.php';
require_once 'system/tables/post.php';
require_once 'system/tables/like.php';

function post(array $post, bool $detailed = false)
{
    $user = Auth::user();
    $id = intval($post['id']);

    $numReplies = PostTable::replies($id);

    $replies = null;
    if ($detailed) {
        $replies = PostTable::getReplies($id);
    }

    ?>
    <div>
        <?php if ($detailed && ($parentId = $post['parent_id'])): ?>
            <?php button('get', '/post/view.php', 'POSTINGAN INDUK', data: ['post' => $parentId]); ?>
        <?php endif; ?>
        <div class="border rounded-xs border-gray mx-2 my-3 px-1">
            <div class="flex justify-between items-center h-10 px-1 py-1">
                <?php $class = 'rounded-xs px-1 h-full'; ?>
                <?php if ($author = PostTable::author($id)): ?>
                    <div class="flex items-center gap-2 h-full">
                        <a href="/user/view.php?user=<?= urlencode($author['id']) ?>" class="<?= $class ?> hover:bg-dark-gray flex items-center">
                            <span class="font-bold"><?= h($author['name']) ?></span>
                            <span class="font-bold text-xl mx-1">·</span>
                            <?= h('@' . $author['username']) ?>
                        </a>
                        <?php if ($post['private']): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                            </svg>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <span class="<?= $class ?> flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                            <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                        </svg>
                        <span class="font-bold text-xl mx-1">·</span>
                        Dihapus
                    </span>
                <?php endif; ?>
                <a href="/post/view.php?post=<?= urlencode($id) ?>" class="<?= $class ?> hover:bg-dark-gray flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                    </svg>
                </a>
            </div>
            <hr class="text-gray" />
                <?php if (!$detailed): ?>
                    <a href="/post/view.php?post=<?= urlencode($id) ?>">
                <?php endif; ?>
                    <div class="px-2 md:px-3 my-2 min-h-24 flex items-center">
                        <span class="whitespace-pre-wrap"><?= h($post['text']) ?></span>
                    </div>
                <?php if (!$detailed): ?>
                    </a>
                <?php endif; ?>
            <hr class="text-gray" />
            <div class="flex justify-between px-2 py-1">
                <?php $class = 'flex gap-2 md:gap-3 lg:gap-4 items-center' ?>
                <div class="<?= $class ?>">
                    <div 
                        class="flex gap-1"
                        data-component="post-like"
                        data-id="<?= $id ?>"
                        data-likes="<?= PostTable::likes($id) ?>"
                        data-liked="<?= $user ? PostTable::userLiked($id, $user['id']) : false ?>"
                    >
                        <button type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2" class="size-5 stroke-text fill-transparent hover:fill-red hover:stroke-red transition cursor-pointer">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                            </svg>
                        </button>
                        <a href="/post/likes.php?post=<?= urlencode($post['id']) ?>">
                            <span><?= PostTable::likes($id) ?></span>
                        </a>
                    </div>
                    <div class="flex gap-1">
                        <?php button('get', '/post/reply.php', '
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2" class="size-5 stroke-text fill-transparent hover:fill-text transition cursor-pointer">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 0 1 .778-.332 48.294 48.294 0 0 0 5.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                            </svg>
                        ', data: ['post' => $id]) ?>
                        <span><?= h($numReplies) ?></span>
                    </div>
                </div>
                <!-- TODO: Share button here -->
                <div class="<?= $class ?>">
                </div>
                <?php if ($detailed): ?>
                    <?php if (PostTable::canEdit($id, $user)): ?>
                        <div>
                            <?php button('get', '/post/edit.php', 'EDIT', data: ['post' => $id]) ?>
                        </div>
                    <?php endif; ?>
                    <?php if (PostTable::canDelete($id, $user)): ?>
                        <div>
                            <?php button('post', '/post/delete', 'HAPUS', data: ['id' => $id]) ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
        <?php if ($detailed): ?>
            <hr class="my-4">
            <div class="mx-8">
                <?php while ($reply = $replies->fetch_assoc()): ?>
                    <?php post($reply, false); ?>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>

        <script src="/src/js/utils/postLike.ts"></script>
    </div>
    <?php
}
