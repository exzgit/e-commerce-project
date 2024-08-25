<?php
include 'db.php';
session_start();

$idProduct = isset($_GET['idproduct']) ? intval($_GET['idproduct']) : 0;

$query = "SELECT * FROM cart_users WHERE ID = ?";

$stmt = $conn->prepare($query);

if ($stmt === false) {
    $message = "Gagal mempersiapkan pernyataan: " . $conn->error;
} else {
    $stmt->bind_param("i", $idProduct);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
        } else {
            $message = "Tidak ada data ditemukan untuk ID yang diberikan.";
        }
        
        $stmt->close();
    } else {
        $message = "Gagal menjalankan query: " . $stmt->error;
    }
}

$conn->close();

if (isset($message)) {
    echo "<p>$message</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRODUCTS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="../source/styles/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <main>
        <div class="w-full h-screen bg-[#E6E6E6] flex flex-col items-center">
            <div class="flex z-20 fixed items-end bg-[#E6E6E6] h-16 w-full px-16 2xl:h-20">
                <nav class="flex items-end h-16 w-full border-b-2 border-gray-400 items-center">
                    <a href="./admin.php" class="text-center flex items-center justify-center 2xl:text-4xl"><i class="fas fa-home"></i></a>
                    <span class="text-gray-800 m-2 p-2 font-bold text-xl 2xl:text-4xl">THE M.I.C</span>
                </nav>
            </div>

            <div id="terkirim" class="w-full flex justify-center">
                <div class="w-1/3">
                    <div class="w-full h-[450px] 2xl:h-[720px] shadow-xl bg-white mt-20 2xl:mt-32 pb-4 border rounded-md">
                        <div class="pt-4 border-b-2 border-gray-400">
                            <h1 class="text-xl font-medium text-center 2xl:text-4xl">Penawaran Kerja</h1>
                            <h3 class="text-md font-medium text-center 2xl:text-2xl">Order ID: <?php echo isset($data['ID']) ? htmlspecialchars($data['ID']) : 'Tidak ada data'; ?></h3>
                            <div class="flex items-center px-6 py-2 justify-center">
                                <a class="p-2 rounded-full border-2 border-[#F5AA73] bg-[#976036]"></a>
                                <label class="w-16 xl:w-20 h-1 bg-[#F5AA73]"></label>
                                <a class="p-2 rounded-full border-2 border-[#F5AA73] bg-[#976036]"></a>
                                <label class="w-16 xl:w-20 h-1 bg-[#F5AA73]"></label>
                                <a class="p-2 rounded-full border-2 border-[#F5AA73] bg-[#976036]"></a>
                                <label class="w-16 xl:w-20 h-1 bg-[#F5AA73]"></label>
                                <a class="p-2 rounded-full border-2 border-[#F5AA73] bg-[#976036]"></a>
                            </div>
                            <div class="flex items-center px-6 justify-center">
                                <span class="text-[#976036]">Harga</span>
                                <label class="w-6 h-1"></label>
                                <span class="text-[#976036]">Deskripsi</span>
                                <label class="w-6 h-1"></label>
                                <span class="text-[#976036]">Pekerjaan</span>
                                <label class="w-6 h-1"></label>
                                <span class="text-[#976036]">Terkirim</span>
                            </div>
                        </div>
                        <div class="flex flex-col my-2 mx-6 gap-y-2">
                            <h1 class="text-md 2xl:text-2xl font-bold">Judul Pekerjaan: </h1>
                            <h1 class="text-md font-medium p-1 border 2xl:text-2xl rounded-md"><?php echo isset($data['SUBJECT']) ? htmlspecialchars($data['SUBJECT']) : 'Tidak ada data'; ?></h1>
                            <h1 class="text-md 2xl:text-2xl font-bold">Deskripsi Pekerjaan: </h1>
                            <p class="w-full h-36 2xl:h-64 border 2xl:text-2xl overflow-y-auto relative rounded-md p-1">
                                User: <?php echo isset($data['USERMESSAGE']) ? nl2br(htmlspecialchars(str_replace("\\r\\n", " ", $data['USERMESSAGE']))) : 'Tidak ada data'; ?><br>
                                Admin: <?php echo isset($data['ADMINMESSAGE']) ? nl2br(htmlspecialchars(str_replace("\\r\\n", " ", $data['ADMINMESSAGE']))) : 'Tidak ada data'; ?><br>
                                Bahan 3D Print: <?php echo isset($data['BAHANPRINT']) ? nl2br(htmlspecialchars(str_replace("\\r\\n", " ", $data['BAHANPRINT']))) : 'Bahan default'; ?><br>
                                Panjang: <?php echo isset($data['PANJANG']) ? nl2br(htmlspecialchars(str_replace("\\r\\n", " ", $data['PANJANG']))) : 'Tidak ada data'; ?><br>
                                Lebar: <?php echo isset($data['LEBAR']) ? nl2br(htmlspecialchars(str_replace("\\r\\n", " ", $data['LEBAR']))) : 'Tidak ada data'; ?><br>
                                Tinggi: <?php echo isset($data['TINGGI']) ? nl2br(htmlspecialchars(str_replace("\\r\\n", " ", $data['TINGGI']))) : 'Tidak ada data'; ?><br>
                                Jumlah Revisi: <?php echo isset($data['REVISION']) ? nl2br(htmlspecialchars(str_replace("\\r\\n", " ", $data['REVISION']))) : 'Tidak ada data'; ?><br>
                            </p>
                            <p class="w-full bg-gray-200 2xl:text-2xl 2xl:h-12 h-6 flex items-center text-gray-600 font-medium relative rounded-md p-1">
                                Durasi Kerja: <?php echo isset($data['STARTDATE']) ? htmlspecialchars($data['STARTDATE']) : 'Tidak ada data'; ?> - <?php echo isset($data['ENDDATE']) ? htmlspecialchars($data['ENDDATE']) : 'Tidak ada data'; ?>
                            </p>
                        </div>
                    </div>
                    <div class="flex my-2 space-x-4 w-full px-6">
                        <label onclick="location.href='admin.php'" class="p-2 2xl:p-3 2xl:text-2xl text-center w-full bg-black font-medium rounded-md px-3 text-white cursor-pointer">
                            Selesai
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
