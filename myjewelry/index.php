<?php 
require_once 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Mermaid's Treasure</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
  <script src="theme-toggle.js" defer></script>
   <link rel="stylesheet" href="css/styles.css"> 
</head>

<body id="main-body" class="bg-light text-dark">
  <div class="header-image"></div>
  <nav class="navbar navbar-expand-lg px-4 py-3 bg-light text-dark" id="main-navbar">

    <div class="container-fluid d-flex align-items-center justify-content-between">

      <div class="d-flex flex-grow-1 justify-content-center align-items-center gap-3 flex-wrap">

        <a class="navbar-brand d-flex align-items-center mb-0">
          <img src="images/The-Mermaid-Logo.jpg" alt="Logo" width="50" class="me-2" />
        </a>
 <form class="d-flex" action="search.php" method="GET">
  <input class="form-control me-2" name="query" type="search" placeholder="Search...">
  <button class="btn btn-outline-light" type="submit">Search</button>
</form>       
        <div class="nav-item dropdown">
          <a class="nav-link dropdown-toggle ">Categories</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="index.php">Rings</a></li>
            <li><a class="dropdown-item" href="index.php">Bracelets</a></li>
            <li><a class="dropdown-item" href="index.php">Earrings</a></li>
            <li><a class="dropdown-item" href="index.php">Necklaces</a></li>
            <li><a class="dropdown-item" href="index.php">Bangles</a></li>
          </ul>
        </div>
      
        <a class="nav-link" href="login.php">Login</a>
        <a class="nav-link" href="signup.php">Sign Up</a>
        <a class="nav-link" href="checkout.php">View Cart</a>
      </div>
  </nav>

  <section class="products">
<header>
  <h1>Our Collection</h1>
</header>
<div class="product-grid" id="product-grid">
  <?php
  $products = [
    ["ring.webp", "Elegant Ring", 50],
    ["bracelet.webp", "Bow Bracelet", 30],
    ["butterfly.webp", "Wings Earrings", 40],
    ["necklace.avif", "Stone Necklace", 90],
    ["bangles.webp", "Engraved Bangles", 50],
    ["brooches.webp", "Brooches", 30]
  ];
  
  foreach ($products as $index => $product) {
        echo '
        <div class="product">
          <img src="images/'.htmlspecialchars($product[0]).'" alt="'.htmlspecialchars($product[1]).'" />
          <h5>'.htmlspecialchars($product[1]).'</h5>
          <p>$'.htmlspecialchars($product[2]).'</p>
          <a href="add_to_cart.php?id='.$index.'" class="btn btn-primary">Add to Cart</a>
        </div>'
  }
  ?>
</div>
  </section>
</body>
</html>