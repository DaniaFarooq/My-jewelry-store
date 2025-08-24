<?php
// role_selection.php
require_once 'db.php';
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Process role selection
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['role'] = $_POST['role'];
    
    // Redirect based on role
    switch ($_POST['role']) {
        case 'admin':
            header("Location: inventory.php");
            break;
        case 'manager':
            header("Location: pos.php");
            break;
        case 'salesperson':
            header("Location: pos.php");
            break;
        default:
            header("Location: login.php");
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Select Role</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Keep your existing styles -->
</head>
<body>
  <div class="role-container text-center">
    <h2 class="mb-4">Welcome, <?= htmlspecialchars($_SESSION['username'] ?? 'User') ?></h2>
    <p class="mb-4">Please confirm your role:</p>
    
    <form method="POST" class="text-start">
      <?php if ($_SESSION['db_role'] === 'admin'): ?>
      <div class="form-check mb-4">
        <input class="form-check-input" type="radio" name="role" id="admin" value="admin" required>
        <label class="form-check-label" for="admin">Admin (Full Access)</label>
      </div>
      <?php endif; ?>
      
      <?php if ($_SESSION['db_role'] === 'manager' || $_SESSION['db_role'] === 'admin'): ?>
      <div class="form-check mb-4">
        <input class="form-check-input" type="radio" name="role" id="manager" value="manager" required>
        <label class="form-check-label" for="manager">Manager (POS Access)</label>
      </div>
      <?php endif; ?>
      
      <div class="form-check mb-4">
        <input class="form-check-input" type="radio" name="role" id="salesperson" value="salesperson" required>
        <label class="form-check-label" for="salesperson">Salesperson (POS Only)</label>
      </div>
      
      <button type="submit" class="btn gradient-btn w-100">Continue</button>
    </form>
  </div>
</body>
</html>