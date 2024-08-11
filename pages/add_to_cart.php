<?php
session_start();
include 'db.php';

$is_logged_in = isset($_SESSION['user_id']);

$conn->query("SET @id := 0");
$conn->query("UPDATE cart_user SET IDPESANAN = @id := (@id + 1)");
$conn->query("ALTER TABLE cart_user AUTO_INCREMENT = 1");


if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$username = '';
$usermail = '';
$statuspesanan = '';

$product_id = $_POST['product_id'];
$product_price = $_POST['product_price'];
$product_img = $_POST['product_img'];
$product_name = $_POST['product_name'];
$methodPengiriman = 'JNE EXPRESS';

if ($is_logged_in) {
    $user_id = $_SESSION['user_id'];
    
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
    
    $sql = "INSERT INTO cart_user (IDPRODUCT, USERNAME, USERMAIL, TOTALPRICING, METHODPENGIRIMAN, STATUS, PRODUCTORDER, IMGPRODUCT, IDPEMESAN) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    
    $stmt->bind_param("ississssi", $product_id, $username, $usermail, $product_price, $methodPengiriman, $statuspesanan, $product_name, $product_img, $user_id);
    
    if ($stmt->execute()) {
        echo "Product added to cart successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
} else {
    echo "User not logged in.";
}

$conn->close();
?>
