<?php
if(isset($_SESSION['logged_in'])) {
    // Destroy session
    session_unset();
    session_destroy();

    header("Location: login.php");
    exit();
} else {
    header("Location: login.php");
    exit();
}
?>
