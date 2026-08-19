// Initial data
let products = [
  {
    id: 1,
    name: "Ceramic mug",
    category: "Kitchen",
    stock: 42,
    price: 350
  },
  {
    id: 2,
    name: "Desk lamp",
    category: "Lighting",
    stock: 6,
    price: 1240
  },
  {
    id: 3,
    name: "Wireless mouse",
    category: "Electronics",
    stock: 0,
    price: 890
  },
  {
    id: 4,
    name: "Canvas tote",
    category: "Bags",
    stock: 58,
    price: 560
  }
];

let nextId = 5;
let editingId = null;


// Elements
const tableBody = document.getElementById("tableBody");
const overlay = document.getElementById("overlay");
const modalTitle = document.getElementById("modalTitle");

const fName = document.getElementById("fName");
const fCategory = document.getElementById("fCategory");
const fStock = document.getElementById("fStock");
const fPrice = document.getElementById("fPrice");

const toast = document.getElementById("toast");


// Get product status
function statusFor(stock) {

  if (stock === 0) {
    return {
      label: "Out of stock",
      cls: "out-stock"
    };
  }

  if (stock <= 10) {
    return {
      label: "Low stock",
      cls: "low-stock"
    };
  }

  return {
    label: "In stock",
    cls: "in-stock"
  };
}


// Format price
function formatPrice(price) {
  return price.toLocaleString("en-US");
}


// Render products
function render() {

  tableBody.innerHTML = "";

  if (products.length === 0) {

    tableBody.innerHTML = `
      <tr class="empty-row">
        <td colspan="6">
          No products yet. Click "+ Add product" to create one.
        </td>
      </tr>
    `;

  } else {

    products.forEach(product => {

      const status = statusFor(product.stock);

      const tr = document.createElement("tr");

      tr.innerHTML = `
        <td
          class="product-name link"
          data-id="${product.id}"
          data-role="name"
        >
          ${escapeHtml(product.name)}
        </td>

        <td
          class="category-cell link"
          data-id="${product.id}"
          data-role="category"
        >
          ${escapeHtml(product.category)}
        </td>

        <td>${product.stock}</td>

        <td class="price-cell">
          ৳ ${formatPrice(product.price)}
        </td>

        <td>
          <span class="status-pill ${status.cls}">
            ${status.label}
          </span>
        </td>

        <td>
          <div class="actions-cell">

            <button
              class="icon-btn edit"
              title="Edit ${escapeHtml(product.name)}"
              data-id="${product.id}"
            >
              ✎
            </button>

            <button
              class="icon-btn delete"
              title="Delete ${escapeHtml(product.name)}"
              data-id="${product.id}"
            >
              🗑
            </button>

          </div>
        </td>
      `;

      tableBody.appendChild(tr);
    });
  }

  updateStats();
  attachRowEvents();
}


// Prevent HTML injection
function escapeHtml(str) {

  const div = document.createElement("div");

  div.textContent = str;

  return div.innerHTML;
}


// Update statistics
function updateStats() {

  const inStock = products.filter(
    product => product.stock > 10
  ).length;

  const low = products.filter(
    product => product.stock > 0 && product.stock <= 10
  ).length;

  const out = products.filter(
    product => product.stock === 0
  ).length;

  const categories = new Set(
    products.map(product =>
      product.category.trim().toLowerCase()
    )
  ).size;


  document.getElementById("statInStock").textContent = inStock;

  document.getElementById("statLowStock").textContent = low;

  document.getElementById("statOutStock").textContent = out;


  document.getElementById("subLine").textContent =
    `${products.length} product${
      products.length === 1 ? "" : "s"
    } across ${categories} categor${
      categories === 1 ? "y" : "ies"
    }`;
}


// Attach events to table rows
function attachRowEvents() {

  document.querySelectorAll(".icon-btn.edit")
    .forEach(button => {

      button.addEventListener("click", () => {

        openEdit(
          Number(button.dataset.id)
        );

      });

    });


  document.querySelectorAll(".icon-btn.delete")
    .forEach(button => {

      button.addEventListener("click", () => {

        deleteProduct(
          Number(button.dataset.id)
        );

      });

    });


  document
    .querySelectorAll(
      '[data-role="name"], [data-role="category"]'
    )
    .forEach(element => {

      element.addEventListener("click", () => {

        openEdit(
          Number(element.dataset.id)
        );

      });

    });
}


// Open Add Product modal
function openAdd() {

  editingId = null;

  modalTitle.textContent = "Add product";

  fName.value = "";
  fCategory.value = "";
  fStock.value = "";
  fPrice.value = "";

  overlay.classList.add("open");

  fName.focus();
}


// Open Edit Product modal
function openEdit(id) {

  const product = products.find(
    product => product.id === id
  );

  if (!product) return;

  editingId = id;

  modalTitle.textContent = "Edit product";

  fName.value = product.name;
  fCategory.value = product.category;
  fStock.value = product.stock;
  fPrice.value = product.price;

  overlay.classList.add("open");

  fName.focus();
}


// Close modal
function closeModal() {

  overlay.classList.remove("open");
}


// Save product
function saveProduct() {

  const name = fName.value.trim();

  const category = fCategory.value.trim();

  const stock = Math.max(
    0,
    parseInt(fStock.value, 10) || 0
  );

  const price = Math.max(
    0,
    parseFloat(fPrice.value) || 0
  );


  if (!name || !category) {

    showToast(
      "Please fill in product name and category"
    );

    return;
  }


  // Add new product
  if (editingId === null) {

    products.push({
      id: nextId++,
      name: name,
      category: category,
      stock: stock,
      price: price
    });

    showToast(
      `${name} added to inventory`
    );

  }

  // Update existing product
  else {

    const product = products.find(
      product => product.id === editingId
    );

    if (product) {

      product.name = name;
      product.category = category;
      product.stock = stock;
      product.price = price;

      showToast(
        `${name} updated`
      );
    }
  }


  closeModal();

  render();
}


// Delete product
function deleteProduct(id) {

  const product = products.find(
    product => product.id === id
  );

  if (!product) return;


  if (
    confirm(
      `Remove "${product.name}" from inventory?`
    )
  ) {

    products = products.filter(
      product => product.id !== id
    );

    render();

    showToast(
      `${product.name} removed`
    );
  }
}


// Toast message
let toastTimer = null;

function showToast(message) {

  toast.textContent = message;

  toast.classList.add("show");

  clearTimeout(toastTimer);

  toastTimer = setTimeout(() => {

    toast.classList.remove("show");

  }, 2200);
}


// Sidebar navigation
document
  .querySelectorAll(".nav-item")
  .forEach(button => {

    button.addEventListener("click", () => {

      document
        .querySelectorAll(".nav-item")
        .forEach(item => {

          item.classList.remove("active");

        });


      button.classList.add("active");


      const page = button.dataset.page;


      if (page === "Log out") {

        showToast(
          "Logged out (demo only)"
        );

      }

      else if (page !== "Inventory") {

        showToast(
          `${page} page — demo placeholder`
        );

      }

    });

  });


// Brand button
document
  .getElementById("brandMark")
  .addEventListener("click", () => {

    showToast(
      "Online Shop BD — shop menu (demo)"
    );

  });


// Modal buttons
document
  .getElementById("addProductBtn")
  .addEventListener("click", openAdd);


document
  .getElementById("cancelBtn")
  .addEventListener("click", closeModal);


document
  .getElementById("saveBtn")
  .addEventListener("click", saveProduct);


// Close modal by clicking outside
overlay.addEventListener("click", event => {

  if (event.target === overlay) {

    closeModal();

  }

});


// Close modal with Escape
document.addEventListener("keydown", event => {

  if (event.key === "Escape") {

    closeModal();

  }

});


// Initial render
render();