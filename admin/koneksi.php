<?php 
    $conn = mysqli_connect("localhost", "root", "", "db_sig_petshop");
    if (mysqli_connect_error()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
