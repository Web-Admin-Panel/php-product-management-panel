<?php
$con = mysqli_connect("0.0.0.0", "root", null, "CMPR_Project", 4306);
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
