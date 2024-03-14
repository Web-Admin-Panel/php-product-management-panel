<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Product</title>
  <link rel="stylesheet" href="./styles.css">
</head>
<body>
  <header class="header">
    <nav class="header__nav">
      <ul class="header__nav-list">
        <li class="header__nav-list-item"><a href="homePage.php" class="header__nav-list-link">Home page</a></li>
        <li class="header__nav-list-item"><a href="addProduct.html" class="header__nav-list-link active">Add Product</a></li>
        <li class="header__nav-list-item"><a href="manageUsers.html" class="header__nav-list-link">Manage Users</a></li>
        <li class="header__nav-list-item"><a href="/" class="header__nav-list-link logout">Log Out</a></li>
      </ul>
    </nav>
  </header>
  <main class="page">
    <form class="login__form">
      <fieldset class="login__fieldset">
        <p class="login__input-name">Name</p>
        <input class="login__input" type="text" required>
        <p class="login__input-name">Description</p>
        <input class="login__input" type="text" required>
      </fieldset>
      <div class="wrapper">
        <div class="price__wrapper">
          <p class="login__input-name">Price</p>
          <input class="price" type="text" required>
        </div>
        <div>
          <p class="login__input-name">Category</p>
          <select class="form__select">
            <option>Meals</option>
            <option>Drinks</option>
            <option>Starters</option>
            <option>Desserts</option>
          </select>
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
              <input id="files" class="login__input file__input" type="file" required>
          </div>
      </div>

      </div>
      <div class="login__buttons">
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

</body>
</html>