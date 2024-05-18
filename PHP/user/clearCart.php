<?php
include("../session.php");
global $con;
include("../dbConnection.php");

$user_id = $_SESSION['user_id'];

// Remove all products from user's cart
$query = "DELETE FROM user_products WHERE user_id = '$user_id'";
if (mysqli_query($con, $query)) {
    header("Location: cart.php");
} else {
    echo "Error: " . mysqli_error($con);
}

mysqli_close($con);
?>
