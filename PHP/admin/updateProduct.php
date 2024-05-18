<?php
include ("../session.php");
include("../isAdmin.php");
global $con;
include("../dbConnection.php");  // Import $con variable

$product_id = $_GET["id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST["product_id"];
    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = (float) $_POST["price"];
    $category = $_POST["category"];

    // Handle file upload
    if (isset($_FILES['preview_image']) && $_FILES['preview_image']['error'] == 0) {
        $fileTmpPath = $_FILES['preview_image']['tmp_name'];
        $fileName = $_FILES['preview_image']['name'];
        $fileSize = $_FILES['preview_image']['size'];
        $fileType = $_FILES['preview_image']['type'];
        $fileNameExtension = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameExtension));

        // Generate a unique ID for the file
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

        // Directory where you want to save the file
        $uploadFileDir = '../data/preview_images/';
        $dest_path = $uploadFileDir . $newFileName;

        // Move the file into the directory
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            // Fetch the existing preview_image_name to delete the old image
            $sql = "SELECT preview_image_name FROM products WHERE product_id = $product_id";
            $result = mysqli_query($con, $sql);
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $oldImageName = $row['preview_image_name'];
                $oldImagePath = "../data/preview_images/" . $oldImageName;
                // Check if the old file exists and delete it
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $sql = "UPDATE products SET 
                        product_name='$name', 
                        product_description='$description', 
                        product_category='$category', 
                        price='$price', 
                        preview_image_name='$newFileName' 
                    WHERE product_id='$product_id'";
        } else {
            echo 'There was some error moving the file to the upload directory. Please make sure the upload directory is writable by web server.';
            exit;
        }
    } else {
        // Update without changing the image
        $sql = "UPDATE products SET 
                    product_name='$name', 
                    product_description='$description', 
                    product_category='$category', 
                    price='$price'
                WHERE product_id='$product_id'";
    }

    if (mysqli_query($con, $sql)) {
        echo "Product updated successfully.";
    } else {
        echo "Error updating product: " . mysqli_error($con);
    }

    mysqli_close($con);
    header("Location: homePage.php");
    exit;
} else {
    // Fetch existing product data
    $sql = "SELECT * FROM products WHERE product_id = $product_id";
    $result = mysqli_query($con, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
    } else {
        echo "<h1>Product not found!</h1>";
        exit;
    }
    mysqli_close($con);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
<header class="header">
    <nav class="header__nav">
        <ul class="header__nav-list">
            <li class="header__nav-list-item"><a href="homePage.php" class="header__nav-list-link">Home page</a></li>
            <li class="header__nav-list-item"><a href="addProduct.php" class="header__nav-list-link">Add Product</a></li>
            <li class="header__nav-list-item"><a href="manageUsers.php" class="header__nav-list-link">Manage Users</a></li>
            <li class="header__nav-list-item"><a href="../user/logout.php" class="header__nav-list-link">Log Out</a></li>
        </ul>
    </nav>
</header>
<main class="page">

    <form class="login__form" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
        <img class="login__logo" src="../images/logo.png" alt="Logo">
        <fieldset class="login__fieldset">
            <p class="login__input-name">Name</p>
            <input class="login__input" type="text" name="name" value="<?php echo htmlspecialchars($product['product_name']); ?>" required>
            <p class="login__input-name">Description</p>
            <input class="login__input" type="text" name="description" value="<?php echo htmlspecialchars($product['product_description']); ?>" required>
        </fieldset>
        <div class="wrapper">
            <div class="price__wrapper">
                <p class="login__input-name">Price</p>
                <input class="price" type="number" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
            </div>
            <div>
                <p class="login__input-name">Category</p>
                <select class="form__select" name="category">
                    <option <?php if ($product['product_category'] == "Meals") echo "selected"; ?>>Meals</option>
                    <option <?php if ($product['product_category'] == "Drinks") echo "selected"; ?>>Drinks</option>
                    <option <?php if ($product['product_category'] == "Starters") echo "selected"; ?>>Starters</option>
                    <option <?php if ($product['product_category'] == "Desserts") echo "selected"; ?>>Desserts</option>
                </select>
            </div>
            <div class="file__wrapper">
                <p class="login__input-name">Preview image</p>
                <div id="drop-area" class="drop-area">
                    <span class="file__text">Drag & Drop image here or click to upload</span>
                    <input type="hidden" name="MAX_FILE_SIZE" value="10000000">
                    <input id="files" class="login__input file__input" type="file" name="preview_image">
                </div>
            </div>
        </div>
        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
        <div class="add-product__buttons">
            <button type="reset" class="login__button">Reset</button>
            <button type="submit" class="login__button">Update</button>
        </div>
    </form>
</main>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dropArea = document.getElementById('drop-area');
        const fileInput = document.getElementById('files');
        const fileText = document.querySelector('.file__text');

        dropArea.addEventListener('dragover', (event) => {
            event.preventDefault();
            dropArea.classList.add('dragover');
        });

        dropArea.addEventListener('dragleave', (event) => {
            dropArea.classList.remove('dragover');
        });

        dropArea.addEventListener('drop', (event) => {
            event.preventDefault();
            dropArea.classList.remove('dragover');
            const files = event.dataTransfer.files;
            if (files.length) {
                fileInput.files = files;
                updateFileNameDisplay(files[0].name);
            }
        });

        fileInput.addEventListener('change', (event) => {
            if (event.target.files.length) {
                updateFileNameDisplay(event.target.files[0].name);
            }
        });

        function updateFileNameDisplay(name) {
            fileText.innerText = name;
        }
    });
</script>
</body>
</html>
