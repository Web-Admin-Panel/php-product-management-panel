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
      <h2 class="login__title">Welcome to The Golden Cup</h2>
      <form class="login__form" action="<?php echo $_SERVER["PHP_SELF"];  ?>" method="post">
        <fieldset class="login__fieldset">
          <p class="login__input-name">Name</p>
          <input class="login__input" type="text" name="name">
          <p class="login__input-name">Username</p>
          <input class="login__input" type="text" name="username">
          <p class="login__input-name">E-mail</p>
          <input class="login__input" type="email" name="email">
          <p class="login__input-name">Password</p>
          <input class="login__input" type="password" name="pass">
          <p class="login__input-name">Confirm password</p>
          <input class="login__input" type="password" name="pass_confirmation">
        </fieldset>
        <div class="login__buttons">
          <button type="reset" class="login__button">Clear</button>
          <button class="login__button">Sign Up</button>
        </div>
        <p class="login__password">Already have an account? <a class="login__redirect" href="login.php">Log In</a></p>
      </form>
    </div>
  </main>

  <?php
  $con = mysqli_connect("0.0.0.0","root",null,"CMPR_Project", 4306);
  if (!$con)
  {
      echo "Error in Connection: ";
      exit();
  }


  if($_SERVER["REQUEST_METHOD"] == "POST")
  {
      $name = $_POST["name"];
      $username = $_POST["username"];
      $email = $_POST["email"];
      $password = $_POST["pass"];
      $pass_confirmation = $_POST["pass_confirmation"];

      if ($password != $pass_confirmation){
          echo "Both your password inputs must match!";
          exit();

      }

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
          header("Location: homePage.php");
      }
      else{
          echo "Error in adding new user .. ";
      }


  }
  ?>
</body>
</html>