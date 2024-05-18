
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
<main class="login">
    <div class="login__container">
        <img class="logo" src="../images/logo.png" alt="Logo">
        <h2 class="login__title">Welcome!</h2>
        <form class="login__form" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
            <fieldset class="login__fieldset">
                <p class="login__input-name">E-mail or Username</p>
                <input class="login__input" type="text" name="username_or_email" required>
                <p class="login__input-name">Password</p>
                <input class="login__input" type="password" name="password" required>
            </fieldset>
            <div class="login__buttons">
                <button class="login__button">Log In</button>
<!--                <a href="signup.php" class="login__button">Sign Up</a>-->
            </div>
        </form>
        <p><a href="/" class="login__password">Forgot password?</a></p>
        <p><a href="signup.php" class="login__password">Don't have an account? <span class="signup-redirect">Sign Up</span></a></p>
    </div>
</main>
<?php
session_start(); // Start the session

$con = mysqli_connect("0.0.0.0","root",null,"CMPR_Project", 4306);
if (!$con)
{
    echo "Error in Connection: ";
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username_or_email = $_POST["username_or_email"]; // Combined username/email field
    $password = $_POST["password"];

    // Validate empty fields
    if (empty($username_or_email) || empty($password)) {
        echo "Please fill in both username/email and password fields.";
        exit();
    }

    // Prepared statement for login
    $sql_stmt = $con->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $sql_stmt->bind_param("ss", $username_or_email, $username_or_email);
    $sql_stmt->execute();
    $result = $sql_stmt->get_result();

    if ($result->num_rows == 1) {
        $user_data = $result->fetch_assoc();

        if (password_verify($password, $user_data['password'])) {
            $_SESSION = [
                'is_admin' => false,
                'logged_in' => true,
                'user_id' => $user_data['user_id'],
                'name' => $user_data['name'],
                'username' => $user_data['username'],
                'email' => $user_data['email']
            ];
            header("Cache-Control: no-cache, no-store, must-revalidate");
            header("Pragma: no-cache");
            header("Expires: 0");
            header("Location: homePage.php");
            exit();
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "Invalid username or email.";
    }
}
?>
</body>
</html>
