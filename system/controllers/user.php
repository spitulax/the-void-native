<?php

require_once 'system/auth.php';
require_once 'system/redirect.php';
require_once 'system/response.php';
require_once 'system/validation.php';
require_once 'system/tables/user.php';
require_once 'system/tables/follow.php';
require_once 'system/tables/notif.php';

class UserController
{
    private static function validation(array $data): Validation
    {
        return new Validation($data)
            //
            ->add('username', ['required', 'min:3', 'max:32'], 'Username')
            ->add('name', ['required', 'max:64'], 'Nama');
    }

    private static function validateUsername(string $username, bool $validateUse = true): null|Redirect
    {
        if (!preg_match('#^[a-z0-9._]+$#', $username)) {
            return redirect()
                ->current()
                ->with(
                    'error',
                    'Username hanya boleh terdiri dari huruf kecil (a-z), angka (0-9), titik (.), dan garis bawah (_).',
                );
        }

        if ($validateUse) {
            if (UserTable::from('username', $username, 's')) {
                return redirect()->current()->with('error', 'Username @' . $username . ' telah dipakai.');
            }
        }

        return null;
    }

    public static function register(array $data): Redirect
    {
        $data = static::validation($data)
            ->add('password', ['required', 'min:8', 'max:32'], 'Password')
            ->add('confirm_password', ['same:password'], 'Konfirmasi password')
            ->finalize();

        $username = $data['username'];
        if ($res = static::validateUsername($username)) {
            return $res;
        }

        $user = UserTable::insert([
            'username' => $username,
            'name' => $data['name'],
            'password' => password_hash($data['password'], null),
            'admin' => 0,
        ]);

        Auth::get()->login($user);
        return redirect('/');
    }

    public static function login(array $data): Redirect
    {
        $data = new Validation($data)
            ->add('username', ['required'], 'Username')
            ->add('password', ['required'], 'Password')
            ->finalize();

        $user = UserTable::match($data['username'], $data['password']);

        if ($user) {
            Auth::get()->login($user);
            return redirect()->intended();
        } else {
            return redirect()->current()->with('error', 'Username atau password salah.');
        }
    }

    public static function logout(array $data): Redirect
    {
        if (!Auth::user()) {
            Response::notFound();
        }

        Auth::get()->logout();
        return redirect('/');
    }

    public static function edit(array $data): Redirect
    {
        $authUser = Auth::user();

        if (!$authUser) {
            Response::notFound();
        }

        $data = static::validation($data)
            ->add('id', ['required', 'integer'])
            ->add('bio', ['max:2048'], 'Bio')
            ->finalize();
        $id = $data['id'];

        if (!UserTable::canEdit($id, $authUser)) {
            Response::notFound();
        }

        $user = UserTable::fromId($id);
        if ($res = static::validateUsername($data['username'], $data['username'] !== $user['username'])) {
            return $res;
        }

        UserTable::update($id, [
            'username' => $data['username'],
            'name' => $data['name'],
            'bio' => $data['bio'],
        ]);

        return redirect('/user/view.php', ['user' => $data['username']]);
    }

    public static function changePassword(array $data): Redirect
    {
        $user = Auth::user();

        if (!$user) {
            Response::notFound();
        }

        $data = new Validation($data)
            ->add('id', ['required', 'integer'])
            ->add('old_password', ['required', 'min:8', 'max:32'], 'Password lama')
            ->add('new_password', ['required', 'min:8', 'max:32'], 'Password baru')
            ->add('confirm_password', ['same:new_password'], 'Konfirmasi password')
            ->finalize();
        $id = $data['id'];

        if (!UserTable::canEdit($id, $user)) {
            Response::notFound();
        }

        $editedUser = UserTable::fromId($id);
        if (!password_verify($data['old_password'], $editedUser['password'])) {
            return redirect()->current()->with('error', 'Password lama yang dimasukkan tidak cocok.');
        }

        UserTable::update($id, [
            'password' => password_hash($data['new_password'], null),
        ]);

        return redirect('/user/view.php', ['user' => $editedUser['username']]);
    }

    // NOTE: Must be authenticated
    public static function follow(array $data): void
    {
        if (!Auth::user()) {
            JsonResponse::unauthorized();
        }

        $data = new Validation($data, true)->add('followed_id', ['required', 'integer'])->finalize();

        $id = $data['followed_id'];
        $userId = Auth::user()['id'];

        if (!UserTable::canFollow($id, $userId)) {
            JsonResponse::data(null);
        }

        if (UserTable::userFollowed($id, $userId)) {
            FollowTable::removeFollow($id, $userId);
        } else {
            FollowTable::addFollow($id, $userId);
        }

        JsonResponse::data([
            'followed' => UserTable::userFollowed($id, $userId),
            'follows' => UserTable::follows($id),
        ]);
    }

    public static function mute(array $data): Redirect
    {
        $data = new Validation($data)->add('id', ['required', 'integer'])->finalize();
        $id = $data['id'];

        if (!Auth::isAdmin()) {
            Response::notFound();
        }

        $user = UserTable::fromId($id);
        if (!$user) {
            return redirect()->current()->with('error', "Pengguna dengan ID `$id` tidak ditemukan.");
        }
        $username = $user['username'];

        $unmuting = boolval($user['muted']);
        UserTable::update($id, [
            'muted' => $unmuting ? 0 : 1,
        ]);

        NotifTable::insert([
            'heading' => $unmuting ? 'Kamu sudah tidak lagi dibisukan oleh admin' : 'Kamu telah dibisukan oleh admin',
            'recipient_id' => $id,
        ], 'timestamp');

        return redirect()->current()->with('success', "Berhasil membisukan @$username.");
    }

    public static function delete(array $data): Redirect
    {
        $data = new Validation($data)->add('id', ['required', 'integer'])->finalize();
        $id = $data['id'];

        if (!UserTable::canDelete($id, Auth::user())) {
            Response::notFound();
        }

        $user = UserTable::fromId($id);
        if (!$user) {
            return redirect()->current()->with('error', "Pengguna dengan ID `$id` tidak ditemukan.");
        }
        $username = $user['username'];

        UserTable::delete($id);

        if (Auth::user()['id'] === $id) {
            Auth::get()->logout();
            return redirect('/');
        } else {
            return redirect()->current()->with('success', "Berhasil menghapus @$username.");
        }
    }
}
