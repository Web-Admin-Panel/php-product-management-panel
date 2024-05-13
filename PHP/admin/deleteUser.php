<?php
   $cnn = mysqli_connect("0.0.0.0","root",null,"CMPR_Project", 4306);
   if (!$cnn)
   {
     echo "Error in Connection: ";
     exit();
   }
   
   
   $id = $_GET["id"];

    $sql = "DELETE FROM users WHERE user_id = $id";

    if(mysqli_query($cnn, $sql))
    {
        header("Location: manageUsers.php");
    }
    else{
        echo "<h1>An error Occurred while deleting!</h1>";
    }



?>