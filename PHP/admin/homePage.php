<?php
include ("../session.php");
include("../isAdmin.php");
global $con;
include("../dbConnection.php");
// Validate and sanitize GET parameters
$valid_sort_columns = ["product_name", "price"];
$valid_order_types = ["asc", "desc"];
$valid_groups = ["all", "meals", "drinks", "starters", "desserts"];


if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (
        (isset($_GET['sort_by']) && in_array($_GET['sort_by'], $valid_sort_columns))
        &&
        (isset($_GET['order']) && in_array($_GET['order'], $valid_order_types))
        &&
        (isset($_GET['display_group']) && in_array($_GET['display_group'], $valid_groups))
    ){
        $sort_by = $_GET['sort_by'];
        $order = $_GET['order'];
        $group_to_display = $_GET['display_group'];
        $_SESSION['filters'] = array(
            'sort_by' => $sort_by,
            'order' => $order,
            'group_to_display' => $group_to_display,
        );
    }
    else {
        $sort_by = 'product_name';
        $order = 'asc';
        $group_to_display = 'all';
    }
}
else if (isset($_SESSION['filters'])){
    $sort_by = $_SESSION['filters']['sort_by'];
    $order = $_SESSION['filters']['order'];
    $group_to_display = $_SESSION['filters']['group_to_display'];
}
else {
    $sort_by = isset($_GET['sort_by']) && in_array($_GET['sort_by'], $valid_sort_columns) ? $_GET['sort_by'] : 'product_name';
    $order = isset($_GET['order']) && in_array($_GET['order'], $valid_order_types) ? $_GET['order'] : 'asc';
    $group_to_display = isset($_GET['display_group']) && in_array($_GET['display_group'], $valid_groups) ? $_GET['display_group'] : 'all';
}


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
    <img class="logo" src="../data/logo_images/logo.png" alt="logo">
    <nav class="header__nav">
      <ul class="header__nav-list">
          <li class="header__nav-list-item"><a href="homePage.php" class="header__nav-list-link header__admin-nav-list-link active"><span>Home</span> <span>page</span></a></li>
          <li class="header__nav-list-item"><a href="addProduct.php" class="header__nav-list-link header__admin-nav-list-link"><span>Add</span> <span>Product</span></a></li>
          <li class="header__nav-list-item"><a href="manageUsers.php" class="header__nav-list-link header__admin-nav-list-link"><span>Manage</span> <span>Users</span></a></li>
          <li class="header__nav-list-item"><a href="../user/logout.php" class="header__nav-list-link header__admin-nav-list-link"><span>Log</span> <span>Out</span></a></li>
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
                          <option value="product_name" <?php echo ($sort_by == 'product_name') ? 'selected' : ''; ?>>Alphabet</option>
                          <option value="price" <?php echo ($sort_by == 'price') ? 'selected' : ''; ?>>Price</option>
                      </select>
                      <select class="form__select" name="order" onchange="this.form.submit()">
                          <option value="asc" <?php echo ($order == 'asc') ? 'selected' : ''; ?>>&#8593;
                          </option>
                          <option value="desc" <?php echo ($order == 'desc') ? 'selected' : ''; ?>>&#8595;
                          </option>
                      </select>
                  </div>
                  <div class="form__filter-element">
                      <p class="form__filter-element-label">DISPLAY</p>
                      <select class="form__select" name="display_group" onchange="this.form.submit()">
                          <option value="all" <?php echo ($group_to_display == 'all') ? 'selected' : ''; ?>>All</option>
                          <option value="meals" <?php echo ($group_to_display == 'meals') ? 'selected' : ''; ?>>Meals</option>
                          <option value="drinks" <?php echo ($group_to_display == 'drinks') ? 'selected' : ''; ?>>Drinks</option>
                          <option value="starters" <?php echo ($group_to_display == 'starters') ? 'selected' : ''; ?>>Starters</option>
                          <option value="desserts" <?php echo ($group_to_display == 'desserts') ? 'selected' : ''; ?>>Desserts</option>
                      </select>
                  </div>
              </div>
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

                      echo "<div class='manage-product-buttons'><input type='button' class='manage-product-button' value='UPDATE' onclick = \"window.location.href='updateProduct.php?id=".$row["product_id"]."'\">";
                      echo "<input type='button' class='manage-product-button' value='DELETE' onclick = \"window.location.href='deleteProduct.php?id=".$row["product_id"]."'\">";
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
          <a href="https://github.com/Web-Admin-Panel/php-product-management-panel/tree/main" target="_blank"><img class="footer__icon" src="../data/logo_images/github.png" alt="Github icon"></a>
          <a href="https://t.me/remainedmind"><img class="footer__icon" src="../data/logo_images/telegram.png" alt="Telegram icon" target="_blank"></a>
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