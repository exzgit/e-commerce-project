<?php
session_start();
include 'db.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT USERIMG, IMGTYPE FROM usertb WHERE USERID = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($userimg, $imgtype);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && !empty($userimg)) {
        header("Content-Type: $imgtype");
        echo $userimg;
    } else {
        readfile('../source/image/default.jpg');
    }

    $stmt->close();
} else {
    readfile('../source/image/default.jpg');
}

$conn->close();
?>
