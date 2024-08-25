<?php
session_start();
include 'db.php';

$message = '';
$productstatus = 'Konfirmasi';
$mimeTypes = [
    'jpg' => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'png' => 'image/png',
    'stl' => 'application/vnd.ms-pki.stl',
    'fbx' => 'image/vnd.fbx',
    'obj' => 'application/x-tgif',
    'zip' => 'application/x-zip-compressed',
    'rar' => 'application/x-rar-compressed'
];

$row = [];

// Ambil ID produk dari URL
$idProduct = isset($_GET['idproduct']) ? $_GET['idproduct'] : '';

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $totalHarga = isset($_POST['totalharga']) ? $_POST['totalharga'] : '';
    $adminmessage = isset($_POST['adminmessage']) ? $_POST['adminmessage'] : '';
    $adminsubject = isset($_POST['adminsubject']) ? $_POST['adminsubject'] : '';
    $adminjobdesk = isset($_POST['adminjobdesk']) ? $_POST['adminjobdesk'] : '';
    $startdate = isset($_POST['startdate']) ? $_POST['startdate'] : '';
    $enddate = isset($_POST['enddate']) ? $_POST['enddate'] : '';
    $revisi = isset($_POST['revisi']) ? $_POST['revisi'] : '';
    $status = "Dikerjakan";

    if (is_numeric($idProduct) && is_numeric($totalHarga)) {
        $query = "UPDATE cart_users 
                    SET TOTALPRICING = ?, STATUS = ?, ADMINMESSAGE = ?, REVISION = ?, STARTDATE = ?, ENDDATE = ?, ADMINSUBJECT = ?, ADMINJOBDESK = ?, PRODUCTS = ?
                    WHERE ID = ?";
        
        $stmt = $conn->prepare($query);
        
        if ($stmt === false) {
            $message = "Gagal mempersiapkan pernyataan: " . $conn->error;
        } else {
            $stmt->bind_param("isssssssss", $totalHarga, $status, $adminmessage, $revisi, $startdate, $enddate, $adminsubject, $adminjobdesk, $productstatus, $idProduct);
            
            if ($stmt->execute()) {
                $message = "Data berhasil diperbarui.";
                header('Location: successupdate.php?idproduct=' . urlencode($idProduct));
                exit();
            } else {
                $message = "Gagal memperbarui data: " . $stmt->error;
            }
            
            $stmt->close();
        }
    } else {
        $message = "Data tidak valid.";
    }
}

// Handle file download
if (isset($_GET['download'])) {
    $fileId = $_GET['download'];

    if (is_numeric($fileId)) {
        $query = "SELECT FILE, FILETYPE, SUBJECT FROM cart_users WHERE ID = ?";
        $stmt = $conn->prepare($query);

        if ($stmt === false) {
            die("Gagal mempersiapkan pernyataan: " . $conn->error);
        } else {
            $stmt->bind_param("i", $fileId);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($fileData, $fileType, $subject);
                $stmt->fetch();

                if (!empty($fileData)) {
                    // Decode base64 file data
                    $fileData = base64_decode($fileData);

                    // Determine the file extension from FILETYPE
                    $fileExt = array_search($fileType, $mimeTypes);
                    if ($fileExt === false) {
                        $fileExt = 'bin'; // default binary extension if MIME type not found
                    }

                    // Determine the MIME type
                    $mimeType = isset($mimeTypes[$fileExt]) ? $mimeTypes[$fileExt] : 'application/octet-stream';
                    
                    // Set headers for file download
                    header("Content-Type: $mimeType");
                    header("Content-Disposition: attachment; filename=\"" . htmlspecialchars($subject) . "." . $fileExt . "\"");
                    header("Content-Length: " . strlen($fileData)); // Set the content length header
                    
                    echo $fileData;
                    exit;
                } else {
                    die("File tidak ditemukan.");
                }
            } else {
                die("ID produk tidak ditemukan.");
            }

            $stmt->close();
        }
    } else {
        die("ID produk tidak valid.");
    }
}

$conn->close();
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
            <div class="flex z-20 fixed items-end bg-[#E6E6E6] h-16 w-full px-16 2xl:h-10">
                <nav class="flex items-end h-16 w-full border-b-2 border-gray-400 items-center">
                    <a href="./admin.php" class="text-center flex items-center justify-center 2xl:text-4xl"><i class="fas fa-home"></i></a>
                    <span class="text-gray-800 m-2 p-2 font-bold text-xl 2xl:text-4xl">THE M.I.C</span>
                </nav>
            </div>
    
            <form class="w-full" method="POST" action="">

                <div id="harga" class="w-full flex justify-center">
                    <div class="w-1/3">
                    
                    <div class="w-full shadow-xl h-[450px] 2xl:h-[720px] bg-white mt-20 2xl:mt-32 pb-4 border rounded-md">
                        <div class="pt-4 border-b-2 border-gray-400">
                            <h1 class="text-xl font-medium text-center 2xl:text-4xl">Penawaran Kerja</h1>
                            <h3 class="text-md font-medium text-center 2xl:text-2xl">Order ID: <?php echo isset($idProduct) ? htmlspecialchars($idProduct) : 'Tidak ada data'; ?></h3>
                            <div class="flex items-center px-6 py-2 justify-center">
                                <a class="p-2 rounded-full border-2 border-[#F5AA73] bg-[#976036]"></a>
                                <label class="w-16 xl:w-20 h-1 bg-[#976036]"></label>
                                <a class="p-2 rounded-full border-2 border-[#976036] bg-[#976036]"></a>
                                <label class="w-16 xl:w-20 h-1 bg-[#976036]"></label>
                                <a class="p-2 rounded-full bg-[#976036] border-2 border-[#976036]"></a>
                                <label class="w-16 xl:w-20  h-1 bg-[#976036]"></label>
                                <a class="p-2 rounded-full bg-[#976036] border-2 border-[#976036]"></a>
                            </div>
                            <div class="flex items-center px-6 justify-center">
                                <span class="text-[#976036] 2xl:text-xl">Harga</span>
                                <label class="w-8  h-1"></label>
                                <span class="text-[#976036] 2xl:text-xl">Deskripsi</span>
                                <label class="w-8  h-1"></label>
                                <span class="text-[#976036] 2xl:text-xl">Pekerjaan</span>
                                <label class="w-8 mx-1 h-1"></label>
                                <span class="text-[#976036] 2xl:text-xl">Terkirim</span>
                            </div>
                        </div>
                        <div class="flex flex-col my-2 mx-6 gap-y-2">
                            <label for="inputharga" class="text-md font-medium 2xl:text-2xl">Total Harga</label>
                            <?php if($row['TOTALPRICING'] < 1):?>
                                <input type="number" name="totalharga" placeholder="Masukan Total Harga" id="inputharga" class="p-1 2xl:text-xl outline-none border-2 rounded-md ">
                            <?php else: ?>
                                <input type="number" readonly value="<?php echo $row['TOTALPRICING']; ?>" name="totalharga" placeholder="<?php echo 'Rp' . number_format($row['TOTALPRICING'], 2, ',', '.'); ?>" id="inputharga" class="p-1 2xl:text-xl outline-none border-2 rounded-md "> 
                            <?php endif; ?>
                            <p class="w-full h-52 2xl:text-xl leading-none border relative rounded-md p-1 2xl:min-h-64 2xl:max-h-64">
                                <b>Judul Pekerjaan:</b> <?php echo isset($row['SUBJECT']) ? htmlspecialchars($row['SUBJECT']) : 'Tidak ada data'; ?><br>
                                <b>Deskripsi Pekerjaan:</b> <?php echo isset($row['USERMESSAGE']) ? nl2br(htmlspecialchars(str_replace("\\r\\n", " ", $row['USERMESSAGE']))) : 'Tidak ada data'; ?><br>
                                <b>Bahan 3D Print:</b> <?php echo isset($row['BAHANPRINT']) ? htmlspecialchars($row['BAHANPRINT']) : 'Tidak ada data'; ?><br>
                                <b>Panjang:</b> <?php echo isset($row['PANJANG']) ? htmlspecialchars($row['PANJANG']) : 'Tidak ada data'; ?><br>
                                <b>Lebar:</b> <?php echo isset($row['LEBAR']) ? htmlspecialchars($row['LEBAR']) : 'Tidak ada data'; ?><br>
                                <b>Tinggi:</b> <?php echo isset($row['TINGGI']) ? htmlspecialchars($row['TINGGI']) : 'Tidak ada data'; ?><br>
                            </p>
                        </div>
                    </div>
                    <div class="flex my-2 space-x-4 justify-end w-full px-6">
                        <label onclick="toggleDiv('deskripsi')" class=" p-2 2xl:p-3 text-center w-[50%] bg-black font-medium rounded-full 2xl:text-2xl px-3 text-white">
                            Berikutnya
                        </label>
                    </div>
                </div>
            </div>
            <div id="deskripsi" class="w-full hidden flex justify-center">
                <div class="w-1/3">
                    <div class="w-full shadow-xl h-[450px] 2xl:h-[720px] bg-white mt-20 2xl:mt-32 pb-4 border rounded-md">
                        <div class="pt-4 border-b-2 border-gray-400">
                            <h1 class="text-xl font-medium text-center 2xl:text-4xl">Penawaran Kerja</h1>
                            <h3 class="text-md font-medium text-center 2xl:text-2xl">Order ID: <?php echo isset($row['ID']) ? htmlspecialchars($row['ID']) : 'Tidak ada data'; ?></h3>
                            <div class="flex items-center px-6 py-2 justify-center">
                                <a class="p-2 rounded-full border-2 border-[#F5AA73] bg-[#976036]"></a>
                                <label class="w-16 xl:w-20 h-1 bg-[#F5AA73]"></label>
                                <a class="p-2 rounded-full border-2 border-[#F5AA73] bg-[#976036]"></a>
                                <label class="w-16 xl:w-20  h-1 bg-[#976036]"></label>
                                <a class="p-2 rounded-full bg-[#976036] border-2 border-[#976036]"></a>
                                <label class="w-16 xl:w-20  h-1 bg-[#976036]"></label>
                                <a class="p-2 rounded-full bg-[#976036] border-2 border-[#976036]"></a>
                            </div>
                            <div class="flex items-center px-6 justify-center">
                                <span class="text-[#976036] 2xl:text-xl">Harga</span>
                                <label class="w-8  h-1"></label>
                                <span class="text-[#976036] 2xl:text-xl">Deskripsi</span>
                                <label class="w-8  h-1"></label>
                                <span class="text-[#976036] 2xl:text-xl">Pekerjaan</span>
                                <label class="w-8 mx-1 h-1"></label>
                                <span class="text-[#976036] 2xl:text-xl">Terkirim</span>
                            </div>
                        </div>
                        <div class="flex flex-col my-2 mx-6 gap-y-2">
                            <label for="inputjudul" class="text-md font-medium 2xl:text-2xl">Judul Pekerjaan</label>
                            <input type="text" name="adminsubject" readonly value="<?php echo $row['SUBJECT']; ?>" placeholder="Masukan Judul Pekerjaan" id="inputjudul" class="p-1 2xl:text-xl outline-none border-2 rounded-md ">
                            <label for="inputjudul" class="text-md font-medium 2xl:text-2xl">Deskripsi Pekerjaan</label>
                            <textarea name="adminjobdesk" class="w-full 2xl:text-xl min-h-32 max-h-32 2xl:min-h-64 2xl:max-h-64 border-2 relative rounded-md p-1 outline-none" readonly placeholder="Masukan Deskripsi Pekerjaan"><?php echo $row['USERMESSAGE']; ?></textarea>
                            <div class="flex w-full justify-between items-center">
                                <div class="flex flex-col items-center justify-center">
                                    <label for="methodpengiriman" class="text-md font-medium 2xl:text-2xl">Metode Pengiriman</label>
                                    <span class="text-sm p-1 w-full text-center border font-medium 2xl:text-xl">JNE Express</span>
                                </div>
                                <div class="flex flex-col items-center justify-center">
                                    <label for="methodpengiriman" class="text-md font-medium" 2xl:text-2xl>Bisa Revisi</label>
                                    <input type="number" name="revisi" class="text-sm p-1 w-20 2xl:text-xl text-center border font-medium outline-none" placeholder="0">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex my-2 space-x-4 w-full px-6">
                        <label onclick="toggleDiv('harga')" class=" p-2 2xl:p-3 text-center w-full bg-gray-400 2xl:text-2xl font-medium rounded-full px-3 text-white">
                            Kembali
                        </label>
                        <label onclick="toggleDiv('pekerjaan')" class=" p-2 2xl:p-3 text-center w-full 2xl:text-2xl bg-black font-medium rounded-full px-3 text-white">
                            Berikutnya
                        </label>
                    </div>
                </div>
            </div>

            <div id="pekerjaan" class="w-full hidden flex justify-center">
                <div class="w-1/3">
                    <div class="w-full shadow-xl h-[450px] 2xl:h-[720px] bg-white mt-20 2xl:mt-32 pb-4 border rounded-md">
                        <div class="pt-4 border-b-2 border-gray-400">
                            <h1 class="text-xl font-medium text-center 2xl:text-4xl">Penawaran Kerja</h1>
                            <h3 class="text-md font-medium text-center 2xl:text-2xl">Order ID: <?php echo isset($row['ID']) ? htmlspecialchars($row['ID']) : 'Tidak ada data'; ?></h3>
                            <div class="flex items-center px-6 py-2 justify-center">
                                <a class="p-2 rounded-full border-2 border-[#F5AA73] bg-[#976036]"></a>
                                <label class="w-16 xl:w-20 h-1 bg-[#F5AA73]"></label>
                                <a class="p-2 rounded-full border-2 border-[#F5AA73] bg-[#976036]"></a>
                                <label class="w-16 xl:w-20 h-1 bg-[#F5AA73]"></label>
                                <a class="p-2 rounded-full bg-[#976036] border-2 border-[#F5AA73] bg-[#976036]"></a>
                                <label class="w-16 xl:w-20  h-1 bg-[#976036]"></label>
                                <a class="p-2 rounded-full bg-[#976036] border-2 border-[#976036] bg-[#976036]"></a>
                            </div>
                            <div class="flex items-center px-6 justify-center">
                                <span class="text-[#976036] 2xl:text-xl">Harga</span>
                                <label class="w-8  h-1"></label>
                                <span class="text-[#976036] 2xl:text-xl">Deskripsi</span>
                                <label class="w-8  h-1"></label>
                                <span class="text-[#976036] 2xl:text-xl">Pekerjaan</span>
                                <label class="w-8 mx-1 h-1"></label>
                                <span class="text-[#976036] 2xl:text-xl">Terkirim</span>
                            </div>
                        </div>
                        <div class="flex flex-col my-2 mx-6 gap-y-2">
                            <div class="flex w-full gap-x-2">
                                <div class="">
                                    <label for="inputdate" class="text-md font-medium 2xl:text-2xl">Tanggal Pengerjaan</label>
                                    <input type="date" name="startdate" placeholder="Masukan Total Harga" id="inputdate" class="p-1 2xl:text-xl w-full outline-none border-2 rounded-md ">
                                </div>
                                <div class="">
                                    <label for="inputdate" class="text-md font-medium 2xl:text-2xl">Tanggal Pengiriman</label>
                                    <input type="date" name="enddate" placeholder="Masukan Total Harga" id="inputdate" class="p-1 2xl:text-xl w-full outline-none border-2 rounded-md ">
                                </div>
                            </div>
                            <label for="inputDesk" class="text-md font-medium 2xl:text-2xl">Deskripsi Tambahan</label>
                            <textarea name="adminmessage" class="w-full min-h-32 max-h-32 2xl:min-h-64 2xl:max-h-64 border-2 relative 2xl:text-xl rounded-md p-1 outline-none" placeholder="Masukan Deskripsi Pekerjaan"></textarea>
                            <?php if (!empty($row['FILE'])): ?>
                                <a href="?download=<?php echo htmlspecialchars($idProduct); ?>" class="bg-gray-100 2xl:text-2xl hover:bg-gray-200 border-gray-400 text-center font-medium text-gray-700 border w-full p-2 rounded-md"><i class="fas fa-file mr-2"></i>Unduh File 3D</a>
                            <?php else: ?>
                                <a href="#" class="primary-btn p-2 rounded-md 2xl:text-2xl" disabled>File Not Found</a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="flex my-2 space-x-4 w-full px-6">
                        <label onclick="toggleDiv('deskripsi')" class="p-2 2xl:p-3 text-center w-full 2xl:text-2xl bg-gray-400 font-medium rounded-full px-3 text-white">
                            Kembali
                        </label>
                        <button type='submit' class=" p-2 2xl:p-3 text-center w-full 2xl:text-2xl bg-black font-medium rounded-full px-3 text-white">
                            Berikutnya
                        </button>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </main>
    

    <script>
        function toggleDiv(divId) {
            const divs = ['harga', 'deskripsi', 'pekerjaan', 'terkirim'];

            divs.forEach(id => {
                const element = document.getElementById(id);
                if (element) {
                    if (id === divId) {
                        element.classList.remove('hidden');
                        element.classList.add('flex');
                    } else {
                        element.classList.remove('flex');
                        element.classList.add('hidden');
                    }
                }
            });

            localStorage.setItem('activeDiv', divId);
        }

    </script>
</body>
</html>