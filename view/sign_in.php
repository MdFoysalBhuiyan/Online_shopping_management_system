<?php
    include "../controller/db.php";
    session_start();

    if (isset($_POST['submit']))
        {
            if ($_POST['submit'] == 'signin') 
                {
                    $email = $_POST['email'];
                    $password = $_POST['password'];

                    $sql = "SELECT * FROM users WHERE email = '$email'";
                    $result = mysqli_query($conn,$sql);
                    if($result -> num_rows>0)
                        {
                            $row = mysqli_fetch_assoc($result);
                            if($row['password'] == $password)
                                {
                                    $_SESSION['user_id'] = $row['id'];
                                    $_SESSION['user_name'] = $row['name'];
                                    $_SESSION['user_role'] = $row['role'];

                                    if($_SESSION['user_role'] == "admin")
                                        {
                                            header("Location: ../admin_panel.php");
                                        }
                                    else
                                        {
                                            echo "dashbroad for users";
                                        }
                                    if($_SESSION['user_role'] == "manager")
                                        {
                                            header("Location: ../manager.php");
                                        }
                                    else
                                        {
                                            echo "dashbroad for users";
                                        }
                                    if($_SESSION['user_role'] == "customer")
                                        {
                                            header("Location: ../index.php");
                                        }
                                    else
                                        {
                                            echo "dashbroad for users";
                                        }
                                }
                                else
                                    {
                                        echo "Wrong Password";
                                    }
                        }
                } 
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel = "stylesheet" href = "sign_in_style.css">
</head>
<body>
    <div class="form-container sign-in">
        <form action = "sign_in.php" method = "post">
            <button type="button" id="back_button" onclick="window.location.href='../index.php'">Home</button>
            <h1>Sign In</h1>
            <br>
               <input type="email" name="email" placeholder="Email">
                <input type="password" name="password" placeholder="Password">
                <a href="#">Forget Your Password?</a>
                <button type="submit" name="submit" value="signin">Sign In</button>
                <p> Don't Have Account?</p>
                <button type="button" id="sign_up_button" onclick="window.location.href='sign_up.php'">Create Id</button>
        </form>
    </div>
</body>
</html>