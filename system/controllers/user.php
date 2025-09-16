
<?php

require_once 'system/redirect.php';
require_once 'system/tables/user.php';

class UserController
{
    public static function login(array $data): Redirect
    {
        if (!isset($data['username']) || empty($data['username']))
            return redirect()->back();
        if (!isset($data['password']) || empty($data['password']))
            return redirect()->back();

        $user = UserTable::match($data['username'], $data['password']);

        if ($user) {
            $_SESSION['user'] = $user;
            return redirect()->intended();
        } else {
            return redirect()->back()->with('error', 'Username atau password salah.');
        }
    }

    public static function logout(array $data): Redirect
    {
        unset($_SESSION['user']);
        session_unset();
        session_destroy();
        return redirect('/');
    }
}
