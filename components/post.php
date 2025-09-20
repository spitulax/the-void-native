<?php

require_once 'components/button.php';
require_once 'system/tables/post.php';
require_once 'system/tables/like.php';

function post(array $post)
{
    $user = Auth::user();

    ?>
    <?php $id = intval($post['id']); ?>
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
        <p><?= h($post['text']) ?></p>
        <div>
            <div 
                data-component="post-like"
                data-id="<?= $id ?>"
                data-likes="<?= LikeTable::likes($id) ?>"
                data-liked="<?= $user ? LikeTable::userLiked($id, $user['id']) : false ?>"
            >
                <button type="button">LIKE</button>
                <span></span>
            </div>
            <!-- TODO: Only display this in individual post page -->
            <?php if (PostTable::canDelete($id, $user)): ?>
                <?php button('post', '/post/delete', 'HAPUS', data: ['id' => $id]) ?>
            <?php endif; ?>
        </div>
    </div>

    <script src='src/js/components/post.ts'></script>
<?php
}
