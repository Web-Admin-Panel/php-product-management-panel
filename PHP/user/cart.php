<?php
include ("../session.php");
global $con;
include("../dbConnection.php");  // Import $con variable

// Get the current user's ID
$user_id = $_SESSION['user_id'];

// Fetch products in the user's cart
$query = "
    SELECT p.product_id, p.product_name, p.product_description, p.product_category, p.price, p.preview_image_name 
    FROM products p
    JOIN user_products up ON p.product_id = up.product_id
    WHERE up.user_id = '$user_id'
    ORDER BY p.product_name ASC";

$result = mysqli_query($con, $query);

if (!$result) {
    die("Error: " . mysqli_error($con));
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
<header class="header">
    <img class="logo" src="../images/logo.png" alt="logo">
    <nav class="header__nav">
        <ul class="header__nav-list">
            <li class="header__nav-list-item"><a href="homePage.php" class="header__nav-list-link">Home page</a></li>
            <li class="header__nav-list-item"><a href="cart.php" class="header__nav-list-link active">My Cart</a></li>
            <li class="header__nav-list-item"><a href="aboutUs.php" class="header__nav-list-link">About Us</a></li>
            <li class="header__nav-list-item"><a href="logout.php" class="header__nav-list-link">Log Out</a></li>
        </ul>
    </nav>
</header>
<main class="home__main">
    <div class="home__grid-wrapper">
        <div class="home__grid-container">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="home__grid-item">';
                    $image_path = "../data/preview_images/" . htmlspecialchars($row['preview_image_name']);
                    echo '<div class="home__img-container"><img class="home__img" src="' . $image_path . '" alt="' . htmlspecialchars($row['product_name']) . '"></div>';
                    echo '<h3>' . htmlspecialchars($row['product_name']) . '</h3>';
                    echo '<p>' . htmlspecialchars($row['product_description']) . '</p>';
                    echo '<p>Category: ' . htmlspecialchars($row['product_category']) . '</p>';
                    echo '<p>Price: $' . htmlspecialchars(number_format($row['price'], 2)) . '</p>';
                    echo "<div class='manage-product-buttons'><input type='button' class='login__button' value='Remove' onclick=\"window.location.href='removeProductFromCart.php?id=".$row['product_id']."'\">";
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "No products found.";
            }
            ?>
        </div>
    </div>
    <div class="cart-actions">
        <button class="cart__button" onclick="window.location.href='clearCart.php'">Clear Cart</button>
        <button class="cart__button" onclick="window.location.href='order.php'">Order</button>
    </div>
</main>
<footer class="footer">
    <p>Instant Hunger Fix, Delivered</p>
    <p>&#169; Copyright</p>
    <nav>
        <a href="https://github.com/Web-Admin-Panel/php-product-management-panel/tree/main" target="_blank"><img class="footer__icon" src="../images/github.png" alt="Github icon"></a>
        <a href="http://t.me/remainedmind"><img class="footer__icon" src="../images/telegram.png" alt="Telegram icon" target="_blank"></a>
    </nav>
</footer>
</body>
</html>
