<?php
session_start();
if(isset($_SESSION['user_id']))
    {
        if($_SESSION['user_role'] == "manager")
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
      <button class="nav-item" onclick="window.location.href='index.php'">
      <span class="bullet"></span>Inventory
      </button>

      <button class="nav-item" onclick="window.location.href='index.php'">
      <span class="bullet"></span>Orders
      </button>

      <button class="nav-item" onclick="window.location.href='index.php'">
      <span class="bullet"></span>Categories
      </button>

      <button class="nav-item" onclick="window.location.href='index.php'">
      <span class="bullet"></span>Payments
      </button>

      <button class="nav-item" onclick="window.location.href='logout.php'">
      <span class="bullet"></span>Log out
      </button>
    </nav>

    <main class="content">

      <div class="content-header">
        <div>
          <h1>Inventory</h1>
          <p class="sub" id="subLine">
          </p>
        </div>

        <button class="add-btn" id="addProductBtn" onclick="window.location.href='add-product.php'"> + Add product</button>
      </div>

      <div class="stats">

        <div class="stat-card">
          <div class="stat-label">In stock</div>
          <div class="stat-value" id="statInStock">128</div>
        </div>

        <div class="stat-card">
          <div class="stat-label">Low stock</div>
          <div class="stat-value" id="statLowStock">14</div>
        </div>

        <div class="stat-card">
          <div class="stat-label">Out of stock</div>
          <div class="stat-value" id="statOutStock">6</div>
        </div>

        <div class="stat-card">
          <div class="stat-label">Orders today</div>
          <div class="stat-value">37</div>
        </div>

      </div>

      <table>
        <thead>
          <tr>
            <th>Product</th>
            <th>Category</th>
            <th>Stock</th>
            <th>Price</th>
            <th>Status</th>
            <th></th>
          </tr>
        </thead>

        <tbody id="tableBody">
        </tbody>
      </table>

    </main>
  </div>
</div>

<script src="manager_script.js"></script>

</body>
</html>