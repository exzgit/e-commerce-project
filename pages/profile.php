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
    
    $sql = "SELECT USERNAME, REGISTRATION_DATE FROM usertb WHERE USERID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($username, $regist_date);
    $stmt->fetch();
    $stmt->close();
    
    $sql = "SELECT * FROM cart_users WHERE IDPEMESAN = ?";
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
    <style>
        .sidebar {
            background-color: #0033a0;
            color: #fff; 
        }
        .sidebar a {
            color: #fff;
        }
        .sidebar .logout:hover {
            background-color: #111113; 
        }
        .sidebar .profile-info {
            border-bottom: 1px solid #0044cc;
        }
        .product-card {
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .btn-primary {
            background-color: #19191B;
            color: #fff;
        }
        .btn-primary:hover {
            background-color: #111113;
        }
        .card-footer {
            background-color: #f1f1f1;
            border-top: 1px solid #e1e1e1;
            padding: 10px;
        }
    </style>
</head>
<body>
    <main class="overflow-y-hidden">
        <div class="w-full h-screen overflow-y-scroll bg-gray-100">
            <div class="flex bg-[#9C8479] lg:hidden items-center text-white justify-between w-full">
                <a href="index.php" class="text-xl text-center p-4"><i class="fas fa-home"></i> Home</a>
                <a href="./logout.php" class="mt-auto p-4 text-center">Logout <i class="fas fa-sign-out-alt"></i></a>
            </div>
            <div class="w-full h-64 bg-[url(https://img.freepik.com/free-photo/3d-illustration-smartphone-with-paper-bags-gift-boxes-online-shopping-e-commerce-concept_58466-14625.jpg?t=st=1724583928~exp=1724587528~hmac=938a5885ca3fa9c41cfa61a222c2be2ced8eacc24a58de14d8df1a5e6a9de985&w=740)] bg-cover bg-center flex items-center justify-center">
                    <div class="flex text-black flex-col lg:hidden mt-6 relative items-center flex-grow p-4">
                        <?php if ($is_logged_in): ?>
                            <img src="display_image.php" class="w-32 h-32 rounded-full border border-gray-800 object-cover mb-4">
                            <h1 class="text-xl font-bold mb-2 border-b-2 border-black"><?= htmlspecialchars($username); ?></h1>
                            <span class="text-sm"><?= htmlspecialchars($regist_date); ?></span>
                        <?php else: ?>
                            <img src="../source/image/default.jpg" class="w-32 h-32 rounded-full border border-gray-400 object-cover mb-4">
                            <h1 class="text-xl font-bold mb-2 border-b-2 border-black">Guest</h1>
                            <span class="text-sm">No Registration Date</span>
                        <?php endif; ?>
                    </div>
            </div>
            <div class="flex">
                <aside class="sidebar w-1/5 lg:w-1/5 bg-[#0033a0] fixed top-0 left-0 h-screen hidden lg:flex flex-col shadow-lg">
                    <div class="bg-[#9C8479] flex justify-between items-center p-4 text-white border-b">
                        <a href="index.php" class="text-xl"><i class="fas fa-home"></i> Home</a>
                    </div>
                    <div class="flex bg-[#D1B7AB] text-black flex-col items-center flex-grow p-4">
                        <?php if ($is_logged_in): ?>
                            <img src="display_image.php" class="w-32 h-32 rounded-full border border-gray-800 object-cover mb-4">
                            <h1 class="text-xl font-bold mb-2 border-b-2 border-black"><?= htmlspecialchars($username); ?></h1>
                            <span class="text-sm"><?= htmlspecialchars($regist_date); ?></span>
                        <?php else: ?>
                            <img src="../source/image/default.jpg" class="w-32 h-32 rounded-full border border-gray-400 object-cover mb-4">
                            <h1 class="text-xl font-bold mb-2 border-b-2 border-black">Guest</h1>
                            <span class="text-sm">No Registration Date</span>
                        <?php endif; ?>
                        <a href="./logout.php" class="logout btn-primary mt-auto p-2 rounded text-center w-full">Logout <i class="fas fa-sign-out-alt"></i></a>
                    </div>
                </aside>
                <div class="flex-grow ml-0 lg:ml-64 2xl:ml-[400px] p-6">
                    <h1 class="text-3xl font-bold mb-4 text-[#29201C]">Keranjang Saya</h1>
                    <div class="flex justify-between items-center bg-[#D1B7AB] text-white rounded-lg mb-4">
                        <p class="text-sm font-medium p-2">Lihat detail pesanan Anda</p>
                        <a href="./index.php#CONTACT" class="p-2 rounded-r-lg bg-[#19191B] hover:bg-[#111113]">Pesan sekarang</a>
                    </div>
                    <div id="pemesanan" class="grid gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <?php 
                                $alamatTerisi = !empty($row['ALAMAT']);
                                $messageTerisi = !empty($row['USERMESSAGE']);
                                
                                $nextPage = ($alamatTerisi && $messageTerisi) ? 'detailcart.php' : 'nextcart.php';
                                ?>
                                
                                <button onclick="location.href='<?php echo $nextPage; ?>?idproduct=<?php echo urlencode($row['ID']); ?>'" class="product-card text-left relative w-full flex flex-col bg-white border border-gray-400 rounded-lg overflow-hidden">
                                    <?php
                                        if (isset($row['IMGPRODUCT']) && !empty($row['IMGPRODUCT'])) {
                                            $imgData = $row['IMGPRODUCT'];
                                            $imgMimeType = 'image/jpeg';
                                            $imgSrc = "data:{$imgMimeType};base64,{$imgData}";
                                        } else {
                                            // $imgSrc = "../source/image/productimg.jpg";
                                            $imgSrc = "https://img.freepik.com/free-photo/assortment-square-sides-geometric-cubes_23-2150832992.jpg";

                                        }
                                    ?>
                                    <img src="<?php echo $imgSrc; ?>" alt="" class="h-32 w-full object-cover border-b">
                                    <div class="p-2 flex flex-col flex-grow">
                                        <h1 class="text-lg font-medium text-black"><?= htmlspecialchars($row['PRODUCTORDER']); ?></h1>
                                        <h2 class="text-md font-medium text-gray-700"><?= htmlspecialchars($row['SUBJECT']); ?></h2>
                                        <span class="text-sm text-gray-500 bg-gray-200 p-1 rounded"><?= htmlspecialchars($row['STATUS']); ?></span>
                                    </div>
                                    <div class="card-footer w-full text-left">
                                        <span class="font-bold text-orange-600">
                                            <?php if (!empty($row['TOTALPRICING'])): ?>
                                                <?= 'Rp' . number_format($row['TOTALPRICING'], 2, ',', '.'); ?>
                                            <?php endif; ?>
                                        </span>
                                    </div>
                                </button>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p>Tidak ada produk yang ditemukan.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
