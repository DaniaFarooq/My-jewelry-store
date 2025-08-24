<?php
require_once 'db.php';
session_start();

// Redirect if cart is empty
if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit;
}

// Get cart items from database
$cart_items = [];
$total = 0;

foreach ($_SESSION['cart'] as $product_id => $quantity) {
    $stmt = $conn->prepare("SELECT id, product_name, price FROM inventory WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();
    
    if ($product) {
        $subtotal = $product['price'] * $quantity;
        $total += $subtotal;
        $cart_items[] = [
            'name' => $product['product_name'],
            'price' => $product['price'],
            'quantity' => $quantity,
            'subtotal' => $subtotal
        ];
    }
}

// Process order
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Basic validation
    $required = ['name', 'email', 'phone', 'address', 'payment'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            die("Please fill all required fields");
        }
    }
    
    // Save order (simplified)
    $order_number = 'ORD-' . strtoupper(uniqid());
    
    // Clear cart
    unset($_SESSION['cart']);
    
    // Redirect to confirmation
    header("Location: order_confirmation.php?order=$order_number");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Keep your existing styles -->
</head>
<body>
  <div class="container py-4">
    <header class="d-flex justify-content-between align-items-center mb-4">
      <h1>Checkout</h1>
      <a href="cart.php" class="btn btn-purple">← Back to Cart</a>
    </header>

    <section class="checkout-container">
      <h2 class="mb-4">Order Summary</h2>
      <table class="table table-bordered text-center">
        <thead class="bg-purple">
          <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($cart_items as $item): ?>
          <tr>
            <td><?= htmlspecialchars($item['name']) ?></td>
            <td><?= $item['quantity'] ?></td>
            <td>$<?= number_format($item['price'], 2) ?></td>
            <td>$<?= number_format($item['subtotal'], 2) ?></td>
          </tr>
          <?php endforeach; ?>
          <tr>
            <td colspan="3"><strong>Grand Total:</strong></td>
            <td><strong>$<?= number_format($total, 2) ?></strong></td>
          </tr>
        </tbody>
      </table>

      <h2 class="mt-5">Billing & Shipping Details</h2>
      <form method="POST" class="mt-3">
        <div class="form-group mb-3">
          <label>Full Name</label>
          <input type="text" name="name" class="form-control" required>
        </div>

        <div class="form-group mb-3">
          <label>Email</label>
          <input type="email" name="email" class="form-control" required>
        </div>

        <div class="form-group mb-3">
          <label>Phone Number</label>
          <input type="tel" name="phone" class="form-control" required>
        </div>

        <div class="form-group mb-3">
          <label>Address</label>
          <textarea name="address" class="form-control" rows="3" required></textarea>
        </div>

        <h2 class="mt-5">Payment Method</h2>
        <div class="form-check mt-2">
          <input class="form-check-input" type="radio" name="payment" value="credit-card" required>
          <label class="form-check-label">Credit/Debit Card</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="payment" value="paypal" required>
          <label class="form-check-label">PayPal</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="payment" value="cash" required>
          <label class="form-check-label">Cash on Delivery</label>
        </div>

        <button type="submit" class="btn btn-gradient checkout-btn px-4 py-2">Place Order</button>
      </form>
    </section>
  </div>
</body>
</html>