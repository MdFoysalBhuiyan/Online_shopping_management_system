<?php
    include "../controller/db.php";
    session_start();

    if (isset($_POST['submit']))
        {

            if ($_POST['submit'] == 'signup')
                {
                    $name = $_POST['name'];
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $phone = $_POST['phone'];
                    $address = $_POST['address'];
                    $role = "customer";

                    $sql = "INSERT INTO users (name,email,password,phone,address,role)
                    VALUES 
                    ('$name', '$email', '$password', '$phone', '$address', '$role')";
                
                    $result = mysqli_query($conn,$sql);
                    
                    if(!$result)
                        {
                            echo "Erro! {$conn->error}";
                        }
                    else
                        {
                            echo "Register Successful";
                        }

                }
        }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel = "stylesheet" href = "sign_up_style.css">
</head>
<body>
    <div class="form-container sign-up">
        <form action = "sign_up.php" method = "post">
            <button type="button" id="back_button" onclick="window.location.href='sign_in.php'">Back</button>
            <h1>Create Account</h1>
            <br>
            <input type="text" name="name" placeholder="Name">
            <input type="email" name="email" placeholder="Email">
            <input type="password" name="password" placeholder="Password">
            <input type="text" name="phone" placeholder="Phone Number">
            <input type="text" name="address" placeholder="Address Here">
            <button type="submit" name="submit" value="signup">Sign Up</button>
        </form>
    </div>
</body>
</html>