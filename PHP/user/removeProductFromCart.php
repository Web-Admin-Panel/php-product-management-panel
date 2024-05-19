<?php
include("../session.php");
global $con;
include("../dbConnection.php");

$user_id = $_SESSION['user_id'];
$product_id = $_GET["id"];

// Remove the product from user's cart
$query = "DELETE FROM user_products WHERE user_id = '$user_id' and product_id = '$product_id'";
if (mysqli_query($con, $query)) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
//    header("Location: cart.php");
} else {
    echo "Error: " . mysqli_error($con);
}

mysqli_close($con);
?>