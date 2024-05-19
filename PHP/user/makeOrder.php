<?php
include ("../session.php");
global $con;
include("../dbConnection.php");  // Import $con variable

// Get the current user's ID and email
$user_id = $_SESSION['user_id'];
$user_email = $_SESSION['email'];

// Fetch products in the user's cart
$query = "
    SELECT p.product_name, p.product_description, p.product_category, p.price, up.amount
    FROM products p
    JOIN user_products up ON p.product_id = up.product_id
    WHERE up.user_id = '$user_id'
    ORDER BY p.product_name ASC";

$result = mysqli_query($con, $query);

if (!$result) {
    die("Error: " . mysqli_error($con));
}

// Initialize order details
$order_details = "";
$total_price = 0;

// Prepare order details
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $order_details .= "Product: " . $row['product_name'] . "\n";
        $order_details .= "Description: " . $row['product_description'] . "\n";
        $order_details .= "Category: " . $row['product_category'] . "\n";
        $order_details .= "Price: $" . number_format($row['price'], 2) . "\n";
        $order_details .= "Quantity: " . $row['amount'] . "\n\n";
        $total_price += $row['price'] * $row['amount'];
    }
    $order_details .= "Total Price: $" . number_format($total_price, 2) . "\n";
} else {
    $order_details = "No products in the cart.";
}

// Send email
$to = 'lemoonadresse@gmail.com';  // Replace with your email address
$subject = 'New Order from ' . $user_email;
$headers = 'From: ' . $user_email . "\r\n" .
    'Reply-To: ' . $user_email . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

// Clear the user's cart after order
$delete_query = "DELETE FROM user_products WHERE user_id = '$user_id'";
mysqli_query($con, $delete_query);

mysqli_close($con);

if (!$total_price){
    $order_result = "Your cart is empty.";
}
else if (mail($to, $subject, $order_details, $headers)){
    $order_result = "Order placed successfully! Our manager will contact you soon. Thank you for choosing Golden Cup";
}
else {
    $order_result = "Failed to place order. Please try again.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
<header class="header">
    <img class="logo" src="../images/logo.png" alt="logo">
    <nav class="header__nav">
        <ul class="header__nav-list">
            <li class="header__nav-list-item"><a href="homePage.php" class="header__nav-list-link">Home page</a></li>
            <li class="header__nav-list-item"><a href="cart.php" class="header__nav-list-link">My Cart</a></li>
            <li class="header__nav-list-item"><a href="aboutUs.php" class="header__nav-list-link">About Us</a></li>
            <li class="header__nav-list-item"><a href="logout.php" class="header__nav-list-link">Log Out</a></li>
        </ul>
    </nav>
</header>
<main class="home__main">
    <h1>Order Confirmation</h1>
    <p><?php echo $order_result ?></p>
</main>
<footer class="footer">
    <p>Instant Hunger Fix, Delivered</p>
    <p>&#169; Copyright</p>
    <nav>
        <a href="https://github.com/Web-Admin-Panel/php-product-management-panel/tree/main" target="_blank"><img class="footer__icon" src="../images/github.png" alt="Github icon"></a>
        <a href="https://t.me/remainedmind" target="_blank">><img class="footer__icon" src="../images/telegram.png" alt="Telegram icon"</a>
    </nav>
</footer>
</body>
</html>
