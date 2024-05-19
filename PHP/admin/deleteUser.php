<?php
include ("../session.php");
include("../isAdmin.php");
global $con;
include("../dbConnection.php");
$id = $_GET["id"];

$sql = "DELETE FROM users WHERE user_id = $id";

if(mysqli_query($con, $sql))
{
    header("Location: manageUsers.php");
}
else{
    echo "<h1>An error Occurred while deleting!</h1>";
}
?>