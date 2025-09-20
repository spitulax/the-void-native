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
            <?php button('get', '/view.php', 'POSTINGAN INDUK', data: ['post' => $parentId]); ?>
        <?php endif; ?>
        <div class="border m-2">
            <div>
                ID: <?= h($id) ?>
            </div>
            <div>
                Author:
                <?php if ($author = PostTable::author($id)): ?>
                    <b><?= h($author['name']) ?></b>
                    <i><?= h('@' . $author['username']) ?></i>
                    <?php if ($post['private']): ?>
                        <i>(Private)</i>
                    <?php endif; ?>
                <?php else: ?>
                    <i>[Deleted]</i>
                <?php endif; ?>
            </div>
            <hr class="mx-2 text-gray-400" />
            <a href="/view.php?post=<?= urlencode($post['id']) ?>">
                <p><?= h($post['text']) ?></p>
            </a>
            <div>
                <div 
                    data-component="post-like"
                    data-id="<?= $id ?>"
                    data-likes="<?= PostTable::likes($id) ?>"
                    data-liked="<?= $user ? PostTable::userLiked($id, $user['id']) : false ?>"
                >
                    <button type="button">LIKE</button>
                    <span></span>
                </div>
                <div>
                    <?php button('get', '/reply.php', 'BALAS', data: ['post' => $id]) ?>
                    <span><?= h($numReplies) ?></span>
                </div>
                <?php if ($detailed): ?>
                    <?php if (PostTable::canDelete($id, $user)): ?>
                        <?php button('post', '/post/delete', 'HAPUS', data: ['id' => $id]) ?>
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
    </div>

    <script src='src/js/components/post.ts'></script>
    <?php
}
