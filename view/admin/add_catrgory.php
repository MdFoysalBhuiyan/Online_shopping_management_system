
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Online Shop BD Inventory</title>
<link rel="stylesheet" href="../view/admin/admin_style.css">
</head>
<body>
<div class="shell">
  <header class="topbar">
    <div class="brand">
      <button class="brand-mark" id="brandMark" title="Shop menu" aria-label="Shop menu" onclick="window.location.href='../../index.php'">S</button>
      <span class="brand-name">Online Shop BD</span>
    </div>
    <div class="manager-pill">
      <span class="dot"></span> ADMIN
    </div>
  </header>
  <div class="layout">
<nav class="sidebar" id="sidebar">
    <button class="nav-item" onclick="window.location.href='/GitHub%20Clones/WebTech_Project/Online_shopping_management_system/controller/admin_controller.php'"><span class="bullet"></span>Dashborad</button>
    <button class="nav-item" onclick="window.location.href='#'"><span class="bullet"></span>Create Manager</button>
    <button class="nav-item" onclick="window.location.href='/GitHub%20Clones/WebTech_Project/Online_shopping_management_system/controller/admin_category_controller.php'"> <span class="bullet"></span>Add Category</button>
    <button class="nav-item" onclick="window.location.href='/GitHub%20Clones/WebTech_Project/Online_shopping_management_system/controller/admin_profile_controller.php'"><span class="bullet"></span>Profile</button>
    <button class="nav-item" onclick="window.location.href='../../controller/logout.php'"> <span class="bullet"></span>Log out </button>
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
      <form action="" method="POST">

    <input type="text" name="name" placeholder="Category Name" required>

    <input type="submit" name="submit" value="ADD">

</form>

<?php
if (!empty($message)) {
    echo "<p>$message</p>";
}
?>

  </div>
</div>
</body>
</html>
