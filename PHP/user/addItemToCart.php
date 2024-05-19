<?php
include ("../session.php");
global $con;
include("../dbConnectionTemplate.php");  // Import $con variable

$user_id = $_SESSION['user_id'];
$product_id = $_GET["id"];


$sql = "INSERT INTO user_products (user_id, product_id) VALUES ($user_id, $product_id)";

if (mysqli_query($con, $sql)) {
    header("Location: homePage.php");
} else {
    echo "<h1>An error occurred while adding the product to cart!</h1>";
}

mysqli_close($con);
?>

