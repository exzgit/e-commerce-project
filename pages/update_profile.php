<?php
session_start();
include 'db.php';
$is_logged_in = isset($_SESSION['user_id']);

if ($is_logged_in && isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
    $admin_id = $_SESSION['user_id'];
    $uploadDir = 'source/image/';
    $uploadFile = $uploadDir . basename($_FILES['profile_image']['name']);
    
    $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
    $check = getimagesize($_FILES['profile_image']['tmp_name']);
    if ($check !== false) {
        if ($_FILES['profile_image']['size'] < 2 * 1024 * 1024) {
            if ($imageFileType === 'jpg' || $imageFileType === 'jpeg' || $imageFileType === 'png' || $imageFileType === 'gif') {
                if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $uploadFile)) {
                    $sql = "UPDATE admindb SET ADMINIMG = ? WHERE ADMINID = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("si", basename($_FILES['profile_image']['name']), $admin_id);
                    $stmt->execute();
                    $stmt->close();
                    header('Location: admin.php');
                } else {
                    echo "Terjadi kesalahan saat mengunggah gambar.";
                }
            } else {
                echo "Hanya file JPG, JPEG, PNG, dan GIF yang diperbolehkan.";
            }
        } else {
            echo "Ukuran file terlalu besar. Maksimal 2MB.";
        }
    } else {
        echo "File yang diunggah bukan gambar.";
    }
} else {
    echo "Tidak ada file yang diunggah atau terjadi kesalahan.";
}
?>
