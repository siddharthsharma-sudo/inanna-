<?php
// public/product.php - product detail via DB
require_once __DIR__ . '/../includes/db.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id LIMIT 1");
$stmt->execute(['id'=>$id]);
$product = $stmt->fetch();

include __DIR__ . '/includes/header.php';
?>

<div class="container">
  <?php if (!$product): ?>
    <div class="alert alert-warning">Product not found. <a href="products.php">Back to products</a></div>
  <?php else: ?>
    <div class="row g-4">
      <div class="col-md-6">
        <?php if (!empty($product['image']) && file_exists(__DIR__ . '/' . $product['image'])): ?>
          <img src="<?php echo htmlspecialchars($product['image']); ?>" class="img-fluid rounded" alt="<?php echo htmlspecialchars($product['name']); ?>">
        <?php else: ?>
          <div style="height:300px;background:#f5f5f5;display:flex;align-items:center;justify-content:center;color:#999;">No image</div>
        <?php endif; ?>
      </div>

      <div class="col-md-6">
        <h2><?php echo htmlspecialchars($product['name']); ?></h2>
        <p class="text-muted">SKU: <?php echo htmlspecialchars($product['sku']); ?></p>
        <h4 class="text-primary">₹<?php echo number_format($product['price'],2); ?></h4>
        <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
        <p><strong>Stock:</strong> <?php echo (int)$product['stock']; ?></p>

        <form action="place_order.php" method="post" class="row gx-2 gy-2 align-items-end">
          <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
          <div class="col-auto">
            <label class="form-label small">Quantity</label>
            <input type="number" name="qty" value="1" min="1" max="<?php echo max(1,(int)$product['stock']); ?>" class="form-control" style="width:100px;">
          </div>
          <div class="col-auto">
            <label class="form-label small">&nbsp;</label>
            <button type="submit" class="btn btn-success">Place Order</button>
          </div>
        </form>

        <div class="mt-3">
          <a href="products.php" class="btn btn-link">Back to products</a>
        </div>
      </div>
    </div>
  <?php endif; ?>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
