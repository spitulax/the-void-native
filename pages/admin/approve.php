<?php

require_once 'system/auth.php';
require_once 'system/main.php';
require_once 'system/tables/post.php';
require_once 'components/post.php';
require_once 'components/topNav.php';

$user = Auth::user();

if (!Auth::isAdmin()) {
    Response::notFound();
}

$posts = PostTable::allNotApproved();

$layout = new HTML('The Void: Setujui Postingan');

?>

<div class="flex flex-1 flex-col mx-4 md:mx-24 lg:mx-32 px-1 border-x-2 border-dark-gray">
    <?php topNav('Setujui Postingan'); ?>

    <?php $has = false; ?>
    <?php while ($post = $posts->fetch_assoc()): ?>
        <?php $has = true; ?>
        <div class="flex flex-col">
            <?php post($post, 'approving') ?>
        </div>
    <?php endwhile; ?>

    <?php if (!$has): ?>
        <span class="text-center text-light-gray w-full italic">Belum ada postingan.</span>
    <?php endif; ?>

    <div
        id="approve-toast" 
        class="fixed bottom-20 left-10 bg-accent-dark px-4 py-2 rounded-xs shadow-black shadow-md opacity-0 transition-opacity duration-500 cursor-pointer"
        onclick="hideToast('approve-toast')"
    >
        Postingan disetujui
    </div>

    <div
        id="reject-toast" 
        class="fixed bottom-20 left-10 bg-accent-dark px-4 py-2 rounded-xs shadow-black shadow-md opacity-0 transition-opacity duration-500 cursor-pointer"
        onclick="hideToast('reject-toast')"
    >
        Postingan ditolak dan dihapus
    </div>
</div>

<script src="/src/js/admin/approve.ts"></script>
