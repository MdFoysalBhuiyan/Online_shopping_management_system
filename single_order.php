<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
include "controller/db.php";
$id = $_GET['id'];
$sql = "SELECT * FROM products WHERE id = $id";
$result = mysqli_query($conn, $sql);
$product = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Buy Product</title>
    <link rel="stylesheet" href="single_order_style.css">
</head>
<body>
    <button onclick="window.location.href='index.php'"> <span class="bullet"></span>Home</button>
    <h1>Buy Product</h1>
    <img src="media/<?php echo $product['image']; ?>" width="200">
    <h2><?php echo $product['name']; ?></h2>
    <p><?php echo $product['about']; ?></p>
    <h3>Price: <?php echo $product['price']; ?></h3>
    <p>Stock: <?php echo $product['stock']; ?></p>
    <form>
        <label>Quantity:</label>
        <input type="number" value="1" min="1">
        <br><br>
        <button type="submit">Payment</button>
    </form>
</body>
</html>