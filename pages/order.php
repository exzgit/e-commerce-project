<?php
include 'db.php';
session_start(); // Pastikan session dimulai untuk mengakses session data

$is_logged_in = isset($_SESSION['user_id']);
if (!$is_logged_in) {
    echo "User belum login.";
    exit;
}

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

// Ambil user ID dari session
$idpemesan = $_SESSION['user_id'];

$conn->query("SET @id := 0");
$conn->query("UPDATE cart_users SET ID = @id := (@id + 1)");
$conn->query("ALTER TABLE cart_users AUTO_INCREMENT = 1");

$username = $conn->real_escape_string($_POST['username']);
$email = $conn->real_escape_string($_POST['email']);
$subject = $conn->real_escape_string($_POST['subject']);
$message = $conn->real_escape_string($_POST['message']);
$bahanprint = $conn->real_escape_string($_POST['bahanprint']);
$panjang = intval($_POST['panjang']);
$lebar = intval($_POST['lebar']);
$tinggi = intval($_POST['tinggi']);
$alamat = $conn->real_escape_string($_POST['alamat']);
$pengiriman = 'JNE Express';
$status = 'Menunggu balasan';

$fileData = [];
$fileTypes = [];
if (isset($_FILES['file']) && $_FILES['file']['error'][0] === UPLOAD_ERR_OK) {
    foreach ($_FILES['file']['tmp_name'] as $key => $tmp_name) {
        if (is_uploaded_file($tmp_name)) {
            $fileData[] = file_get_contents($tmp_name); 
            $fileType = $_FILES['file']['type'][$key];
            $fileExt = strtolower(pathinfo($_FILES['file']['name'][$key], PATHINFO_EXTENSION));
            $fileTypes[] = isset($mimeTypes[$fileExt]) ? $mimeTypes[$fileExt] : 'application/octet-stream'; // Tentukan MIME type yang sesuai
        }
    }
} else {
    echo "Error uploading file: " . (isset($_FILES['file']['error']) ? implode(", ", $_FILES['file']['error']) : 'Unknown error');
    exit;
}

if (!empty($fileData)) {
    $file3D = implode(",", array_map('base64_encode', $fileData));
    $fileTypesStr = implode(",", $fileTypes);

    // Memperbaiki pernyataan SQL INSERT INTO
    $stmt = $conn->prepare("INSERT INTO cart_users (USERNAME, USERMAIL, IDPEMESAN, SUBJECT, USERMESSAGE, FILE, FILETYPE, BAHANPRINT, PANJANG, LEBAR, TINGGI, ALAMAT, METHODPENGIRIMAN, STATUS) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        echo "Error preparing statement: " . $conn->error;
        exit;
    }

    // Bind parameters dengan tipe data yang sesuai
    $stmt->bind_param("ssissssssiiiss", $username, $email, $idpemesan, $subject, $message, $file3D, $fileTypesStr, $bahanprint, $panjang, $lebar, $tinggi, $alamat, $pengiriman, $status);

    if ($stmt->execute()) {
        header("Location: ./profile.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "File tidak diunggah atau terjadi kesalahan.";
}

$conn->close();
?>
