<?php
    $conn = new mysqli('localhost','root','','e_commerce_db');
    if(!$conn)
        {
            echo "Error! {$conn->connect_error}";
        }

?>