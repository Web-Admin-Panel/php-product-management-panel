<?php
session_start();
if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
    $user_id = $_SESSION['user_id'];
    $user_name = $_SESSION['name'];
    $user_username = $_SESSION['username'];
    $user_email = $_SESSION['email'];
    include("dbConnection.php");
    $user_id = $_SESSION['user_id'];
    $query = "SELECT admin_level FROM admins WHERE user_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $stmt->bind_result($admin_level);

    if ($stmt->fetch()) {
        $_SESSION['is_admin'] = true;
        $_SESSION['admin_level'] = $admin_level;
    } else {
        $_SESSION['is_admin'] = false;
    }

    $stmt->close();
} else {
    header("Location: login.php");
    exit();
}
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

?>
