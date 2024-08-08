<?php
session_start();
include 'db.php';

$status_success = '';
$status_failed = '';
$email_error = '';

$conn->query("SET @id := 0");
$conn->query("UPDATE admindb SET ADMINID = @id := (@id + 1)");
$conn->query("ALTER TABLE admindb AUTO_INCREMENT = 1");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $adminname = $_POST['adminname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $adminimg = null;
    $fileType = '';
    if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $fileType = $_FILES['file']['type'];
        
        $adminimg = file_get_contents($fileTmpPath);
    } else {
        $default_img_path = '../source/image/default.jpg';
        $fileType = mime_content_type($default_img_path);
        $adminimg = file_get_contents($default_img_path);
    }

    $stmt = $conn->prepare("SELECT ADMINMAIL FROM admindb WHERE ADMINMAIL = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $email_error = "Email sudah terdaftar.";
        $stmt->close();
    } else {
        $stmt->close();

        $stmt = $conn->prepare("INSERT INTO admindb (ADMINNAME, ADMINMAIL, PASSWORD, ADMINIMG, IMGTYPE) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $adminname, $email, $password, $adminimg, $fileType);

        if ($stmt->execute()) {
            $status_success = 'Registrasi berhasil!';
        } else {
            $status_failed = 'Terjadi kesalahan: ' . $stmt->error;
        }
        $stmt->close();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../source/styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <!-- Main Content -->
    <main class="h-screen overflow-y-auto bg-[url('../source/image/background/wavebg.jpeg')] bg-cover bg-center flex items-center">
        <div class="flex flex-col overflow-y-auto items-center justify-center flex-grow p-6">
            <div class="bg-white shadow-cs rounded-lg p-8 w-full max-w-lg relative">
                <a href="index.php" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-xl"><i class="fas fa-home"></i></a>
                <h2 class="text-3xl font-bold mb-2 text-gray-800">Registrasi</h2>
                <p class="text-gray-600 mb-2">Daftar untuk membuat akun baru</p>

                <?php if (!empty($status_success)): ?>
                    <div class="mb-2 p-1 bg-green-100 border border-green-300 text-green-700 rounded">
                        <?php echo $status_success; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($status_failed)): ?>
                    <div class="mb-2 p-1 bg-red-100 border border-red-300 text-red-700 rounded">
                        <?php echo $status_failed; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($email_error)): ?>
                    <div class="mb-2 p-1 bg-red-100 border border-red-300 text-red-700 rounded">
                        <?php echo $email_error; ?>
                    </div>
                <?php endif; ?>

                <div class="w-full h-px mt-2 mb-4 bg-gradient-to-r from-purple-400 via-pink-500 to-red-500"></div>

                <form method="post" action="" enctype="multipart/form-data" class="space-y-4">
                    <label for="file" class="block text-center border-2 border-dashed rounded-full flex items-center justify-center w-32 h-32 mx-auto bg-gray-100 text-gray-600 font-medium cursor-pointer hover:bg-[#c0ae94] outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#c0ae94] transition-colors duration-200 ease-in-out">
                        <span class="text-gray-600">Upload Foto</span>
                        <img src="" alt="Profil" class="w-full h-full object-cover rounded-full" style="display: none;">
                    </label>
                    <input type="file" id="file" name="file" class="hidden">
                    <div>
                        <input type="text" id="adminname" name="adminname" placeholder="admin name" class="mt-1 block w-full px-3 py-1 border-b border-gray-300 shadow-sm outline-none focus:border-[#DCBC92]" required>
                    </div>
                    <div>
                        <input type="email" id="email" name="email" placeholder="Email" class="mt-1 block w-full px-3 py-1 border-b border-gray-300 shadow-sm outline-none focus:border-[#DCBC92]" required>
                    </div>
                    <div class="relative">
                        <input type="password" id="password" name="password" placeholder="Password" class="mt-1 block w-full px-3 py-1 border-b border-gray-300 shadow-sm outline-none focus:border-[#DCBC92]" required>
                        <i id="togglePassword" class="fa-solid fa-eye absolute right-3 top-[50%] translate-y-[-50%] cursor-pointer"></i>
                    </div>
                    <div>
                        <button type="submit" class="w-full bg-[#DCBC92] text-white py-2 px-4 rounded-md hover:bg-[#B89C6F] outline-none">Sign Up</button>
                    </div>
                </form>

                <p class="mt-4 text-center text-gray-600">Sudah punya akun? <a href="login.php" class="text-[#DCBC92] hover:underline">Login di sini</a></p>
            </div>
        </div>
    </main>

    <script src="../source/scripts/index.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('file');
        const fileLabel = document.querySelector('label[for="file"]');
        const defaultText = fileLabel.querySelector('span');
        const imagePreview = fileLabel.querySelector('img');
        
        fileInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    defaultText.style.display = 'none';
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                };
                
                reader.readAsDataURL(file);
            } else {
                defaultText.style.display = 'block';
                imagePreview.style.display = 'none';
                imagePreview.src = '';
            }
        });
    });
</script>
</body>
</html>
