<?php
$is_logged_in = isset($_SESSION['user_id']);
?>

<footer class="bg-[#1F1F1F] py-8">
    <div class="container text-white mx-auto px-4 flex flex-col items-center">
        <div class="flex flex-col md:flex-row justify-between w-full max-w-6xl text-gray-300">
            <div class="mb-4 md:mb-0">
                <h2 class="text-xl font-bold mb-2">THE M.I.C</h2>
                <p>© 2024 MIC Military Industrial Complex. All rights reserved.</p>
            </div>
            <div class="flex flex-col md:flex-row gap-6">
                <div class="mb-4 md:mb-0">
                    <h3 class="font-semibold mb-2">Quick Links</h3>
                    <ul>
                        <li><a href="#HOME" class="hover:text-[#DFD1BF]">Home</a></li>
                        <li><a href="#ABOUT" class="hover:text-[#DFD1BF]">About</a></li>
                        <li><a href="#SHOP" class="hover:text-[#DFD1BF]">Shop</a></li>
                        <li><a href="#CONTACT" class="hover:text-[#DFD1BF]">Contact</a></li>
                        <?php if ($is_logged_in): ?>
                            <li id="profile-btn"><a href="./profile.html" class="w-full h-full">Profile</a></li>
                        <?php else: ?>
                            <li><a href="./login.php" class="hover:text-[#DFD1BF]">Login</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="mb-4 md:mb-0">
                    <h3 class="font-semibold mb-2">Contact Us</h3>
                    <p>Email: <a href="mailto:hello@THE_MIC.com" class="hover:text-[#DFD1BF]">hello@THE_MIC.com</a></p>
                    <p>Phone: <a href="tel:+123456789" class="hover:text-[#DFD1BF]">+123 456 789</a></p>
                </div>
                <div>
                    <h3 class="font-semibold mb-2">Follow Us</h3>
                    <div class="flex gap-4">
                        <a href="#" class="text-gray-300 hover:text-[#DFD1BF]"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-gray-300 hover:text-[#DFD1BF]"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-300 hover:text-[#DFD1BF]"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-gray-300 hover:text-[#DFD1BF]"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

