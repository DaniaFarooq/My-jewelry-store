<?php
require_once 'db.php';
session_start();

// Verify login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$search_results = [];
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['query'])) {
    $search_term = "%" . $conn->real_escape_string($_GET['query']) . "%";
    $stmt = $conn->prepare("SELECT * FROM inventory WHERE product_name LIKE ?");
    $stmt->bind_param("s", $search_term);
    $stmt->execute();
    $search_results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Search Products</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .product-card {
      transition: transform 0.3s;
    }
    .product-card:hover {
      transform: translateY(-5px);
    }
  </style>
</head>
<body class="bg-light">
  <div class="container py-4">
    <div class="row mb-4">
      <div class="col-md-6 mx-auto">
        <form action="search.php" method="GET">
          <div class="input-group">
            <input type="text" name="query" class="form-control" 
                   placeholder="Search rings, necklaces..." 
                   value="<?= htmlspecialchars($_GET['query'] ?? '') ?>">
            <button class="btn btn-primary" type="submit">Search</button>
          </div>
        </form>
      </div>
    </div>

    <?php if (!empty($_GET['query'])): ?>
      <h3 class="mb-4">Results for "<?= htmlspecialchars($_GET['query']) ?>"</h3>
      <div class="row">
        <?php foreach ($search_results as $product): ?>
          <div class="col-md-4 mb-4">
            <div class="card product-card h-100">
              <div class="card-body">
                <h5><?= htmlspecialchars($product['product_name']) ?></h5>
                <p>Stock: <?= $product['stock'] ?></p>
                <p>$<?= number_format($product['price'], 2) ?></p>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
        
        <?php if (empty($search_results)): ?>
          <div class="col-12">
            <div class="alert alert-info">No products found</div>
          </div>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </div>
</body>
</html>