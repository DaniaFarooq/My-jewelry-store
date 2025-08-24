<?php
require_once 'db.php';
session_start();

// Basic manager check
if ($_SESSION['role'] !== 'manager') {
    header("Location: login.php");
    exit;
}

// Get products from inventory
$products = $conn->query("SELECT id, product_name, price, stock FROM inventory")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>POS System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .btn-purple { 
      background: #6f42c1; 
      color: white; 
    }
    .btn-purple:hover { background: #59339e; }
  </style>
</head>
<body class="bg-light">
  <div class="container py-4">
    <h1 class="mb-4">POS System</h1>
    
    <div class="card shadow p-3">
      <table class="table">
        <thead class="bg-purple text-white">
          <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($products as $product): ?>
          <tr>
            <td><?= $product['product_name'] ?></td>
            <td>$<?= $product['price'] ?></td>
            <td>
              <input type="number" 
                     class="form-control qty-input" 
                     value="0" 
                     min="0" 
                     max="<?= $product['stock'] ?>"
                     data-price="<?= $product['price'] ?>">
            </td>
            <td class="total">$0</td>
          </tr>
          <?php endforeach; ?>
        </tbody>
        <tfoot>
          <tr>
            <th colspan="3">Grand Total</th>
            <th id="grand-total">$0</th>
          </tr>
        </tfoot>
      </table>
      
      <button id="checkout-btn" class="btn btn-purple">Process Sale</button>
    </div>
  </div>

  <script>
    // Calculate totals
    document.querySelectorAll('.qty-input').forEach(input => {
      input.addEventListener('change', calculateTotal);
    });

    function calculateTotal() {
      let grandTotal = 0;
      
      document.querySelectorAll('tbody tr').forEach(row => {
        const qty = parseInt(row.querySelector('.qty-input').value) || 0;
        const price = parseFloat(row.querySelector('.qty-input').dataset.price);
        const total = qty * price;
        
        row.querySelector('.total').textContent = '$' + total.toFixed(2);
        grandTotal += total;
      });
      
      document.getElementById('grand-total').textContent = '$' + grandTotal.toFixed(2);
    }

    // Process sale (simplified)
    document.getElementById('checkout-btn').addEventListener('click', () => {
      alert('Sale processed! (In a real app, this would update inventory)');
    });
  </script>
</body>
</html>