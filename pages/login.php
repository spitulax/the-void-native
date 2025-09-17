<?php

require_once 'system/main.php';
require_once 'system/redirect.php';

Redirect::markLastLoc();

$layout = new HTML('The Void: Masuk');

$errors = flash('validation_errors') ?? [];

// TODO: Retain form values after refresh
?>

<h1>Masuk</h1>
<form method="post" action="/login">
    <input
        type="text"
        name="username"
        placeholder="Masukkan username"
        required
    />
    <?php if ($errors['username'] ?? false): ?>
        <div><?= h($errors['username']) ?></div>
    <?php endif; ?>

    <input
        type="password"
        name="password"
        placeholder="Masukkan password"
        required
    />
    <?php if ($errors['password'] ?? false): ?>
        <div><?= h($errors['password']) ?></div>
    <?php endif; ?>

    <button type="submit">MASUK</button>
</form>

<?php if ($msg = flash('error')): ?>
    <div><?= h($msg) ?></div>
<?php endif;
