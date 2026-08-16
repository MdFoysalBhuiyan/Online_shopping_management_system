
<?php

    include "db.php";
    session_start();
    
    if (isset($_POST['action']))
        {
            if ($_POST['action'] == 'signup')
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

            if ($_POST['action'] == 'login') 
                {
                    $email = $_POST['email'];
                    $password = $_POST['password'];

                    $sql = "SELECT * FROM users WHERE email = '$email'";
                    $result = $mysqli_query($conn,$sql);
                    if($result -> num_rows>0)
                        {
                            $row = mysqli_fetch_assoc($result);
                            if($row['password'] == $password)
                                {
                                    $_SESSION['user_id'] = $row['id'];
                                    $_SESSION['user_name'] = $row['name'];
                                    $_SESSION['user_role'] = $row['role'];
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
    <link rel="stylesheet" href="login_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Log In page</title>
</head>
<body>
    <div class="container" id="container">
        <div class="form-container sign-up">
            <form action = "login-page.php" method = "post">
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
        <div class="form-container sign-in">
            <form action = "login-page.php" method = "post">
                <h1>Sign In</h1>
                <br>
                <input type="email" name="email" placeholder="Email">
                <input type="password" name="password" placeholder="Password">
                <a href="#">Forget Your Password?</a>
                <button type="submit" name="submit" value="signin">Sign In</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Enter your personal details to use all of site features</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Hello, Friend!</h1>
                    <p>Register with your personal details to use all of site features</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
    <script src ="login_js.js"></script>
</body>
</html>