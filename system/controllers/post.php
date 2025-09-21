<?php

require_once 'system/auth.php';
require_once 'system/redirect.php';
require_once 'system/response.php';
require_once 'system/validation.php';
require_once 'system/tables/post.php';

class PostController
{
    public static function post(array $data): Redirect
    {
        $user = Auth::user();

        if (!$user) {
            Response::notFound();
        }

        $data = new Validation($data)
            ->add('private', ['checkbox'], 'Pribadi')
            ->add('text', ['required', 'max:2048'], 'Text')
            ->finalize();

        $post = PostTable::insert([
            'text' => $data['text'],
            'private' => $data['private'],
            'author_id' => $user['id'],
        ]);

        return redirect('/view.php', ['post' => $post['id']]);
    }

    public static function reply(array $data): Redirect
    {
        $user = Auth::user();

        if (!$user) {
            Response::notFound();
        }

        $data = new Validation($data)
            ->add('text', ['required', 'max:2048'], 'Text')
            ->add('parent_id', ['required', 'integer'])
            ->finalize();
        $parentId = $data['parent_id'];

        if (!PostTable::canView($parentId, $user)) {
            Response::notFound();
        }

        $post = PostTable::insert([
            'text' => $data['text'],
            'private' => false,
            'author_id' => $user['id'],
            'parent_id' => $parentId,
        ]);

        return redirect('/view.php', ['post' => $post['id']]);
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
            ->add('text', ['required', 'max:2048'], 'Text')
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

        return redirect('/view.php', ['post' => $id]);
    }

    public static function delete(array $data): Redirect
    {
        $data = new Validation($data)
            ->add('id', ['required', 'integer'])
            ->finalize();
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

        $redirectUrl = $parentId ? ('/view.php?' . http_build_query(['post' => $parentId])) : '/';

        return redirect($redirectUrl)->with('success', 'Berhasil menghapus postingan.');
    }
}
