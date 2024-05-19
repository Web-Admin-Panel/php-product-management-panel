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
    <img class="logo" src="../data/logo_images/logo.png" alt="logo">
    <nav class="header__nav">
      <ul class="header__nav-list">
        <li class="header__nav-list-item"><a href="homePage.php" class="header__nav-list-link">Home page</a></li>
        <li class="header__nav-list-item"><a href="cart.php" class="header__nav-list-link">My Cart</a></li>
        <li class="header__nav-list-item"><a href="aboutUs.php" class="header__nav-list-link active">About Us</a></li>
        <li class="header__nav-list-item"><a href="logout.php" class="header__nav-list-link">Log Out</a></li>
      </ul>
    </nav>
  </header>
  <main style="margin: 0 50px">

      <section>
          <h2>Our Story</h2>
          <p>Welcome to <strong>The Golden Cup</strong>, your new favorite destination for online food ordering, where great taste meets convenience. Born out of a love for food and a passion for technology. We embarked on this adventure with one simple mission: to bring the delicious flavors of the world right to your doorstep.</p>
      </section>

      <section>
          <h2>What We Do</h2>
          <p>At <strong>The Golden Cup</strong>, we specialize in delivering a vast array of food options directly to you. Whether you're craving an early morning breakfast, a midday snack, or a sumptuous dinner, we've got you covered. Our platform is designed to offer an effortless ordering process, providing you with a seamless, enjoyable experience from browsing to eating.</p>
      </section>

      <section>
          <h2>Why Choose Us</h2>
          <ul>
              <li><strong>Quality and Variety:</strong> We meticulously select our restaurant partners to ensure a wide variety of high-quality meal options, catering to all taste buds and dietary requirements.</li>
              <li><strong>Fast and Reliable:</strong> Understanding the essence of time, we pride ourselves on our fast and reliable delivery service, ensuring your meals arrive promptly and in perfect condition.</li>
              <li><strong>Sustainable Practices:</strong> Caring for the environment is at our core. We're committed to eco-friendly packaging and actively work towards reducing food wastage.</li>
              <li><strong>Customer-Centric:</strong> Your satisfaction is our priority. Our customer service team is always on standby to assist with any inquiries or to share a recommendation, making sure your experience with us is nothing short of exceptional.</li>
          </ul>
      </section>

      <section>
          <h2>Our Team</h2>
          <p>Behind <strong>The Golden Cup</strong> is a diverse group of food enthusiasts, tech geeks, and logistics wizards, all united by a common goal: to revolutionize the way you enjoy food. Each team member brings something unique to the table, contributing to the creation of a service that we're truly proud of.</p>
      </section>

      <section>
          <h2>Our Promise</h2>
          <p>We're not just delivering meals; we're delivering happiness, one order at a time. As we grow and evolve, our promise to you remains unwavering: to provide a service that exceeds expectations, to continually expand our offerings, and to always keep the joy of food at the heart of everything we do.</p>
      </section>

  </main>
  <footer class="footer">
    <p>Instant Hunger Fix, Delivered</p>
    <p>&#169; Copyright</p>
    <nav>
      <a href="https://github.com/Web-Admin-Panel/php-product-management-panel/tree/main" target="_blank"><img class="footer__icon" src="../data/logo_images/github.png" alt="Github icon"></a>
      <a href="https://t.me/remainedmind"><img class="footer__icon" src="../data/logo_images/telegram.png" alt="Telegram icon" target="_blank"></a>
    </nav>
  </footer>
</body>
</html>

