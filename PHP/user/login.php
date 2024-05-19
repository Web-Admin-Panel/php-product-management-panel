
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<main class="login">
    <div class="login__container">
        <img class="logo" src="../data/logo_images/logo.png" alt="Logo">
        <h2 class="login__title">Welcome!</h2>
        <form class="login__form" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
            <fieldset class="login__fieldset">
<!--                <p class="login__input-name">E-mail or Username</p>-->
<!--                <input class="login__input" type="text" name="username_or_email" required>-->
<!--                <p class="login__input-name">Password</p>-->
<!--                <input class="login__input" type="password" name="password" required>-->

                <label class="login__input-name" for="username_or_email">E-mail or Username</label>
                <input class="login__input" type="text" name="username_or_email" id="username_or_email" required>

                <label class="login__input-name" for="password">Password</label>
                <input class="login__input" type="password" name="password" id="password" required>

            </fieldset>
            <div class="login__buttons">
                <button class="login__button" type="submit">Log In</button>
<!--                <a href="signup.php" class="login__button">Sign Up</a>-->
            </div>
        </form>
        <p><a href="/" class="login__password">Forgot password?</a></p>
        <p><a href="signup.php" class="login__password">Don't have an account? <span class="signup-redirect">Sign Up</span></a></p>
    </div>
</main>
<?php
session_start(); // Start the session
global $con;
include("../dbConnection.php");  // Import $con variable


if($_SERVER["REQUEST_METHOD"] == "POST") {
    $error_message = "";
    $username_or_email = $_POST["username_or_email"]; // Combined username/email field
    $password = $_POST["password"];

    // Validate empty fields
    if (empty($username_or_email) || empty($password)) {
        $error_message = "Please fill in both username/email and password fields.";
    } else {
        // Prepared statement for login
        $sql_stmt = $con->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $sql_stmt->bind_param("ss", $username_or_email, $username_or_email);
        $sql_stmt->execute();
        $result = $sql_stmt->get_result();

        if ($result->num_rows == 1) {
            $user_data = $result->fetch_assoc();
            $user_id = $user_data['user_id'];
            $admin_stmt = $con->prepare("SELECT * FROM admins WHERE user_id = ?");
            $admin_stmt->bind_param("i", $user_id);
            $admin_stmt->execute();
            $admin_result = $admin_stmt->get_result();

            if ($admin_result->num_rows == 1) {
                $admin_data = $admin_result->fetch_assoc();
                $is_admin = true;
                $admin_level = $admin_data['admin_level'];
            } else {
                $is_admin = false;
                $admin_level = null;
            }


            if (password_verify($password, $user_data['password'])) {
                $_SESSION = [
                    'is_admin' => $is_admin,
                    'logged_in' => true,
                    'admin_level' => $admin_level,
                    'user_id' => $user_id,
                    'name' => $user_data['name'],
                    'username' => $user_data['username'],
                    'email' => $user_data['email']
                ];
                if ($is_admin) {
                    header("Location: ../admin/homePage.php");
                } else {
                    header("Cache-Control: no-cache, no-store, must-revalidate");
                    header("Pragma: no-cache");
                    header("Expires: 0");
                    header("Location: homePage.php");
                }
//                return;
            } else {
                $error_message = "Incorrect password.";
            }
        } else {
            $error_message = "Invalid username or email.";
        }
    }
    if ($error_message) {
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
}
?>
</body>
</html>
