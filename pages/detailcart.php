<?php
session_start();
include 'db.php';

$row = [];
$message = '';
$idProduct = '';

// Cek ID produk dari URL
if (isset($_GET['idproduct'])) {
    $idProduct = $_GET['idproduct'];

    if (is_numeric($idProduct)) {
        $query = "SELECT * FROM cart_users WHERE ID = ?";
        
        $stmt = $conn->prepare($query);
        
        if ($stmt === false) {
            $message = "Gagal mempersiapkan pernyataan: " . $conn->error;
        } else {
            $stmt->bind_param("i", $idProduct);
            
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
            } else {
                $message = "Produk tidak ditemukan.";
            }
            
            $stmt->close();
        }
    } else {
        $message = "ID produk tidak valid.";
    }
} else {
    $message = "ID produk tidak ditemukan di URL.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DETAIL CART</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            background-color: #F7F4EF;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .header {
            color: #8B5E3C;
        }

        .product-details,
        .user-message,
        .admin-response {
            background-color: #F5E8DA;
            border: 1px solid #E0D1B3;
        }

        .label {
            background-color: #D4A373;
            color: #3E2723;
        }

        .rounded-md {
            border-radius: 12px;
        }

        .shadow-lg {
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.15);
        }

        .primary-btn {
            background-color: #8B5E3C;
            color: white;
            border-radius: 8px;
        }

        .primary-btn:hover {
            background-color: #6E482C;
        }

        .bg-secondary {
            background-color: #C69F7A;
        }
    </style>
</head>

<body>
    <div class="flex w-full h-screen 2xl:items-center justify-center">
    <div class="flex flex-col overflow-y-auto py-16 2xl:pt-0 md:flex-row justify-center h-auto gap-4 items-start w-full px-4">
        
        <div class="w-full border-2 md:w-1/2 lg:w-1/2 xl:w-1/2 product-details p-4 md:p-6 rounded-md shadow-lg">
            <div class="flex p-4 border-b mb-2 border-[#8B5E3C]">
                <a href="./profile.php" class="text-xl 2xl:text-3xl text-[#8B5E3C]"><i class="fas fa-home"></i></a>
                <h1 class="md md:text-xl lg:text-2xl 2xl:text-4xl w-full header text-center font-bold mb-4">Detail Produk</h1>
            </div>
            <div class="flex flex-col gap-4">
                <div class="block md:flex w-full gap-x-4 justify-between">
                    <div class="w-full border border-[#C69F7A] rounded-lg">
                        <p class="text-base md:md text-black rounded-t-lg font-medium px-1 bg-secondary  2xl:text-2xl">Nama Produk:</p>
                        <p class="text-base md:md text-black 2xl:text-xl p-2"><?php echo $row['SUBJECT']; ?></p>
                    </div>
                    <div class="w-full border border-[#C69F7A] rounded-lg">
                        <p class="text-base md:md text-black rounded-t-lg font-medium px-1 bg-secondary 2xl:text-2xl">Dimensi:</p>
                        <p class="text-base md:md text-black 2xl:text-xl pt-2 px-2">Panjang: <?php echo $row['PANJANG']; ?></p>
                        <p class="text-base md:md text-black 2xl:text-xl px-2">Lebar: <?php echo $row['LEBAR']; ?></p>
                        <p class="text-base md:md text-black 2xl:text-xl px-2">Tinggi: <?php echo $row['TINGGI']; ?></p>
                    </div>
                </div>
                <div class="block md:flex w-full gap-x-4 justify-between">
                    <div class="w-full border border-[#C69F7A] rounded-lg">
                        <p class="text-base md:md text-black rounded-t-lg font-medium px-1 bg-secondary 2xl:text-2xl">Bahan 3D Print:</p>
                        <p class="text-base md:md text-black 2xl:text-xl p-2"><?php echo $row['BAHANPRINT']; ?></p>
                    </div>
                    <div class="w-full border border-[#C69F7A] rounded-lg">
                        <p class="text-base md:md text-black rounded-t-lg font-medium px-1 bg-secondary 2xl:text-2xl">Jumlah Revisi:</p>
                        <p class="text-base md:md text-black 2xl:text-xl p-2"><?php echo $row['REVISION']; ?></p>
                    </div>
                </div>
                
                <div class="w-full border border-[#C69F7A] rounded-lg">
                    <p class="text-base md:md text-black rounded-t-lg font-medium px-1 bg-secondary 2xl:text-2xl">Durasi Kerja:</p>
                    <p class="text-base md:md text-black 2xl:text-xl p-2"><?php echo $row['STARTDATE']; ?> - <?php echo $row['ENDDATE']; ?></p>
                </div>
                <div class="w-full border border-[#C69F7A] rounded-lg">
                    <p class="text-base md:md text-black rounded-t-lg font-medium px-1 bg-secondary 2xl:text-2xl">Metode Pengiriman:</p>
                    <p class="text-base md:md text-black 2xl:text-xl p-2"><?php echo $row['METHODPENGIRIMAN']; ?></p>
                </div>
                <div class="w-full border border-[#C69F7A] rounded-lg">
                    <p class="text-base md:md text-black rounded-t-lg font-medium px-1 bg-secondary 2xl:text-2xl">Alamat:</p>
                    <p class="text-base md:md text-black 2xl:text-xl p-2"><?php echo $row['ALAMAT']; ?></p>
                </div>
                <div class="w-full border border-[#C69F7A] rounded-lg">
                    <p class="text-base md:md text-black rounded-t-lg font-medium px-1 bg-secondary 2xl:text-2xl">Total Harga:</p>
                    <p class="text-base md:md text-black 2xl:text-xl p-2"><?php echo 'Rp' . number_format($row['TOTALPRICING'], 2, ',', '.'); ?></p>
                </div>
            </div>
        </div>

        <div class="w-full md:w-2/3 lg:w-1/3 p-4 flex flex-col gap-4">
            <div class="user-message p-4 rounded-md shadow-lg">
                <label class="text-base md:md font-bold label p-2 rounded-t-lg block 2xl:text-2xl">Anda</label>
                <h1 class="text-base md:md p-4 text-[#6E482C] 2xl:text-xl"><?php echo $row['USERMESSAGE']; ?></h1>
            </div>
            <?php if ($row['PRODUCTS'] == "Konfirmasi"): ?>
            <div class="admin-response p-4 rounded-md shadow-lg">
                <label class="text-base md:md font-bold label p-2 rounded-t-lg block 2xl:text-2xl">Admin</label>
                <div class="text-left p-4 text-[#6E482C]">
                    <p class="2xl:text-xl"><?php echo $row['ADMINMESSAGE']; ?></p>
                    <div class="flex flex-col justify-center items-start p-2 rounded-md border shadow-md mt-4">
                        <p class="text-base md:md text-black font-medium 2xl:text-2xl">Metode Pembayaran</p>
                        <img src="https://www.frommers.com/system/media_items/attachments/000/870/669/s980/Fake_QR_Code.jpg?1690224743"
                            class="w-32 2xl:w-64 h-32 2xl:h-64 object-cover rounded-md mt-2">
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    </div>
</body>
</html>
