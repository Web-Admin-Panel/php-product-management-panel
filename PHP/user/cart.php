<?php
include ("../session.php");
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
        <li class="header__nav-list-item"><a href="homePage.php" class="header__nav-list-link">Home page</a></li>
        <li class="header__nav-list-item"><a href="cart.php" class="header__nav-list-link active">My Cart</a></li>
        <li class="header__nav-list-item"><a href="aboutUs.php" class="header__nav-list-link">About Us</a></li>
        <li class="header__nav-list-item"><a href="logout.php" class="header__nav-list-link">Log Out</a></li>
      </ul>
    </nav>
  </header>
  <main></main>
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