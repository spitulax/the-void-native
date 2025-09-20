<?php

require_once 'system/redirect.php';
require_once 'system/response.php';
require_once 'system/tables/like.php';

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

        if (LikeTable::userLiked($id, $userId)) {
            LikeTable::removeLike($id, $userId);
        } else {
            LikeTable::addLike($id, $userId);
        }

        JsonResponse::data([
            'liked' => LikeTable::userLiked($id, $userId),
            'likes' => LikeTable::likes($id),
        ]);
    }
}
