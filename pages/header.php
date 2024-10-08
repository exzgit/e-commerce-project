<?php
session_start();
$is_logged_in = isset($_SESSION['user_id']);
$user_type = $is_logged_in ? $_SESSION['user_type'] : null;
?>


<div class="flex z-20 fixed items-end bg-[#E6E6E6] h-16 2xl:h-20 w-full justify-center px-16">
    <nav class="flex items-end h-16 2xl:h-20 w-full justify-between border-b-2 border-gray-400">
        <span class="text-gray-800 m-2 p-2 font-bold text-xl px-16 2xl:text-4xl">THE M.I.C</span>
        <ul class="flex items-center">
            <li class="text-center m-2 p-2 2xl:text-xl"><a href="#HOME">HOME</a></li>
            <li class="text-center m-2 p-2 2xl:text-xl"><a href="#ABOUT">ABOUT</a></li>
            <li class="text-center m-2 p-2 2xl:text-xl"><a href="#SHOP">SHOP</a></li>
            <li class="text-center m-2 p-2 2xl:text-xl"><a href="#CONTACT">CONTACT</a></li>
            <?php if ($is_logged_in): ?>
                <li id="profile-btn" class="text-center w-12 h-12 2xl:w-16 2xl:h-16 m-2 flex justify-center items-center rounded-full border-1 border-black">
                    <?php if ($user_type == 'admin'): ?>
                        <a href="./admin.php" class="w-full h-full">
                            <img src="display_image_admin.php" alt="Profil" class="w-full h-full object-cover rounded-full">
                    <?php else: ?>
                        <a href="./profile.php" class="w-full h-full">
                            <img src="display_image.php" alt="Profil" class="w-full h-full object-cover rounded-full">
                    <?php endif; ?>
                        </a>
                </li>
            <?php else: ?>
                <li class="text-center m-2 p-2 border-r"><a href="./login.php">LOGIN</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</div>
