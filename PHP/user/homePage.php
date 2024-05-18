<?php
include ("../session.php");
global $con;
include("../dbConnection.php");  // Import $con variable

// Validate and sanitize GET parameters
$valid_sort_columns = ["product_name", "price"];
$valid_order_types = ["asc", "desc"];
$valid_groups = ["all", "meals", "drinks", "starters", "desserts"];

$sort_by = isset($_GET['sort_by']) && in_array($_GET['sort_by'], $valid_sort_columns) ? $_GET['sort_by'] : 'product_name';
$order = isset($_GET['order']) && in_array($_GET['order'], $valid_order_types) ? $_GET['order'] : 'asc';
$group_to_display = isset($_GET['display_group']) && in_array($_GET['display_group'], $valid_groups) ? $_GET['display_group'] : 'all';


$query = "SELECT product_id, product_name, product_description, product_category, price, preview_image_name FROM products";

// Add a WHERE clause if a specific group is selected
if ($group_to_display !== "all") {
    $group_to_display_safe = mysqli_real_escape_string($con, $group_to_display);
    $query .= " WHERE product_category = '$group_to_display_safe'";
}

// Add the ORDER BY clause
$query .= " ORDER BY $sort_by $order";

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
        <li class="header__nav-list-item"><a href="logout.php" class="header__nav-list-link">Log Out</a></li>
      </ul>
    </nav>
  </header>
  <main class="home__main">
      <div class="order">
          <form class="form__select-order" id="filterForm" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="get">
              <div class="form__filter_elements">
                  <div class="form__filter-element">
                      <p class="form__filter-element-label">ORDER BY</p>
                      <select class="form__select" name="sort_by" onchange="this.form.submit()">
                          <option value="product_name" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] == 'product_name') ? 'selected' : ''; ?>>Alphabet</option>
                          <option value="price" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] == 'price') ? 'selected' : ''; ?>>Price</option>
                      </select>
                      <select class="form__select" name="order" onchange="this.form.submit()">
                          <option value="asc" <?php echo (isset($_GET['order']) && $_GET['order'] == 'asc') ? 'selected' : ''; ?>>&#8595;
                          </option>
                          <option value="desc" <?php echo (isset($_GET['order']) && $_GET['order'] == 'desc') ? 'selected' : ''; ?>>&#8593;
                          </option>
                      </select>
                  </div>
                  <div class="form__filter-element">
                      <p class="form__filter-element-label">DISPLAY</p>
                      <select class="form__select" name="display_group" onchange="this.form.submit()">
                          <option value="all" <?php echo (isset($_GET['display_group']) && $_GET['display_group'] == 'all') ? 'selected' : ''; ?>>All</option>
                          <option value="meals" <?php echo (isset($_GET['display_group']) && $_GET['display_group'] == 'meals') ? 'selected' : ''; ?>>Meals</option>
                          <option value="drinks" <?php echo (isset($_GET['display_group']) && $_GET['display_group'] == 'drinks') ? 'selected' : ''; ?>>Drinks</option>
                          <option value="starters" <?php echo (isset($_GET['display_group']) && $_GET['display_group'] == 'starters') ? 'selected' : ''; ?>>Starters</option>
                          <option value="desserts" <?php echo (isset($_GET['display_group']) && $_GET['display_group'] == 'desserts') ? 'selected' : ''; ?>>Desserts</option>
                      </select>
                  </div>
              </div>


<!--              <button type="submit">SHOW</button>-->
          </form>

      </div>
      <div class="home__grid-wrapper">
      <div class="home__grid-container">
          <?php
          if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                  echo '<div class="home__grid-item">';
                  $image_path = "../data/preview_images/" . htmlspecialchars($row['preview_image_name']);
                  echo '<div class="home__img-container"><img class="home__img" src="../data/preview_images/' . htmlspecialchars($row['preview_image_name']) . '" alt="' . htmlspecialchars($row['product_name']) . '"></div>';
                  echo '<h3>' . htmlspecialchars($row['product_name']) . '</h3>';
                  echo '<p>' . htmlspecialchars($row['product_description']) . '</p>';
                  echo '<p>Category: ' . htmlspecialchars($row['product_category']) . '</p>';
                  echo '<p>Price: ' . htmlspecialchars(number_format($row['price'], 2)) . '</p>';
                  echo "<div class='manage-product-buttons'><input type='button' class='login__button' value='Add to Cart' onclick = \"window.location.href='addItemToCart.php?id=".$row["product_id"]."'\">";
                  echo "</div>";
                  echo '</div>';
              }
          } else {
              echo "No products found.";
          }
          ?>
      </div>
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