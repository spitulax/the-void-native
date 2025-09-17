<?php

require_once 'system/auth.php';
require_once 'system/main.php';
require_once 'system/redirect.php';
require_once 'system/response.php';
require_once 'system/tables/user.php';
require_once 'components/button.php';

if (!Auth::isAdmin()) {
    Response::notFound();
}

$layout = new HTML('The Void: Dashboard Admin');

$user_query = UserTable::all();
?>

<h1>Dashboard Admin</h1>

<div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Nama</th>
                <th>Admin</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($user = $user_query->fetch_assoc()): ?>
            <tr>
                <td><?= h($user['id']) ?> </td>
                <td><?= h($user['username']) ?> </td>
                <td><?= h($user['name']) ?> </td>
                <td><?= $user['admin'] ? 'YA' : 'TIDAK' ?> </td>
                <td>
                    <div>
                        <?= button('post', '/user/delete', 'HAPUS', data: ['id' => $user['id']]) ?>
                    </div>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php if ($msg = flash('error')): ?>
    <div><?= h($msg) ?></div>
<?php elseif ($msg = flash('success')): ?>
    <div><?= h($msg) ?></div>
<?php endif;
