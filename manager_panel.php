<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Online Shop BD Inventory</title>

<link rel="stylesheet" href="manager_style.css">
</head>

<body>

<div class="shell">
  <header class="topbar">
    <div class="brand">
      <button class="brand-mark" id="brandMark" title="Shop menu" aria-label="Shop menu">S</button>
      <span class="brand-name">Online Shop BD</span>
    </div>

    <div class="manager-pill">
      <span class="dot"></span> MANAGER
    </div>
  </header>

  <div class="layout">

    <nav class="sidebar" id="sidebar">
      <button class="nav-item active" data-page="Inventory">
        <span class="bullet"></span>Inventory
      </button>

      <button class="nav-item" data-page="Orders">
        <span class="bullet"></span>Orders
      </button>

      <button class="nav-item" data-page="Categories">
        <span class="bullet"></span>Categories
      </button>

      <button class="nav-item" data-page="Payments">
        <span class="bullet"></span>Payments
      </button>

      <button class="nav-item" data-page="Log out">
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

        <button class="add-btn" id="addProductBtn">
          + Add product
        </button>
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
          <!-- Rows will be added by JavaScript -->
        </tbody>
      </table>

    </main>
  </div>
</div>


<div class="overlay" id="overlay">

  <div class="modal">

    <h2 id="modalTitle">Add product</h2>

    <div class="field">
      <label for="fName">Product name</label>
      <input
        type="text"
        id="fName"
        placeholder="e.g. Bamboo cutting board"
      >
    </div>

    <div class="field">
      <label for="fCategory">Category</label>
      <input
        type="text"
        id="fCategory"
        placeholder="e.g. Kitchen"
      >
    </div>

    <div class="field">
      <label for="fStock">Stock</label>
      <input
        type="number"
        id="fStock"
        min="0"
        placeholder="0"
      >
    </div>

    <div class="field">
      <label for="fPrice">Price (৳)</label>
      <input
        type="number"
        id="fPrice"
        min="0"
        placeholder="0"
      >
    </div>

    <div class="modal-actions">

      <button class="btn-secondary" id="cancelBtn">
        Cancel
      </button>

      <button class="btn-primary" id="saveBtn">
        Save product
      </button>

    </div>

  </div>

</div>


<div class="toast" id="toast"></div>


<script src="manager_script.js"></script>

</body>
</html>