
<?php

require_once 'system/auth.php';
require_once 'system/redirect.php';
require_once 'system/validation.php';
require_once 'system/tables/user.php';

class UserController
{
    public static function register(array $data): Redirect
    {
        $data = new Validation($data)
            ->add('username', 'Username', ['required', 'min:3', 'max:32'])
            ->add('name', 'Nama', ['required', 'min:3', 'max:64'])
            ->add('password', 'Password', ['required', 'min:8', 'max:32'])
            ->add('confirm_password', 'Konfirmasi password', ['same:password'])
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
            ->add('username', 'Username', ['required'])
            ->add('password', 'Password', ['required'])
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
        Auth::get()->logout();
        return redirect('/');
    }
}
