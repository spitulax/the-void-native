<?php

require_once 'system/main.php';
require_once 'system/redirect.php';

Redirect::markLastLoc();

$layout = new HTML('The Void: Login');
?>

<h1>Login</h1>
<form method="post" action="/login">
    <input type="text" name="username" placeholder="Insert username" required />

    <input
        type="password"
        name="password"
        placeholder="Insert password"
    />
    <button type="submit">LOGIN</button>
</form>
