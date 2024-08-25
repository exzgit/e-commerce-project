<?php
session_start();
include 'db.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); 
    exit;
}

if (isset($_GET['idproduct'])) {
    $idproduct = htmlspecialchars($_GET['idproduct']);

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = htmlspecialchars($_POST['email']);
        $alamat = htmlspecialchars($_POST['alamat']);
        $message = htmlspecialchars($_POST['message']);

        $stmt = $conn->prepare("UPDATE cart_users SET USERMAIL = ?, ALAMAT = ?, USERMESSAGE = ? WHERE ID = ?");
        $stmt->bind_param("ssss", $email, $alamat, $message, $idproduct);

        if ($stmt->execute()) {
            header("Location: profile.php?id=" . urlencode($_SESSION['user_id']));
            exit;
        } else {
            echo "Gagal memperbarui produk.";
        }

        $stmt->close();
    } else {
        $stmt = $conn->prepare("SELECT * FROM cart_users WHERE ID = ?");
        $stmt->bind_param("s", $idproduct);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            echo "Produk tidak ditemukan.";
            exit;
        }

        $stmt->close();
    }
} else {
    echo "IDPRODUCT tidak ditemukan di URL.";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="../source/styles/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <main>
        <div class="w-full h-screen bg-[#E6E6E6] flex flex-col justify-center items-center">
            <div class="w-1/3">

                <form action="" method="post" enctype="multipart/form-data">
                    <div class="w-full shadow-xl flex p-4 flex-col bg-white pb-4 border rounded-md gap-y-2">
                        <div class="flex p-4 border-b mb-2 border-[#8B5E3C]">
                            <a href="./profile.php" class="text-xl 2xl:text-3xl text-[#8B5E3C]"><i class="fas fa-home"></i></a>
                            <div class="w-full">
                                <h1 class="text-lg md:text-xl lg:text-2xl 2xl:text-4xl w-full header text-center font-bold mb-1">Konfirmasi Pemesanan</h1>
                                <h1 class="text-md  w-full header text-center font-sans mb-1">Isi form dibawah untuk melanjutkan pesanan Anda</h1>
                            </div>
                        </div>
                        <div class="flex gap-x-2 items-center">
                            <div class="flex flex-col space-y-1 w-full">
                                <label for="inputemail" class="text-md 2xl:text-2xl font-medium">Email</label>
                                <input type="email" name="email" placeholder="Masukan email Anda" readonly id="inputemail" class="p-1 2xl:text-xl outline-none border-2 rounded-md" value="<?php echo htmlspecialchars($row['USERMAIL']); ?>">
                                
                                <label for="inputalamat" class="text-md font-medium 2xl:text-2xl">Alamat</label>
                                <input type="text" name="alamat" placeholder="Masukan alamat Anda" id="inputalamat" class="p-1 2xl:text-xl outline-none border-2 rounded-md" value="<?php echo htmlspecialchars($row['ALAMAT']); ?>">
                            </div>
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
                            <img src="<?php echo $imgSrc; ?>" alt="products" class="min-w-32 h-32 border border-gray-300 rounded-md">
                        </div>                     
                        <label for="inputmessage" class="text-md font-medium 2xl:text-2xl">Message</label>
                        <textarea name="message" placeholder="Masukan pesan Anda" id="inputmessage" class="p-1 2xl:text-xl min-h-48 max-h-48a outline-none border-2 rounded-md"><?php echo htmlspecialchars($row['USERMESSAGE']); ?></textarea>
                        
                        <button type="submit" class="p-2 2xl:text-2xl text-center w-[100%] bg-black font-medium rounded-md px-3 text-white">
                            Perbarui Produk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
