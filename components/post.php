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
                <?php if ($author = PostTable::author($id)): ?>
                    <a href="/user/view.php?user=<?= urlencode($author['id']) ?>">
                        <b><?= h($author['name']) ?></b>
                        <i><?= h('@' . $author['username']) ?></i>
                    </a>
                    <?php if ($post['private']): ?>
                        <i>(Pribadi)</i>
                    <?php endif; ?>
                <?php else: ?>
                    <i>[Dihapus]</i>
                <?php endif; ?>
            </div>
            <hr class="mx-2 text-gray-400" />
            <a href="/view.php?post=<?= urlencode($id) ?>">
                <span class="whitespace-pre-wrap"><?= h($post['text']) ?></span>
            </a>
            <div>
                <div 
                    data-component="post-like"
                    data-id="<?= $id ?>"
                    data-likes="<?= PostTable::likes($id) ?>"
                    data-liked="<?= $user ? PostTable::userLiked($id, $user['id']) : false ?>"
                >
                    <button type="button">LIKE</button>
                    <a href="/likes.php?post=<?= urlencode($post['id']) ?>">
                        <span><?= PostTable::likes($id) ?></span>
                    </a>
                </div>
                <div>
                    <?php button('get', '/reply.php', 'BALAS', data: ['post' => $id]) ?>
                    <span><?= h($numReplies) ?></span>
                </div>
                <?php if ($detailed): ?>
                    <?php if (PostTable::canEdit($id, $user)): ?>
                        <div>
                            <?php button('get', '/edit.php', 'EDIT', data: ['post' => $id]) ?>
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
    </div>

    <script src="/src/js/utils/postLike.ts"></script>
    <?php
}
