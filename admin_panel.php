<?php
session_start();
if(isset($_SESSION['user_id']))
    {
        if($_SESSION['user_role'] == "admin")
            {
                
            }
        else
            {
                
            }
    }
else
    {
        header("Location: /index.php");
    }
?>

