<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include "controller/db.php";
$id = $_SESSION['user_id'];
$sql = "SELECT id, name, email, phone, address, role FROM users WHERE id = $id";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
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
      <span class="dot"></span> MANAGER
    </div>
  </header>
  <div class="layout">
    <nav class="sidebar" id="sidebar">
      <button class="nav-item" onclick="window.location.href='admin_panel.php'"> <span class="bullet"></span>Admin Dashbrod </button>
      <!-- <button class="nav-item" onclick="window.location.href='order_history.php'"> <span class="bullet"></span>Orders </button>
      <button class="nav-item" onclick="window.location.href='add-product.php'"> <span class="bullet"></span>Add product </button>
      <button class="nav-item" onclick="window.location.href='display-product.php'"> <span class="bullet"></span>View Product</button>
      <button class="nav-item" onclick="window.location.href='payment_history.php'"> <span class="bullet"></span>Payments</button> -->
      <button class="nav-item" onclick="window.location.href='manager_profile.php'"><span class="bullet"></span>Profile</button>
      <button class="nav-item" onclick="window.location.href='logout.php'"><span class="bullet"></span>Log out</button>
    </nav>
    <main class="content">
      <div class="content-header">
        <div>
          <h1>Profile</h1>
          <p class="sub" id="subLine">
          </p>
            <p id="user-id">ID: <?php echo $user['id']; ?></p>
            <p id="user-name">Name: <?php echo $user['name']; ?></p>
            <p id="user-email">Email: <?php echo $user['email']; ?></p>
            <p id="user-phone">Phone: <?php echo $user['phone']; ?></p>
            <p id="user-address">Address: <?php echo $user['address']; ?></p>
            <p id="user-role">Role: <?php echo $user['role']; ?></p>
        </div>
      </div>
    </main>
  </div>
</div>
</body>
</html>
