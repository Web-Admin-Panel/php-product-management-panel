<?php
$cnn = mysqli_connect("0.0.0.0","root",null,"CMPR_Project", 4306);
if (!$cnn) {
    echo "Error in Connection: ";
    exit();
}

$id = $_GET["id"];

// Fetch the preview_image_name before deleting the row
$sql = "SELECT preview_image_name FROM products WHERE product_id = $id";
$result = mysqli_query($cnn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $imageName = $row['preview_image_name'];
    $imagePath = "../data/preview_images/" . $imageName;

    // Delete the row from the database
    $sql = "DELETE FROM products WHERE product_id = $id";
    if (mysqli_query($cnn, $sql)) {
        // Check if the file exists and delete it
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        header("Location: homePage.php");
    } else {
        echo "<h1>An error occurred while deleting!</h1>";
    }
} else {
    echo "<h1>Product not found!</h1>";
}

mysqli_close($cnn);
?>
