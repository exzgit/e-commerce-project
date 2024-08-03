<?php
include 'db.php';
session_start();

$error_status = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prevent SQL Injection
    $stmt = $conn->prepare("SELECT USER_PASSWORD FROM USERTB WHERE USER_EMAIL = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashedPassword);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $hashedPassword)) {
            $_SESSION['user'] = $email;
            header("Location: welcome.php");
            exit();
        } else {
            $error_status = "Password salah.";
        }
    } else {
        $error_status = "Email tidak ditemukan.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../source/styles/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="bg-gray-100 flex flex-col h-screen">
    <!-- Header -->
    <header class="bg-[#DCBC92] p-4 shadow-lg">
        <div class="container mx-auto flex items-center justify-between">
            <h1 class="text-2xl font-semibold text-white">THE M.I.C</h1>
            <nav>
                <a href="index.php" class="text-white hover:text-gray-300">Home</a>
            </nav>
        </div>
    </header>
    
    <!-- Main Content -->
    <main class="flex flex-col justify-center items-center flex-grow p-6">
        <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-2xl relative">
            <h2 class="text-3xl font-bold mb-2">Login</h2>
            <p class="text-gray-600 mb-2">Masuk untuk melanjutkan belanja Anda</p>
            <?php if (!empty($error_status)): ?>
                <span class="text-red-500 font-medium text-md px-2"><?php echo $error_status; ?></span>
            <?php endif; ?>
            <div class="bg-gray-400 py-[1px] w-full mb-4"></div>
            <form method="post" action="" class="space-y-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#DCBC92]" required>
                </div>
                <div class="relative">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#DCBC92]" required>
                    <i id="togglePassword" class="fa-solid fa-eye password-eye"></i>
                </div>
                <div>
                    <button type="submit" class="w-full bg-[#DCBC92] text-white py-2 px-4 rounded-md hover:bg-[#B89C6F] focus:outline-none focus:ring-2 focus:ring-[#B89C6F]">Login</button>
                </div>
            </form>
            
            <p class="mt-4 text-center text-gray-600">Belum punya akun? <a href="register.php" class="text-[#DCBC92] hover:underline">Daftar di sini</a></p>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center py-4">
        <p>&copy; 2024 THE MIC. All rights reserved.</p>
    </footer>

    <script src="../source/scripts/index.js"></script>
</body>
</html>
