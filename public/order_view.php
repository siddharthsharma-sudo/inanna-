<?php
// public/order_view.php
require_once __DIR__ . '/../public/includes/db.php';
session_start();

if (empty($_SESSION['user_id'])) {
    $_SESSION['after_login'] = $_SERVER['REQUEST_URI'];
    header('Location: login.php');
    exit;
}

$orderId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$uid = (int)$_SESSION['user_id'];
if ($orderId <= 0) { header('Location: account.php'); exit; }

// fetch order and ensure it belongs to user
$stmt = $pdo->prepare("SELECT * FROM orders WHERE id = :id AND user_id = :uid LIMIT 1");
$stmt->execute(['id'=>$orderId,'uid'=>$uid]);
$order = $stmt->fetch();
if (!$order) { header('Location: account.php'); exit; }

// fetch items with product & variant info
$itemsStmt = $pdo->prepare("
 SELECT oi.*, p.name AS product_name, p.image AS product_image,
        pv.size AS variant_size, pv.color AS variant_color, pv.variant_sku
 FROM order_items oi
 LEFT JOIN products p ON p.id = oi.product_id
 LEFT JOIN product_variants pv ON pv.id = oi.variant_id
 WHERE oi.order_id = :oid
");
$itemsStmt->execute(['oid'=>$orderId]);
$items = $itemsStmt->fetchAll();

include __DIR__ . '/includes/header.php';
?>
<div class="container my-4" style="max-width:900px;">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Order #<?php echo (int)$order['id']; ?></h3>
    <div class="small text-muted">Placed: <?php echo htmlspecialchars($order['created_at']); ?></div>
  </div>

  <div class="card p-3 mb-3">
    <div><strong>Status:</strong> <?php echo htmlspecialchars($order['status']); ?></div>
    <div><strong>Total:</strong> ₹<?php echo number_format($order['total'],2); ?></div>
    <div><strong>Customer:</strong> <?php echo htmlspecialchars($order['customer_name']); ?> — <?php echo htmlspecialchars($order['customer_email']); ?></div>
  </div>

  <div class="card p-3">
    <h5>Items</h5>
    <div class="table-responsive">
      <table class="table mb-0">
        <thead><tr><th>Product</th><th>Variant</th><th>Qty</th><th>Price</th><th>Subtotal</th></tr></thead>
        <tbody>
          <?php foreach ($items as $it): 
            $subtotal = $it['price'] * $it['qty'];
          ?>
            <tr>
              <td>
                <?php if (!empty($it['product_image']) && file_exists(__DIR__ . '/' . $it['product_image'])): ?>
                  <img src="<?php echo htmlspecialchars($it['product_image']); ?>" style="height:50px;object-fit:cover" alt="">
                <?php endif; ?>
                <?php echo htmlspecialchars($it['product_name']); ?>
              </td>
              <td>
                <?php if ($it['variant_sku'] || $it['variant_size'] || $it['variant_color']): ?>
                  <?php echo htmlspecialchars(trim(($it['variant_size']?:'') . ($it['variant_color']? ' / '.$it['variant_color'] : '') . ($it['variant_sku'] ? ' ('.$it['variant_sku'].')' : ''))); ?>
                <?php else: ?>
                  -
                <?php endif; ?>
              </td>
              <td><?php echo (int)$it['qty']; ?></td>
              <td>₹<?php echo number_format($it['price'],2); ?></td>
              <td>₹<?php echo number_format($subtotal,2); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="mt-3">
    <a href="account.php" class="btn btn-outline-secondary">Back to account</a>
  </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
