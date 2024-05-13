<?php
$cnn = mysqli_connect("0.0.0.0", "root", null, "CMPR_Project", 4306);
if (!$cnn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch products from database
$query = "SELECT product_name, product_description, product_category, price, preview_image_name FROM products";
$result = mysqli_query($cnn, $query);

if (!$result) {
    die("Error: " . mysqli_error($cnn));
}
mysqli_close($cnn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
  <link rel="stylesheet" href="../styles.css">
</head>
<body>
  <header class="header">
    <img class="logo" src="../images/logo.png" alt="logo">
    <nav class="header__nav">
      <ul class="header__nav-list">
        <li class="header__nav-list-item"><a href="homePage.php" class="header__nav-list-link active">Home page</a></li>
        <li class="header__nav-list-item"><a href="cart.php" class="header__nav-list-link">My Cart</a></li>
        <li class="header__nav-list-item"><a href="aboutUs.php" class="header__nav-list-link">About Us</a></li>
        <li class="header__nav-list-item"><a href="/" class="header__nav-list-link logout">Log Out</a></li>
      </ul>
    </nav>
  </header>
  <main>
    <div class="order">
      <div class="form__select-order">
        <p class="login__input-name">Order by</p>
        <select class="form__select">
          <option>Alphabet</option>
          <option>Price</option>
          <option>Date</option>
        </select>
      </div>
      <div>
        <p class="login__input-name">Display</p>
        <select class="form__select">
          <option>All</option>
          <option>Meals</option>
          <option>Drinks</option>
          <option>Starters</option>
          <option>Desserts</option>
        </select>
      </div>
    </div>
      <div class="home__grid-container">
          <?php
          if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                  echo '<div class="home__grid-item">';
                  $image_path = "../data/preview_images/" . htmlspecialchars($row['preview_image_name']);
                  echo '<img class="home__img" src="../data/preview_images/' . htmlspecialchars($row['preview_image_name']) . '" alt="' . htmlspecialchars($row['product_name']) . '">';
                  echo '<h3>' . htmlspecialchars($row['product_name']) . '</h3>';
                  echo '<p>' . htmlspecialchars($row['product_description']) . '</p>';
                  echo '<p>Category: ' . htmlspecialchars($row['product_category']) . '</p>';
                  echo '<p>Price: ' . htmlspecialchars(number_format($row['price'], 2)) . '</p>';
                  echo '</div>';
              }
          } else {
              echo "No products found.";
          }
          ?>
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