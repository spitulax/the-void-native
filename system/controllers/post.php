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
        if (!Auth::user()) {
            Response::notFound();
        }

        $data = new Validation($data)
            ->add('private', ['checkbox'], 'Pribadi')
            ->add('text', ['required', 'max:2048'], 'Text')
            ->finalize();

        $user = Auth::user();
        $post = PostTable::insert([
            'text' => $data['text'],
            'private' => $data['private'],
            'author_id' => $user['id'],
        ]);

        return redirect('/view.php', ['post' => $post['id']]);
    }
}
