
<?php

require_once 'system/auth.php';
require_once 'system/redirect.php';
require_once 'system/validation.php';
require_once 'system/tables/user.php';

class UserController
{
    public static function login(array $data): Redirect
    {
        $data = new Validation($data)
            ->add('username', 'Username', ['required'])
            ->add('password', 'Password', ['required'])
            ->finalize();

        if ($data instanceof Redirect) {
            return $data;
        }

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
