<?php
// Enable error reporting (remove after testing)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session and check login
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Set default role if not defined (temporary)
$role = $_SESSION['role'] ?? 'guest'; 
$is_admin = ($role === 'admin');
$is_manager = ($role === 'manager');

// Verify required session variables
$username = $_SESSION['username'] ?? 'User';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { 
      background: linear-gradient(to right, #812dca, #dd2f4c);
      min-height: 100vh;
      color: white;
    }
    .card {
      background: white;
      color: #333;
      border-radius: 10px;
    }
    .dashboard-nav {
      background: linear-gradient(to right,#dd2e4b, #9f4ae9);
      padding: 10px 0;
    }
  </style>
</head>
<body>

  <div class="container">
    <!-- Header -->
    <header class="py-4 text-center">
      <h1>Welcome, <?= htmlspecialchars($username) ?></h1>
      <p class="text-white">Role: <?= ucfirst($role) ?></p>
    </header>
    
    <!-- Navigation -->
    <nav class="dashboard-nav mb-4">
      <div class="container">
        <div class="text-center">
          <?php if ($is_manager || $is_admin): ?>
            <a href="pos.php" class="text-white mx-3">POS System</a>
          <?php endif; ?>
          
          <?php if ($is_admin): ?>
            <a href="inventory.php" class="text-white mx-3">Inventory</a>
          <?php endif; ?>
          
          <a href="logout.php" class="text-white mx-3">Logout</a>
        </div>
      </div>
    </nav>

    <!-- Cards -->
    <div class="row justify-content-center">
      <?php if ($is_manager || $is_admin): ?>
      <div class="col-md-5 mb-4">
        <div class="card p-4 shadow">
          <h3>Point of Sale</h3>
          <p>Process customer orders</p>
          <a href="pos.php" class="btn btn-primary">Go to POS</a>
        </div>
      </div>
      <?php endif; ?>

      <?php if ($is_admin): ?>
      <div class="col-md-5 mb-4">
        <div class="card p-4 shadow">
          <h3>Inventory</h3>
          <p>Manage product stock</p>
          <a href="inventory.php" class="btn btn-primary">Go to Inventory</a>
        </div>
      </div>
      <?php endif; ?>
    </div>
  </div>

</body>
</html>