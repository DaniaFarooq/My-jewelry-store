<?php
require_once 'db.php';
session_start();

// Get order number from URL
$order_number = htmlspecialchars($_GET['order'] ?? '');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Confirmation</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .confirmation-card {
      max-width: 600px;
      margin: 2rem auto;
      padding: 2rem;
      background: white;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
    .confirmation-icon {
      font-size: 5rem;
      color: #28a745;
      margin-bottom: 1rem;
    }
  </style>
</head>
<body>
  <div class="container py-5 text-center">
    <div class="confirmation-card">
      <div class="confirmation-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
        </svg>
      </div>
      <h1 class="mb-3">Order Confirmed!</h1>
      <p class="lead mb-4">Thank you for your purchase</p>
      
      <div class="alert alert-success">
        <h4>Order Number: <?= $order_number ?></h4>
        <p>We've sent a confirmation to your email</p>
      </div>
      
      <a href="index.php" class="btn btn-primary mt-3">Continue Shopping</a>
    </div>
  </div>
</body>
</html>