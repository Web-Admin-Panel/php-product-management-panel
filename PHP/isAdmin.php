<?php
$is_admin = $_SESSION['is_admin'];
if (!$is_admin){
    header("Location: login.php");
    exit();
}
?>
