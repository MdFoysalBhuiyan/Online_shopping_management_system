<?php
session_start();
include "controller/db.php";

if(isset($_SESSION['user_id'])) {
    $sql = "SELECT * FROM categories";
    $result1 = mysqli_query($conn, $sql);

    if($_SESSION['user_role'] == "manager") {
        if(isset($_POST['submit'])) {
            $name = $_POST['name'];
            $description = $_POST['about'];
            $price = $_POST['price'];
            $stock = $_POST['stock'];
            $image = $_FILES['image']['name'];
            $temp_location = $_FILES['image']['tmp_name'];
            $upload_location = "./media/";
            $category_name = $_POST['category-name']; 
            $sql = "INSERT INTO products (name, about, price, stock, image, cate_name)
                    VALUES ('$name', '$description', '$price', '$stock', '$image', '$category_name')";
            
            $result = mysqli_query($conn, $sql);
            if(!$result) {
                echo "Error : {$conn->error}</p>";
            } else {
                $message = "Product Added Successfully";
                if(!empty($image)){
                    move_uploaded_file($temp_location, $upload_location . $image);
                }
            }
        }
    } 
    else {
        echo "GO to home page";   
        }
}
 else {
    header("Location: /index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product Menu</title>
    <link rel="stylesheet" href="add_product_style.css">
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
      <button class="nav-item" onclick="window.location.href='display-product.php'"><span class="bullet"></span>View Product</button>
      <button class="nav-item" onclick="window.location.href='index.php'"><span class="bullet"></span>Payments</button>
      <button class="nav-item" onclick="window.location.href='logout.php'"><span class="bullet"></span>Log out</button>
    </nav>

    <main class="content">
      <div class="content-header">
        <div>
          <h1>Inventory</h1>
          <p class="sub" id="subLine"></p>
        </div>
        <button> </button>
      </div>

      <div class="stats"></div>
      <form action="add-product.php" method="POST" enctype="multipart/form-data">
        <table> 
            <thead> 
                <tr> 
                    <th>Product</th> 
                    <th>Stock</th> 
                    <th>Price</th> 
                    <th>About</th> 
                    <th>Image</th>
                    <th>Categories</th> 
                </tr> 
            </thead>
            <tbody>
                <tr>
                    <td><input type="text" name="name" required></td>
                    <td><input type="number" name="stock" required></td>
                    <td><input type="number" name="price" required></td>
                    <td><textarea name="about"></textarea></td>
                    <td><input type="file" name="image" required></td>
                    <td>
                        <select name="category-name" required>
                            <option value="" disabled selected>Select Category</option>
                            <?php while($row = mysqli_fetch_assoc($result1)) { ?>
                                <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <input type="submit" name="submit" id="add" value="ADD">
        <br>
        <?php if(!empty($message)) { ?>
            <p style="color: green;"><?php echo $message; ?></p>
        <?php } ?>
      </form>
    </main>
  </div>
</div>
</body>
</html>
