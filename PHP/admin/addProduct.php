<?php
include ("../session.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Product</title>
  <link rel="stylesheet" href="../styles.css">
</head>
<body>
  <header class="header">
    <nav class="header__nav">
      <ul class="header__nav-list">
        <li class="header__nav-list-item"><a href="homePage.php" class="header__nav-list-link">Home page</a></li>
        <li class="header__nav-list-item"><a href="addProduct.php" class="header__nav-list-link active">Add Product</a></li>
        <li class="header__nav-list-item"><a href="manageUsers.php" class="header__nav-list-link">Manage Users</a></li>
        <li class="header__nav-list-item"><a href="../user/logout.php" class="header__nav-list-link">Log Out</a></li>
      </ul>
    </nav>
  </header>
  <main class="page">

    <form class="login__form" action="<?php echo $_SERVER["PHP_SELF"];  ?>" method="post" enctype="multipart/form-data">
    <img class="login__logo" src="../images/logo.png" alt="Logo">
      <fieldset class="login__fieldset">
        <p class="login__input-name">Name</p>
        <input class="login__input" type="text" name="name" required>
        <p class="login__input-name">Description</p>
        <input class="login__input" type="text" name="description" required>
      </fieldset>
      <div class="wrapper">
        <div class="price__wrapper">
          <p class="login__input-name">Price</p>
          <input class="price" type="number" name="price" required>
        </div>
        <div>
          <p class="login__input-name">Category</p>
<!--            <label>-->
                <select class="form__select" name="category">
                  <option>Meals</option>
                  <option>Drinks</option>
                  <option>Starters</option>
                  <option>Desserts</option>
                </select>
<!--            </label>-->
        </div>
<!--        <div class="file__wrapper">-->
<!--          <p class="login__input-name">Preview image</p>-->
<!--          <label for="files" class="file__text">Choose file</label>-->
<!--          <input id="files" class="login__input file__input" type="file" required>-->
<!--        </div>-->
      <div class="file__wrapper">
          <p class="login__input-name">Preview image</p>
          <div id="drop-area" class="drop-area">
              <span class="file__text">Drag & Drop image here</span>
              <input type="hidden" name="MAX_FILE_SIZE" value="10000000">
              <input id="files" class="login__input file__input" type="file" name="preview_image" required>
          </div>
      </div>

      </div>
      <div class="add-product__buttons">
        <button type="reset" class="login__button">Reset</button>
        <button type="submit" class="login__button">Submit</button>
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


<?php
$cnn = mysqli_connect("0.0.0.0","root",null,"CMPR_Project", 4306);
if (!$cnn)
{
    echo "Error in Connection: ";
    exit();
}


if($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = (float) $_POST["price"];
    $category = $_POST["category"];
    echo "$name" . " | $description" . " | $price" . " | $category";
    echo "<pre>";
//    var_dump($_FILES);
    echo "</pre>";

    //    if (isset($_FILES['files']) && $_FILES['files']['error'] == 0) {
    if (isset($_FILES['preview_image'])) {

        $fileTmpPath = $_FILES['preview_image']['tmp_name'];
        $fileName = $_FILES['preview_image']['name'];
        $fileSize = $_FILES['preview_image']['size'];
        $fileType = $_FILES['preview_image']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
//        echo "File is sent. " . " $fileTmpPath; " . " $fileName; " . " $fileSize; " . "$fileNameCmps; " . " $fileExtension; " . "\n";


        // Generating a unique ID for the file
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

        // Directory where you want to save the file
        $uploadFileDir = '../data/preview_images/';
        $dest_path = $uploadFileDir . $newFileName;

        // Move the file into the directory
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $sqlFile = "INSERT INTO 
                products(product_name, product_description, product_category, price, preview_image_name) 
                VALUES 
                ('$name', '$description', '$category', '$price', '$newFileName')";
            if (mysqli_query($cnn, $sqlFile)) {
                echo "File is successfully uploaded and file info saved in database.";
            } else {
                echo "Error in adding file information to the database.";
            }
            echo 'Moved!';
        } else {
            echo 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';

        }
    }

}
?>
</body>
</html>