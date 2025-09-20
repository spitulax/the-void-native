<?php

require_once 'system/redirect.php';
require_once 'system/response.php';
require_once 'system/tables/like.php';
require_once 'system/tables/post.php';

class LikeController
{
    // NOTE: Must be authenticated
    public static function like(array $data): void
    {
        if (!Auth::user()) {
            JsonResponse::login();
        }

        $data = new Validation($data, true)
            ->add('post_id', ['required', 'integer'])
            ->finalize();

        $id = $data['post_id'];
        $userId = Auth::user()['id'];

        if (PostTable::userLiked($id, $userId)) {
            LikeTable::removeLike($id, $userId);
        } else {
            LikeTable::addLike($id, $userId);
        }

        JsonResponse::data([
            'liked' => PostTable::userLiked($id, $userId),
            'likes' => PostTable::likes($id),
        ]);
    }
}
