<?php
    include "../controller/db.php";
    session_start();
    $nameError = "";
    $emailError = "";
    $passwordError = "";
    $phoneError = "";
    $addressError = "";
    $successMessage = "";
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
            $flag = true;

            if (empty($name))
            {
                $nameError = "Name cannot be empty.";
                $flag = false;
            }
            if (empty($email))
            {
                $emailError = "Email cannot be empty.";
                $flag = false;
            }
            elseif (!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                $emailError = "Invalid email.";
                $flag = false;
            }
            if (empty($password))
            {
                $passwordError = "Password cannot be empty.";
                $flag = false;
            }
            elseif (strlen($password) < 6)
            {
                $passwordError = "Password must be at least 6 characters.";
                $flag = false;
            }
            if (empty($phone))
            {
                $phoneError = "Phone number cannot be empty.";
                $flag = false;
            }
            elseif (!is_numeric($phone))
            {
                $phoneError = "Phone number must contain only numbers.";
                $flag = false;
            }
            if (empty($address))
            {
                $addressError = "Address cannot be empty.";
                $flag = false;
            }
            if ($flag)
            {
                $sql = "INSERT INTO users (name,email,password,phone,address,role)
                VALUES
                ('$name', '$email', '$password', '$phone', '$address', '$role')";
                $result = mysqli_query($conn, $sql);
                if (!$result)
                {
                    $successMessage = "Error! {$conn->error}";
                }
                else
                {
                    $successMessage = "Register Successful";
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
    <title>Sign Up</title>
    <link rel="stylesheet" href="sign_up_style.css">
</head>
<body>
    <div class="form-container sign-up">
        <form action="sign_up.php" method="post" id="signupForm">
            <button type="button" id="back_button" onclick="window.location.href='sign_in.php'"> Back </button>
            <h1>Create Account</h1>
            <br>
            <input type="text" name="name" id="name" placeholder="Name">
            <?php
                if ($nameError != "")
                {
                    echo "<div class='error'>$nameError</div><br>";
                }
            ?>
            <input type="email" name="email" id="email" placeholder="Email">
            <?php
                if ($emailError != "")
                {
                    echo "<div class='error'>$emailError</div><br>";
                }
            ?>
            <input type="password" name="password" id="password" placeholder="Password">
            <?php
                if ($passwordError != "")
                {
                    echo "<div class='error'>$passwordError</div><br>";
                }
            ?>
            <input type="text" name="phone" id="phone" placeholder="Phone Number">
            <?php
                if ($phoneError != "")
                {
                    echo "<div class='error'>$phoneError</div><br>";
                }
            ?>
            <input type="text" name="address" id="address" placeholder="Address Here">
            <?php
                if ($addressError != "")
                {
                    echo "<div class='error'>$addressError</div>";
                }
            ?>
            <button type="submit" name="submit" value="signup"> Sign Up </button>
            <?php
                if ($successMessage != "")
                {
                    echo "<p class='success'>$successMessage</p>";
                }
            ?>
        </form>
    </div>
    <script src="/js/sign_up_js.js"></script>
</body>
</html>