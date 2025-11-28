<?php
// public/account.php
require_once __DIR__ . '/../public/includes/db.php';
session_start();

if (empty($_SESSION['user_id'])) {
    // preserve requested page and redirect to login
    $_SESSION['after_login'] = $_SERVER['REQUEST_URI'];
    header('Location: login.php');
    exit;
}

$userId = (int)$_SESSION['user_id'];
// fetch user info
$stmt = $pdo->prepare("SELECT id,name,email,phone,created_at FROM users WHERE id = :id LIMIT 1");
$stmt->execute(['id'=>$userId]);
$user = $stmt->fetch();

// fetch user's orders (placeholder)
$orders = $pdo->prepare("SELECT id,total,status,created_at FROM orders WHERE user_id = :uid ORDER BY created_at DESC");
$orders->execute(['uid'=>$userId]);
$orders = $orders->fetchAll();

include __DIR__ . '/includes/header.php';
?>
<div class="container my-4">
  <div class="d-flex justify-content-between align-items-center">
    <h2>My Account</h2>
    <div>
      <a href="logout.php" class="btn btn-outline-secondary">Logout</a>
    </div>
  </div>

  <div class="row g-4">
    <div class="col-md-4">
      <div class="card p-3">
        <h5>Profile</h5>
        <p><strong><?php echo htmlspecialchars($user['name']); ?></strong></p>
        <p class="mb-0"><?php echo htmlspecialchars($user['email']); ?></p>
        <p class="mb-0"><?php echo htmlspecialchars($user['phone']); ?></p>
        <div class="small text-muted">Member since: <?php echo htmlspecialchars($user['created_at']); ?></div>
      </div>
    </div>

    <div class="col-md-8">
      <div class="card p-3">
        <h5>Orders</h5>
        <?php if (empty($orders)): ?>
          <div class="p-3 text-muted">You have not placed any orders yet.</div>
        <?php else: ?>
          <div class="table-responsive">
            <table class="table table-sm mb-0">
              <thead><tr><th>Order</th><th>Total</th><th>Status</th><th>Date</th></tr></thead>
              <tbody>
                <?php foreach ($orders as $o): ?>
                  <tr>
                    <td><a href="order_view.php?id=<?php echo (int)$o['id']; ?>">#<?php echo (int)$o['id']; ?></a></td>
                    <td>₹<?php echo number_format($o['total'],2); ?></td>
                    <td><?php echo htmlspecialchars($o['status']); ?></td>
                    <td><?php echo htmlspecialchars($o['created_at']); ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
