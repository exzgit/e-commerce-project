<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ./login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Selamat Datang</title>
</head>
<body>
    <h2>Selamat Datang, <?php echo $_SESSION['user']; ?>!</h2>
    <p><a href="logout.php">Logout</a></p>
</body>
</html>
