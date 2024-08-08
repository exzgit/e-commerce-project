<?php
include 'db.php';

$status_success = '';
$status_failed = '';

if (isset($_GET['code'])) {
    $verification_code = $_GET['code'];

    // Pastikan variabel $stmt didefinisikan dan diinisialisasi dengan benar
    $stmt = $conn->prepare("SELECT * FROM usertb WHERE verification_code = ? AND verified = 0");
    $stmt->bind_param("s", $verification_code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Jika kode verifikasi cocok dan pengguna belum diverifikasi
        $stmt = $conn->prepare("UPDATE usertb SET verified = 1 WHERE verification_code = ?");
        $stmt->bind_param("s", $verification_code);
        
        if ($stmt->execute()) {
            $status_success = 'Verifikasi berhasil! Anda sekarang dapat masuk.';
        } else {
            $status_failed = 'Terjadi kesalahan saat memperbarui status verifikasi.';
        }
    } else {
        $status_failed = 'Kode verifikasi tidak valid atau akun sudah diverifikasi.';
    }
    
    $stmt->close();
    $conn->close();
} else {
    $status_failed = 'Kode verifikasi tidak disediakan.';
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Verifikasi Email</title>
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
                <a href="index.html" class="text-white hover:text-gray-300">Home</a>
            </nav>
        </div>
    </header>
    
    <!-- Main Content -->
    <main class="flex flex-col justify-center items-center flex-grow p-6">
        <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md relative">
            <h2 class="text-3xl font-bold mb-2">Verifikasi Email</h2>
            <div class=" w-full h-px max-w-6xl mx-auto my-1"
                style="background-image: linear-gradient(90deg, rgba(149, 131, 198, 100) 1.46%, rgba(149, 131, 198, 0.6) 40.83%, rgba(149, 131, 198, 0.3) 65.57%, rgba(149, 131, 198, 0) 107.92%);">
            </div>
            
            <?php if (!empty($status_success)): ?>
                <span class="text-green-500 font-medium text-md px-2"><?php echo $status_success; ?></span>
            <?php endif; ?>

            <?php if (!empty($status_failed)): ?>
                <span class="text-red-500 font-medium text-md px-2"><?php echo $status_failed; ?></span>
            <?php endif; ?>

            <p class="mt-4 text-center text-gray-600">Silakan login setelah verifikasi.</p>
            <a href="login.php" class="text-[#DCBC92] hover:underline">Login di sini</a>
        </div>
    </main>
    
    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center py-4">
        <p>&copy; 2024 THE MIC. All rights reserved.</p>
    </footer>
</body>
</html>
