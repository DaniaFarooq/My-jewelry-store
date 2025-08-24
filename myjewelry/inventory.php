<?php
require_once 'db.php';
session_start();

// Basic admin check (keep it simple)
if ($_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Handle stock updates
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $stock = intval($_POST['stock']);
    $conn->query("UPDATE inventory SET stock = $stock WHERE id = $id");
    echo "Updated!";
    exit;
}

// Get all products
$result = $conn->query("SELECT * FROM inventory");
$inventory = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inventory</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .btn-purple { 
      background: #6f42c1; 
      color: white; 
    }
  </style>
</head>
<body class="bg-light">
  <div class="container py-4">
    <h1 class="mb-4">Inventory</h1>
    
    <table class="table table-bordered">
      <thead class="bg-purple text-white">
        <tr>
          <th>Product</th>
          <th>Stock</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($inventory as $item): ?>
        <tr>
          <td><?= $item['product_name'] ?></td>
          <td id="stock-<?= $item['id'] ?>"><?= $item['stock'] ?></td>
          <td>
            <input type="number" id="input-<?= $item['id'] ?>" value="<?= $item['stock'] ?>" class="form-control mb-2">
            <button onclick="updateStock(<?= $item['id'] ?>)" class="btn btn-purple btn-sm">
              Update
            </button>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <script>
    function updateStock(id) {
      const stock = document.getElementById(`input-${id}`).value;
      
      fetch('inventory.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${id}&stock=${stock}`
      })
      .then(response => response.text())
      .then(() => {
        document.getElementById(`stock-${id}`).textContent = stock;
      });
    }
  </script>
</body>
</html>