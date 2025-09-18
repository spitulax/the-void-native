<?php

require_once 'system/main.php';

$errors = flash('validation_errors') ?? [];

$layout = new HTML('The Void: Daftar');

// TODO: Retain form values after refresh
?>

<h1>Daftar</h1>
<form method="post" action="/register">
    <input type="text" name="username" placeholder="Masukkan username" required />
    <?php if ($errors['username'] ?? false): ?>
        <div><?= h($errors['username']) ?></div>
    <?php endif; ?>

    <input type="text" name="name" placeholder="Masukkan name" required />
    <?php if ($errors['name'] ?? false): ?>
        <div><?= h($errors['name']) ?></div>
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

    <input
        type="password"
        name="confirm_password"
        placeholder="Konfirmasi password"
        required
    />
    <?php if ($errors['confirm_password'] ?? false): ?>
        <div><?= h($errors['confirm_password']) ?></div>
    <?php endif; ?>

    <button type="submit">DAFTAR</button>
</form>

<?php if ($msg = flash('error')): ?>
    <div><?= h($msg) ?></div>
<?php endif;
