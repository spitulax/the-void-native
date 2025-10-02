<?php

require_once 'system/main.php';

$layout = new HTML('The Void: Halaman Tidak Ditemukan');

?>

<div class="flex flex-1 justify-center items-center gap-8 md:gap-20 flex-col md:flex-row">
    <div class="flex items-center justify-center gap-1 flex-row md:flex-col">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 4.233 4.233" class="size-16 md:size-64">
          <path d="M2.12.617a1.5 1.5 0 0 0-.773.212l.305.518a.9.9 0 0 1 .468-.127.9.9 0 0 1 .461.127L2.893.83A1.5 1.5 0 0 0 2.12.617M.915 1.22a1.5 1.5 0 0 0-.298.9A1.504 1.504 0 0 0 2.12 3.617 1.504 1.504 0 0 0 3.617 2.12a1.5 1.5 0 0 0-.298-.9l-.369.553a.9.9 0 0 1 .07.347.9.9 0 0 1-.9.9.9.9 0 0 1-.9-.9.9.9 0 0 1 .063-.347Zm1.205.418a.48.48 0 0 0-.482.482.48.48 0 0 0 .482.475.48.48 0 0 0 .475-.475.48.48 0 0 0-.475-.482" style="fill:#fff"/>
        </svg>
        <span class="font-extrabold text-3xl my-heading">The Void</span>
    </div>

    <div class="p-10 lg:p-12 w-3/4 md:w-1/2 flex flex-col justify-center items-center gap-10 w-full">
        <span class="font-extrabold my-heading text-2xl md:text-3xl lg:text-4xl text-center uppercase">Halaman tidak ditemukan</span>
        <a onclick="history.back();" class="hover:underline cursor-pointer font-bold my-heading text-xl text-accent hover:text-accent-light">Kembali</a>
    </div>
</div>
