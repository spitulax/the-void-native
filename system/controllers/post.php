<?php

require_once 'system/auth.php';
require_once 'system/redirect.php';
require_once 'system/response.php';
require_once 'system/validation.php';
require_once 'system/tables/post.php';
require_once 'system/tables/like.php';

class PostController
{
    public static function post(array $data): Redirect
    {
        $user = Auth::user();

        if ($user['muted']) {
            return redirect()->current()->with('error', 'Kamu dibisukan oleh admin.');
        }

        if (!$user) {
            Response::notFound();
        }

        $data = new Validation($data)
            ->add('private', ['checkbox'], 'Pribadi')
            ->add('text', ['required', 'max:500'], 'Text')
            ->finalize();

        $post = PostTable::insert([
            'text' => $data['text'],
            'private' => $data['private'],
            'author_id' => $user['id'],
        ]);

        return redirect('/post/view.php', ['post' => $post['id']]);
    }

    public static function reply(array $data): Redirect
    {
        $user = Auth::user();

        if (!$user) {
            Response::notFound();
        }

        $data = new Validation($data)
            ->add('text', ['required', 'max:500'], 'Text')
            ->add('parent_id', ['required', 'integer'])
            ->finalize();
        $parentId = $data['parent_id'];

        $post = PostTable::fromId($parentId);
        if (!PostTable::canView($post, $user)) {
            Response::notFound();
        }

        $post = PostTable::insert([
            'text' => $data['text'],
            'private' => false,
            'author_id' => $user['id'],
            'parent_id' => $parentId,
        ]);

        return redirect('/post/view.php', ['post' => $post['id']]);
    }

    public static function edit(array $data): Redirect
    {
        $user = Auth::user();

        if (!$user) {
            Response::notFound();
        }

        $data = new Validation($data)
            ->add('id', ['required', 'integer'])
            ->add('parent_id', ['integer'])
            ->add('private', ['checkbox'], 'Pribadi')
            ->add('text', ['required', 'max:500'], 'Text')
            ->finalize();
        $id = $data['id'];

        if (!PostTable::canEdit($id, $user)) {
            Response::notFound();
        }

        $usedData = [
            'text' => $data['text'],
        ];
        if (!$data['parent_id']) {
            $usedData['private'] = $data['private'];
        }

        $post = PostTable::update($id, $usedData);

        return redirect('/post/view.php', ['post' => $id]);
    }

    // NOTE: Must be authenticated
    public static function like(array $data): void
    {
        if (!Auth::user()) {
            JsonResponse::unauthorized();
        }

        $data = new Validation($data, true)->add('post_id', ['required', 'integer'])->finalize();

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

    public static function approve(array $data): void
    {
        if (!Auth::isAdmin()) {
            JsonResponse::unauthorized();
        }

        $data = new Validation($data, true)->add('id', ['required', 'integer'])->finalize();
        $id = $data['id'];

        PostTable::update($id, [
            'approved' => 1,
        ]);
    }

    public static function reject(array $data): void
    {
        if (!Auth::isAdmin()) {
            JsonResponse::unauthorized();
        }

        $data = new Validation($data, true)->add('id', ['required', 'integer'])->finalize();
        $id = $data['id'];

        PostTable::delete($id);
    }

    public static function approveData(array $data): void
    {
        if (!Auth::isAdmin()) {
            JsonResponse::unauthorized();
        }

        JsonResponse::data([
            'pending' => PostTable::pendingApprovalCount(),
        ]);
    }

    public static function delete(array $data): Redirect
    {
        $data = new Validation($data)->add('id', ['required', 'integer'])->finalize();
        $id = $data['id'];

        $user = Auth::user();
        $parent = PostTable::fromIdJoin($id, 'posts', 'parent_id');
        $parentId = null;
        if ($parent) {
            $parentId = $parent->fetch_assoc()['id'];
        }

        if (!PostTable::canDelete($id, $user)) {
            Response::notFound();
        }

        PostTable::delete($id);

        $redirectUrl = $parentId ? '/post/view.php?' . http_build_query(['post' => $parentId]) : '/';

        return redirect($redirectUrl)->with('success', 'Berhasil menghapus postingan.');
    }
}
