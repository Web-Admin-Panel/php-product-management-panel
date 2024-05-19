<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up</title>
  <link rel="stylesheet" href="../styles.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">


</head>
<body>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <main class="login">
    <div class="login__container">
      <img class="logo" src="../data/logo_images/logo.png" alt="Logo">
      <h2 class="login__title">Welcome to The Golden Cup</h2>
      <form class="login__form" action="<?php echo $_SERVER["PHP_SELF"];  ?>" method="post">
        <fieldset class="login__fieldset">
            <label>
                <p class="login__input-name">Name</p>
                <input class="login__input" type="text" name="name" required minlength="2">
            </label>

            <label>
                <p class="login__input-name">Username</p>
                <input class="login__input" type="text" name="username" required minlength="4">
            </label>

            <label>
                <p class="login__input-name">E-mail</p>
                <input class="login__input" type="email" name="email" required>
            </label>

            <label>
                <p class="login__input-name">Password</p>
                <input class="login__input" type="password" name="pass" required minlength="4">
            </label>

            <label>
                <p class="login__input-name">Confirm password</p>
                <input class="login__input" type="password" name="pass_confirmation" required minlength="4">
            </label>
        </fieldset>
        <div class="signup__buttons">
          <button type="reset" class="login__button">Clear</button>
          <button type="submit" class="login__button">Sign Up</button>
        </div>
        <p class="login__password">Already have an account? <a class="login__redirect" href="login.php">Log In</a></p>
      </form>
    </div>
  </main>

  <?php
  session_start();
  $error_message = "";
  global $con;
  include("../dbConnection.php");  // Import $con variable


  if($_SERVER["REQUEST_METHOD"] == "POST")
  {
      $name = $_POST["name"];
      $username = $_POST["username"];
      $email = $_POST["email"];
      $password = $_POST["pass"];
      $pass_confirmation = $_POST["pass_confirmation"];

      if (!ctype_alnum($username)){
//          echo "Special characters are not allowed for username!";
          $error_message = "Special characters are not allowed for username!";
//          return;
//          exit();
      }
      if (!ctype_alpha($name)){
//          echo "Number and special characters are not allowed for name!";
          $error_message = "Numbers and special characters are not allowed for name!";
//          return;
//          exit();
      }
      // Check for existing username or email (combined query)
      $sql_stmt = $con->prepare("SELECT * FROM users WHERE LOWER(username) = LOWER(?) OR LOWER(email) = LOWER(?)");
      $sql_stmt->bind_param("ss", $username, $email);
      $sql_stmt->execute();
      $result = $sql_stmt->get_result();


      // Validation part
      if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
          if (strtolower($row['username']) == strtolower($username)) {
              $error_message = "Username already exists! Please choose another.";

          } else {
              $error_message = "Email already exists! Please use a different email.";
          }
      }
      else if ($password != $pass_confirmation){
          $error_message = "Both your password inputs must match!";
      }
      // Check if there's an error and output the JavaScript for alert
      if ($error_message) {
//          echo "<script type='text/javascript'>alert('$error_message');</script>";
          echo "<script type='text/javascript'>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: '$error_message'
                    });
                });
              </script>";
          exit();
      }

      $password = password_hash($password, PASSWORD_DEFAULT);

      $sql_stmt = $con->prepare("INSERT INTO users(name, username, email, password) VALUES (?, ?, ?, ?);");
//      $sql = "INSERT INTO users(name, username, email, password) VALUES ('$name', '$username', '$email', '$password')";
      $sql_stmt->bind_param("ssss", $name, $username, $email, $password);
      $name = mysqli_real_escape_string($con, $name);
      $email = mysqli_real_escape_string($con, $email);
      $username = mysqli_real_escape_string($con, $username);
      $password = mysqli_real_escape_string($con, $password);

//      if(mysqli_query($con, $sql)){
      if($sql_stmt->execute()){
          echo "<h3>You've signed up successfully!</h3>";
          $inserted_id = $sql_stmt->insert_id;

          $_SESSION = [
              'is_admin'=> false,
              'logged_in' => true,
              'user_id' => $inserted_id,
              'name' => $name,
              'username' => $username,
              'email' => $email
          ];

          echo "Saved a user session with params: " . "id=" . $inserted_id . "; name=" . $name . "; username=" . $username ."; email=" . $email;
          header("Location: homePage.php");
      }
      else{
          echo "Error in adding new user .. ";
      }



  }
  ?>
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