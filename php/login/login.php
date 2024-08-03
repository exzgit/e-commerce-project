<?php
include 'db.php';
session_start();

$error_status = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT PASSWORD FROM usertb WHERE USERMAIL = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashedPassword);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $hashedPassword)) {
            $_SESSION['user'] = $email;
            header("Location: welcome.php");
            exit();
        } else {
            $error_status = "Password salah.";
        }
    } else {
        $error_status = "Email tidak ditemukan.";
    }

    $stmt->close();
    $conn->close();
}
?>