<?php
include 'db.php';
session_start();
include '../AESKey.php'; 

$error_status = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT USERID, USERNAME, PASSWORD FROM usertb WHERE USERMAIL = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($userId, $username, $encrypted_password);
        $stmt->fetch();

        list($encrypted_data, $iv) = explode('::', base64_decode($encrypted_password), 2);
        $decrypted_password = openssl_decrypt($encrypted_data, 'AES-128-CBC', $key, 0, $iv);

        if ($decrypted_password === $password) {
            $_SESSION['user_id'] = $userId;
            $_SESSION['user_type'] = 'user'; 
            $_SESSION['username'] = $username;
            $_SESSION['usermail'] = $email;

            header("Location: profile.php");
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
    <style>
        .shadow-cs {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-[url('../source/image/background/wavebg.jpeg')] bg-cover bg-center flex flex-col h-screen">
    <main class="flex flex-col justify-center items-center flex-grow p-6">
        <div class="shadow-cs bg-white rounded-lg p-6 md:p-8 w-full max-w-md relative">
            <a href="index.php" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-xl"><i class="fas fa-home"></i></a>
            <h2 class="text-2xl md:text-3xl font-bold mb-2">Login</h2>
            <p class="text-gray-600 mb-4">Masuk untuk melanjutkan belanja Anda</p>
            <?php if (!empty($error_status)): ?>
                <div class="mb-4 p-2 bg-red-100 border border-red-300 text-red-700 rounded">
                    <?php echo $error_status; ?>
                </div>
            <?php endif; ?>

            <div class="w-full h-px mt-2 mb-4 bg-gradient-to-r from-purple-400 via-pink-500 to-red-500"></div>

            <form method="post" action="" class="space-y-4">
                <div>
                    <input type="email" id="email" name="email" placeholder="Email" class="mt-1 block w-full px-3 py-2 border-b border-gray-300 shadow-sm outline-none focus:border-[#DCBC92]" required>
                </div>
                <div class="relative">
                    <input type="password" id="password" name="password" placeholder="Password" class="mt-1 block w-full px-3 py-2 border-b border-gray-300 shadow-sm outline-none focus:border-[#DCBC92]" required>
                    <i id="togglePassword" class="fa-solid fa-eye absolute right-3 top-1/2 transform -translate-y-1/2 cursor-pointer"></i>
                </div>
                <div>
                    <button type="submit" class="w-full bg-[#DCBC92] text-white py-2 px-4 rounded-md hover:bg-[#B89C6F] outline-none">Sign In</button>
                </div>
            </form>
            
            <p class="mt-4 text-center text-gray-600">Belum punya akun? <a href="register.php" class="text-[#DCBC92] hover:underline">Daftar di sini</a></p>
        </div>
    </main>

    <script src="../source/scripts/index.js"></script>
</body>
</html>
