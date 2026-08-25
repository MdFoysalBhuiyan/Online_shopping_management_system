<?php
session_start();
include "controller/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: /index.php");
    exit();
}

if ($_SESSION['user_role'] != "manager") {
    echo "Go to home page";
    exit();
}

$message = "";

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $sql_delete = "DELETE FROM products WHERE id = '$id'";
    $delete_result = mysqli_query($conn, $sql_delete);

    if ($delete_result) {
        $message = "Product Deleted";
    } else {
        $message = "Error deleting product";
    }
}

if (isset($_GET['update'])) {
    $id = $_GET['update'];

    $sql_update = "UPDATE products SET stock = stock + 1 WHERE id = '$id'";
    $update_result = mysqli_query($conn, $sql_update);

    if ($update_result) {
        $message = "Stock Updated";
    } else {
        $message = "Error updating stock";
    }
}

$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Database Error: " . mysqli_error($conn));
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product Menu</title>
    <link rel="stylesheet" href="display-product-style.css">
</head>
<body>
<div class="shell">
  <header class="topbar">
    <div class="brand">
      <button class="brand-mark" id="brandMark" title="Shop menu" aria-label="Shop menu" onclick="window.location.href='index.php'">S</button>
      <span class="brand-name">Online Shop BD</span>
    </div>
    <div class="manager-pill">
      <span class="dot"></span> MANAGER
    </div>
  </header>

  <div class="layout">
    <nav class="sidebar" id="sidebar">
      <button class="nav-item" onclick="window.location.href='manager.php'"><span class="bullet"></span>Manager Panel</button>
      <button class="nav-item" onclick="window.location.href='index.php'"><span class="bullet"></span>Orders</button>
      <button class="nav-item" onclick="window.location.href='add-product.php'"> <span class="bullet"></span>Add product </button>
      <button class="nav-item" onclick="window.location.href='display-product.php'"> <span class="bullet"></span>View Product</button>
      <button class="nav-item" onclick="window.location.href='index.php'"><span class="bullet"></span>Payments</button>
      <button class="nav-item" onclick="window.location.href='logout.php'"><span class="bullet"></span>Log out</button>
    </nav>

    <main class="content">
      <div class="content-header">
        <div>
          <h1>View Product</h1>
          <p class="sub" id="subLine"></p>
        </div>
            <?php if (!empty($message)) { ?>
                <p style="color: red;"><?php echo $message; ?></p>
            <?php } ?>
        <button> </button>
      </div>

      <div class="stats"></div>
        <table> 
            <thead> 
                <tr> 
                    <th>Product</th> 
                    <th>About</th> 
                    <th>Price</th> 
                    <th>Stock</th> 
                    <th>Image</th>
                    <th>View Product</th> 
                    <th>Actions</th>
                </tr> 
            </thead>
            <tbody>
                <?php
                    while($row=mysqli_fetch_assoc($result)){
                ?>
                <tr>
                    <td><?php echo $row['name']?></td> 
                    <td><?php echo $row['about']?></td>
                    <td><?php echo $row['price']?></td>
                    <td><?php echo $row['stock']?></td>
                    <td> <img src="./media/<?php echo $row['image']; ?>" alt="" width="250"> </td>
                    <td><?php echo $row['cate_name']?></td>
                    <td><a href="display-product.php?update=<?php echo $row['id']; ?>" id="update">Update</a>
                    <a href="display-product.php?delete=<?php echo $row['id']; ?>" id="delete">Delete</a> </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <br>
    </main>
  </div>
</div>
</body>
</html>