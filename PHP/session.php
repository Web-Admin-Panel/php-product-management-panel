<?php
session_start();
global $con;
if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
    $user_id = $_SESSION['user_id'];
    $user_name = $_SESSION['name'];
    $user_username = $_SESSION['username'];
    $user_email = $_SESSION['email'];
    $user_id = $_SESSION['user_id'];
} else {
    header("Location: ../user/login.php");
    exit();
}
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

?>
