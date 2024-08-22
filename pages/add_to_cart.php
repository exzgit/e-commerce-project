<?php
session_start();
include 'db.php';

$is_logged_in = isset($_SESSION['user_id']);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$username = '';
$usermail = '';
$statuspesanan = '';

$product_id = $_POST['product_id'];  // ID produk yang di-post
$product_price = $_POST['product_price'];
$product_img = $_POST['product_img'];
$product_name = $_POST['product_name'];
$methodPengiriman = 'JNE Express';
$statuspesanan = 'Menunggu balasan';

if ($is_logged_in) {
    $user_id = $_SESSION['user_id'];
    
    // Ambil data user
    $sql = "SELECT USERNAME, USERMAIL FROM usertb WHERE USERID = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($username, $usermail);
    
    if ($stmt->fetch() === false) {
        die("User not found.");
    }
    
    $stmt->close();
    
    // Cek apakah produk sudah ada di keranjang untuk user ini
    $sql = "SELECT ID FROM cart_users WHERE IDPRODUCT = ? AND IDPEMESAN = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    
    $stmt->bind_param("ii", $product_id, $user_id);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        // Jika produk sudah ada di keranjang
        echo "Produk sudah ada di dalam keranjang.";
    } else {
        // Jika produk belum ada di keranjang, tambahkan produk
        $stmt->close();

        $sql = "INSERT INTO cart_users (IDPRODUCT, USERNAME, USERMAIL, TOTALPRICING, METHODPENGIRIMAN, STATUS, SUBJECT, IMGPRODUCT, IDPEMESAN) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }
        
        $stmt->bind_param("ississssi", $product_id, $username, $usermail, $product_price, $methodPengiriman, $statuspesanan, $product_name, $product_img, $user_id);
        
        if ($stmt->execute()) {
            echo "Produk berhasil ditambahkan ke dalam keranjang.";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
    
    $stmt->close();
} else {
    echo "User not logged in.";
}

$conn->close();
?>
