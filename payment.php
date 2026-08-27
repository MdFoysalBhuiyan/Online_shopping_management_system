<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include "controller/db.php";
$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'];
$quantity = $_POST['quantity'];
$payment_method = $_POST['payment_method'];
$sql = "SELECT * FROM products WHERE id = $product_id";
$result = mysqli_query($conn, $sql);
$product = mysqli_fetch_assoc($result);
$price = $product['price'] * $quantity;
$sql = "INSERT INTO single_order (user_id, product_id, total_amount) VALUES ('$user_id', '$product_id', '$price')";
mysqli_query($conn, $sql);
$order_id = mysqli_insert_id($conn);
$sql = "INSERT INTO payment (order_id, user_id, product_id, price, payment_method) VALUES  ('$order_id', '$user_id', '$product_id', '$price', '$payment_method')";
mysqli_query($conn, $sql);
$sql = "UPDATE products SET stock = stock - $quantity WHERE id = $product_id";
mysqli_query($conn, $sql);
echo "Order successful!";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
</head>
<body>
    <br>
    <button class="nav-item" onclick="window.location.href='index.php'"> <span class="bullet"></span>Home</button>
</body>
</html>