<?php
require_once 'functions.php';

if (isset($_GET['remove'])) {
    unset($_SESSION['cart'][$_GET['remove']]);
    header("Location: cart.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Your Cart - Mermaid's Treasure</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
</head>
<body>
    
    <div class="container mt-5">
        <h1>Your Shopping Cart</h1>
        
        <?php if (empty($_SESSION['cart'])): ?>
            <p>Your cart is empty</p>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $total = 0;
                    $products = getProducts();
                    
                    foreach ($_SESSION['cart'] as $id => $qty): 
                        $product = $products[$id];
                        $subtotal = $product[2] * $qty;
                        $total += $subtotal;
                    ?>
                        <tr>
                            <td><?= $product[1] ?></td>
                            <td>$<?= $product[2] ?></td>
                            <td><?= $qty ?></td>
                            <td>$<?= $subtotal ?></td>
                            <td><a href="cart.php?remove=<?= $id ?>" class="btn btn-danger btn-sm">Remove</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3">Total</th>
                        <th>$<?= $total ?></th>
                        <th><a href="checkout.php" class="btn btn-primary">Checkout</a></th>
                    </tr>
                </tfoot>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>