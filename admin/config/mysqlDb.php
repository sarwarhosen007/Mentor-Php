<?php 

$conn = mysqli_connect("localhost", "root", "root", "mentor");
    if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
    }

?>