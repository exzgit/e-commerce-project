<?php
include 'db.php';
session_start();

$error_status = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query untuk mengambil ADMINID dan PASSWORD
    $stmt = $conn->prepare("SELECT ADMINID, PASSWORD FROM admindb WHERE ADMINMAIL = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($adminId, $hashedPassword);
        $stmt->fetch();

        if (password_verify($password, $hashedPassword)) {
            // Simpan USERID dan tipe pengguna ke session
            $_SESSION['user_id'] = $adminId;
            $_SESSION['user_type'] = 'admin';
            header("Location: admin.php");
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
<body class="bg-[url('../source/image/background/wavebg.jpeg')] bg-cover bg-center flex flex-col h-screen">
    <!-- Main Content -->
    <main class="flex flex-col justify-center items-center flex-grow p-6">
        <div class="shadow-cs bg-white rounded-lg p-8 w-full max-w-md relative">
            <a href="index.php" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-xl"><i class="fas fa-home"></i></a>
            <h2 class="text-3xl font-bold mb-2">Login Admin</h2>
            <?php if (!empty($error_status)): ?>
                <div class="mb-2 p-1 bg-red-100 border border-red-300 text-red-700 rounded">
                    <?php echo $error_status; ?>
                </div>
            <?php endif; ?>


            <div class="w-full h-px mt-2 mb-4 bg-gradient-to-r from-purple-400 via-pink-500 to-red-500"></div>

            <form method="post" action="" class="space-y-4">
                <div>
                    <input type="email" id="email" name="email" placeholder="Username" class="mt-1 block w-full px-3 py-1 border-b border-gray-300 shadow-sm outline-none focus:border-[#DCBC92]" required>
                </div>
                <div class="relative">
                    <input type="password" id="password" name="password" placeholder="Password" class="mt-1 block w-full px-3 py-1 border-b border-gray-300 shadow-sm outline-none focus:border-[#DCBC92]" required>
                    <i id="togglePassword" class="fa-solid fa-eye absolute right-[12px] top-[50%] translate-y-[-50%] cursor-pointer"></i>
                </div>
                <div>
                    <button type="submit" class="w-full bg-[#DCBC92] text-white py-2 px-4 rounded-md hover:bg-[#B89C6F] outline-none">Sign In</button>
                </div>
            </form>
        </div>
    </main>

    <script src="../source/scripts/index.js"></script>
</body>
</html>
