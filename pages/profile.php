<?php
session_start();
include 'db.php';
$is_logged_in = isset($_SESSION['user_id']);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$username = $regist_date = '';

if ($is_logged_in) {
    $user_id = $_SESSION['user_id'];
    
    // Ambil data pengguna
    $sql = "SELECT USERNAME, REGISTRATION_DATE FROM usertb WHERE USERID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($username, $regist_date);
    $stmt->fetch();
    $stmt->close();
    
    // Ambil data pesanan
    $sql = "SELECT * FROM cart_user WHERE IDPEMESAN = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
}
$conn->close();
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The MIC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../source/styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <main>
        <div class="w-full h-screen bg-gray-100">
            <div class="w-full h-64 bg-[url(https://img.freepik.com/free-photo/grey-geometrical-shapes-background_23-2148811539.jpg?uid=R117730523&ga=GA1.1.1739804183.1722268117&semt=sph)]  bg-cover bg-center flex items-center"></div>
            <div class="w-full flex space-x-12">
                
                <div class="w-1/5 bg-gray-200 flex flex-col shadow-sm shadow-gray-500 items-center space-y-2 h-screen fixed top-0 left-32">
                    <div class="bg-gray-300 flex justify-between items-center w-full mb-8 p-2 border-b">
                        <a href="index.php" class="text-gray-700 hover:text-gray-800 text-xl"><i class="fas fa-home"></i></a>
                        <!-- <a href="./usersetting.php" class="text-gray-700 hover:text-gray-800 text-xl bottom-0"><i class="fas fa-gear"></i></a> -->
                    </div>   
                
                    <div class="h-full flex flex-col items-center">
                        <?php if ($is_logged_in): ?>
                            <img src="display_image.php" class="bg-gray-300 w-32 h-32 rounded-full border border-gray-400 object-cover">
                            <h1 class="text-gray-500 font-bold text-2xl mt-6 border-b"><?= htmlspecialchars($username); ?></h1>
                            <span class="text-gray-400 italic text-sm"><?= htmlspecialchars($regist_date); ?></span>
                        <?php else: ?>
                            <img src="../source/image/default.jpg" class="bg-gray-300 w-32 h-32 rounded-full border border-gray-400 object-cover">
                            <h1 class="text-gray-500 font-bold text-2xl mt-6 border-b">Guest</h1>
                            <span class="text-gray-400 italic text-sm">No Registration Date</span>
                        <?php endif; ?>
                        
                        <div class="w-full px-2">
                            <div class="bg-gray-300 p-[1px] w-full"></div>
                            <div class="w-full hidden border bg-gray-300 rounded-md p-2">
                                <p class="text-gray-500 font-sm text-sm">Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus consectetur, iusto deserunt labore incidunt cupiditate eum? Cum, beatae ipsa. Deleniti.</p>
                            </div>
                        </div>
                   </div>
                    <div class="bg-gray-300 w-full mb-8 p-2 border-b">
                        <a href="./logout.php" class="text-gray-700 hover:text-gray-800 text-xl bottom-0"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </div>
                </div>

                <div class="w-1/3"></div>

                <div class="w-full p-6">
                    <div class="w-full">
                        <h1 class="text-black font-bold text-xl">Pesanan Saya</h1>
                        <div class="flex justify-between bg-gray-200 w-full">
                            <p class="text-sm font-medium p-1">Lihat detail pesanan Anda</p>
                            <a href="./index.php#CONTACT" class="text-blue-100 bg-blue-500 text-sm font-medium p-1">Pesan sekarang</a>
                        </div>
                        <div id="pemesanan" class="w-full flex flex-wrap gap-2 items-start justify-start p-2">
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <a href="#" class="relative w-48 flex flex-col items-start justify-end h-52 overflow-hidden bg-white border border-1 border-gray-400 rounded-xl">
                                    <img src="<?php echo htmlspecialchars($row['IMGPRODUCT']); ?>" alt="<?php echo htmlspecialchars($row['PRODUCTORDER']); ?>" class="h-full w-full object-cover border-b rounded-t-md">
                                    <h1 class="text-xl font-medium text-black px-1"><?= htmlspecialchars($row['PRODUCTORDER']); ?></h1>
                                    <h1 class="text-sm font-sans text-black px-1 bg-gray-200 m-1 rounded-md"><?= htmlspecialchars($row['STATUS']); ?></h1>
                                    <h1 class="text-md w-full font-bold text-orange-600 p-1 rounded-b-xl"><?= 'Rp' . number_format($row['TOTALPRICING'], 2, ',', '.'); ?></h1>
                                </a>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p></p>
                        <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
