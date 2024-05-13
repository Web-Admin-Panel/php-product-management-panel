<?php
$cnn = mysqli_connect("0.0.0.0", "root", null, "CMPR_Project", 4306);
if (!$cnn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch products from database
$query = "SELECT product_id, product_name, product_description, product_category, price, preview_image_name FROM products";
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
    <nav class="header__nav">
      <ul class="header__nav-list">
        <li class="header__nav-list-item"><a href="homePage.php" class="header__nav-list-link active">Home page</a></li>
        <li class="header__nav-list-item"><a href="addProduct.php" class="header__nav-list-link">Add Product</a></li>
        <li class="header__nav-list-item"><a href="manageUsers.php" class="header__nav-list-link">Manage Users</a></li>
        <li class="header__nav-list-item"><a href="/" class="header__nav-list-link logout">Log Out</a></li>
      </ul>
    </nav>
  </header>
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
              echo "<input type='button' value='UPDATE' onclick = \"window.location.href='updateProduct.php?id=".$row["product_id"]."'\">";
              echo "<input type='button' value='DELETE' onclick = \"window.location.href='deleteProduct.php?id=".$row["product_id"]."'\">";
              echo '</div>';
          }
      } else {
          echo "No products found.";
      }
      ?>
  </div>
</body>
</html>