<?php
include ("../session.php");
include("../isAdmin.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Users</title>
  <link rel="stylesheet" href="../styles.css">
</head>
<body>
  <header class="header">
    <nav class="header__nav">
      <ul class="header__nav-list">
        <li class="header__nav-list-item"><a href="homePage.php" class="header__nav-list-link">Home page</a></li>
        <li class="header__nav-list-item"><a href="addProduct.php" class="header__nav-list-link">Add Product</a></li>
        <li class="header__nav-list-item"><a href="manageUsers.php" class="header__nav-list-link active">Manage Users</a></li>
        <li class="header__nav-list-item"><a href="../user/logout.php" class="header__nav-list-link">Log Out</a></li>
      </ul>
    </nav>
  </header>
</body>
</html>
<?php

$cnn = mysqli_connect("0.0.0.0","root",null,"CMPR_Project", 4306);
if (!$cnn)
{
    echo "Error in Connection: ";
    exit();
}

$sort_by = isset($_GET['sort_by']) && in_array($_GET['sort_by'], ['title', 'publication_year']) ? $_GET['sort_by'] : 'title';
$order = isset($_GET['order']) && in_array($_GET['order'], ['asc', 'desc']) ? $_GET['order'] : 'asc';

$sql = "SELECT * FROM users";

//$sql = "SELECT * FROM users ORDER BY $sort_by $order";

$result = mysqli_query($cnn, $sql);

if (mysqli_num_rows($result) > 0){
    echo "<h2>Users</h2>";
    echo "<table><tr>";
    echo "<th>ID</th><th>Name</th><th>Nickname</th><th>Email</th></tr>";
    while($row = mysqli_fetch_assoc($result)){
        echo "<tr>";
        echo "<td>".$row["user_id"]."</td><td>".$row["name"]."</td><td>".$row["username"]."</td><td>".$row["email"]."</td>";
        echo "<td><input type='button' value='DELETE' onclick = \"window.location.href='deleteUser.php?id=".$row["user_id"]."'\"></td></tr>";
    }
    echo "</table>";
}
else{
    echo "No data returned ..";
}

?>