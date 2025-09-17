<?php

require_once 'system/auth.php';
require_once 'system/redirect.php';
require_once 'system/response.php';
require_once 'system/validation.php';
require_once 'system/tables/user.php';

class UserController
{
    public static function register(array $data): Redirect
    {
        $data = new Validation($data)
            ->add('username', ['required', 'min:3', 'max:32'], 'Username')
            ->add('name', ['required', 'min:3', 'max:64'], 'Nama')
            ->add('password', ['required', 'min:8', 'max:32'], 'Password')
            ->add('confirm_password', ['same:password'], 'Konfirmasi password')
            ->finalize();

        $username = strtolower($data['username']);
        if (Database::fetch('SELECT * FROM users WHERE username=?', [[$username, 's']])->fetch_assoc()) {
            return redirect()->back()->with('error', "Pengguna @$username telah teregistrasi.");
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
            return redirect()->back()->with('error', 'Username atau password salah.');
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

    public static function delete(array $data): Redirect
    {
        // TODO: Let user delete themself
        if (!Auth::isAdmin()) {
            Response::notFound();
        }

        $data = new Validation($data)
            ->add('id', ['required', 'integer'])
            ->finalize();
        $id = $data['id'];

        if (Auth::user()['id'] === $id) {
            return redirect()->back()->with('error', 'Tidak bisa menghapus diri sendiri.');
        }

        $user = UserTable::fromId($id);
        if (!$user) {
            return redirect()->back()->with('error', "Pengguna dengan ID `$id` tidak ditemukan.");
        }
        $username = $user['username'];

        UserTable::delete($id);

        return redirect()->back()->with('success', "Berhasil menghapus @$username.");
    }
}
