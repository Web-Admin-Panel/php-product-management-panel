<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up</title>
  <link rel="stylesheet" href="../styles.css">
</head>
<body>
  <main class="login">
    <div class="login__container">
      <img class="logo" src="../images/logo.png" alt="Logo">
      <h2 class="login__title">Name</h2>
      <form class="login__form">
        <fieldset class="login__fieldset">
          <p class="login__input-name">Name</p>
          <input class="login__input" type="text">
          <p class="login__input-name">Username</p>
          <input class="login__input" type="text">
          <p class="login__input-name">E-mail</p>
          <input class="login__input" type="email">
          <p class="login__input-name">Password</p>
          <input class="login__input" type="password">
          <p class="login__input-name">Confirm password</p>
          <input class="login__input" type="password">
        </fieldset>
        <div class="login__buttons">
          <button type="reset" class="login__button">Clear</button>
          <button class="login__button">Sign Up</button>
        </div>
        <p class="login__password">Already have an account? <a class="login__redirect" href="login.php">Log In</a></p>
      </form>
    </div>
  </main>
</body>
</html>