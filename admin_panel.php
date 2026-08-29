<?php
session_start();
if(isset($_SESSION['user_id']))
    {
        if($_SESSION['user_role'] == "admin")
            {
                
            }
        else
            {
                echo "GO to home page";   
            }
    }
else
    {
        header("Location: /index.php");
    }
    include "controller/db.php";
    $sql = "SELECT id, name, email, phone, address, role FROM users";
    $result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Online Shop BD Inventory</title>

<link rel="stylesheet" href="manager-style.css">
</head>
<body>
<div class="shell">
  <header class="topbar">
    <div class="brand">
      <button class="brand-mark" id="brandMark" title="Shop menu" aria-label="Shop menu" onclick="window.location.href='index.php'">S</button>
      <span class="brand-name">Online Shop BD</span>
    </div>
    <div class="manager-pill">
      <span class="dot"></span> ADMIN
    </div>
  </header>
  <div class="layout">
    <nav class="sidebar" id="sidebar">
      <button class="nav-item" onclick="window.location.href='admin_panel.php'"> <span class="bullet"></span>Admin Dashborad </button>
      <button class="nav-item" onclick="window.location.href='#'"> <span class="bullet"></span>Create Manager</button>
      <button class="nav-item" onclick="window.location.href='#'"> <span class="bullet"></span>Add Category </button>
      <!-- <button class="nav-item" onclick="window.location.href='display-product.php'"> <span class="bullet"></span>View Product</button>
      <button class="nav-item" onclick="window.location.href='payment_history.php'"> <span class="bullet"></span>Payments</button> -->
      <button class="nav-item" onclick="window.location.href='admin_profile.php'"><span class="bullet"></span>Profile</button>
      <button class="nav-item" onclick="window.location.href='logout.php'"><span class="bullet"></span>Log out</button>
    </nav>
    <main class="content">
      <div class="content-header">
        <div>
          <h1>Order Histroy</h1>
          <p class="sub" id="subLine">
          </p>
        </div>
      </div>
      <div class="stats">
      </div>
            <table border="1">
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Address</th>
              <th>Role</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
              <td><?php echo $row['id']; ?></td>
              <td><?php echo $row['name']; ?></td>
              <td><?php echo $row['email']; ?></td>
              <td><?php echo $row['phone']; ?></td>
              <td><?php echo $row['address']; ?></td>
              <td><?php echo $row['role']; ?></td>
            </tr>
            <?php } ?>
        </table>
    </main>
  </div>
</div>
</body>
</html>
