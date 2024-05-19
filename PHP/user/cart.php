<?php
include ("../session.php");
global $con;
include("../dbConnection.php");  // Import $con variable

// Get the current user's ID
$user_id = $_SESSION['user_id'];

// Handle quantity changes
if (isset($_GET['product_id']) && isset($_GET['action'])) {
    $product_id = (int)$_GET['product_id'];
    $action = $_GET['action'];

    // Fetch the current amount
    $query = "SELECT amount FROM user_products WHERE user_id = '$user_id' AND product_id = '$product_id'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $current_amount = (int)$row['amount'];

        if ($action == 'increase') {
            $new_amount = $current_amount + 1;
        } elseif ($action == 'decrease' && $current_amount > 1) {
            $new_amount = $current_amount - 1;
        } else {
            $new_amount = $current_amount;
        }

        $update_query = "UPDATE user_products SET amount = '$new_amount' WHERE user_id = '$user_id' AND product_id = '$product_id'";
        mysqli_query($con, $update_query);
        header("Location: cart.php");
    }
}

// Fetch products in the user's cart
$query = "
    SELECT p.product_id, p.product_name, p.product_description, p.product_category, p.price, p.preview_image_name, up.amount
    FROM products p
    JOIN user_products up ON p.product_id = up.product_id
    WHERE up.user_id = '$user_id'
    ORDER BY p.product_name ASC";

$result = mysqli_query($con, $query);

if (!$result) {
    die("Error: " . mysqli_error($con));
}

$total_price = 0;
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
    <img class="logo" src="../data/logo_images/logo.png" alt="logo">
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
            <?php
            if (mysqli_num_rows($result) > 0) {
                echo '<div class="home__grid-container">';
                while ($row = mysqli_fetch_assoc($result)) {
                    $total_price += $row['price'] * $row['amount'];
                    echo '<div class="home__grid-item">';
                    $image_path = "../data/preview_images/" . htmlspecialchars($row['preview_image_name']);
                    echo '<div class="home__img-container"><img class="home__img" src="' . $image_path . '" alt="' . htmlspecialchars($row['product_name']) . '"></div>';
                    echo '<h3>' . htmlspecialchars($row['product_name']) . '</h3>';
                    echo '<p>' . htmlspecialchars($row['product_description']) . '</p>';
                    echo '<p>Category: ' . htmlspecialchars($row['product_category']) . '</p>';
                    echo '<p>Price: ' . htmlspecialchars(number_format($row['price'], 2)) . '</p>';
                    echo '<div class="quantity-control">';
                    echo "<button class='counter__button' onclick=\"window.location.href='cart.php?product_id=" . $row['product_id'] . "&action=decrease'\">-</button>";
                    echo '<span>' . htmlspecialchars($row['amount']) . '</span>';
                    echo "<button class='counter__button' onclick=\"window.location.href='cart.php?product_id=" . $row['product_id'] . "&action=increase'\">+</button>";
                    echo '</div>';
                    echo "<div class='manage-product-buttons'><input type='button' class='login__button' value='Delete' onclick=\"window.location.href='removeProductFromCart.php?id=" . $row['product_id'] . "'\">";
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "<h2 style='text-align: center;'>Your cart is empty.</h2>";
            }
            ?>

    </div>
    <div class="cart-total">
        <h1>Total: <?php echo number_format($total_price, 2); ?></h1>
    </div>
    <div class="cart-actions">
<!--        <button class="cart__button" onclick="window.location.href='clearCart.php'">Clear Cart</button>-->
<!--        <button class="cart__button" onclick="window.location.href='makeOrder.php'">Order</button>-->
        <button class="login__button" onclick="window.location.href='clearCart.php'">Clear Cart</button>
        <button class="login__button" onclick="window.location.href='makeOrder.php'">Order</button>
    </div>
</main>
<footer class="footer">
    <p>Instant Hunger Fix, Delivered</p>
    <p>&#169; Copyright</p>
    <nav>
        <a href="https://github.com/Web-Admin-Panel/php-product-management-panel/tree/main" target="_blank"><img class="footer__icon" src="../data/logo_images/github.png" alt="Github icon"></a>
        <a href="http://t.me/remainedmind"><img class="footer__icon" src="../data/logo_images/telegram.png" alt="Telegram icon" target="_blank"></a>
    </nav>
</footer>
<script>
    // Save scroll position before the page unloads
    window.onbeforeunload = function () {
        var scrollPos = window.scrollY;
        document.cookie = "scrollPos=" + scrollPos;
    };

    // Retrieve saved scroll position and scroll to it
    window.onload = function () {
        var cookies = document.cookie.split(';');
        for (var i = 0; i < cookies.length; i++) {
            var cookie = cookies[i].trim();
            if (cookie.startsWith('scrollPos=')) {
                var scrollPos = cookie.split('=')[1];
                window.scrollTo(0, parseInt(scrollPos));
                break;
            }
        }
    };
</script>
</body>
</html>
