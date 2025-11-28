<?php
// admin/dashboard.php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../public/includes/db.php';
require_admin(); // redirects to login if not authenticated

$admin = current_admin_info($pdo);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin Dashboard - Inanna</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Inanna Admin</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container my-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Welcome<?php echo $admin && !empty($admin['name']) ? (', ' . htmlspecialchars($admin['name'])) : ''; ?></h3>
    <div>
      <a href="products.php" class="btn btn-outline-primary">Manage Products</a>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="card p-3 mb-3">
        <h5>Quick stats</h5>
        <?php
        // Example counts
        $pcount = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
        $ucount = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
        $ocount = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
        ?>
        <div class="small text-muted">Products: <?php echo (int)$pcount; ?></div>
        <div class="small text-muted">Users: <?php echo (int)$ucount; ?></div>
        <div class="small text-muted">Orders: <?php echo (int)$ocount; ?></div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card p-3 mb-3">
        <h5>Recent products</h5>
        <ul class="list-group list-group-flush">
          <?php
          $stmt = $pdo->query("SELECT id,name,price FROM products ORDER BY created_at DESC LIMIT 5");
          $rows = $stmt->fetchAll();
          foreach ($rows as $r) {
              echo '<li class="list-group-item d-flex justify-content-between align-items-center">'
                   . htmlspecialchars($r['name'])
                   . '<span class="badge bg-secondary">₹' . number_format($r['price'],2) . '</span></li>';
          }
          ?>
        </ul>
      </div>
    </div>
  </div>
</div>

</body>
</html>
