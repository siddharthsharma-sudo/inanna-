<?php
// admin/product_edit.php (with variants)
require_once __DIR__ . '/../public/includes/db.php';
require_once __DIR__ . '/auth.php';
require_admin();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$product = null;
$variants = [];

if ($id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id LIMIT 1");
    $stmt->execute(['id'=>$id]);
    $product = $stmt->fetch();

    // load variants
    $vstmt = $pdo->prepare("SELECT * FROM product_variants WHERE product_id = :pid ORDER BY id ASC");
    $vstmt->execute(['pid'=>$id]);
    $variants = $vstmt->fetchAll();
}

if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['crud_csrf'])) $_SESSION['crud_csrf'] = bin2hex(random_bytes(16));
$csrf = $_SESSION['crud_csrf'];
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><?php echo $product ? 'Edit' : 'Add'; ?> Product</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .variant-row { border:1px dashed #ddd; padding:10px; margin-bottom:8px; border-radius:6px; }
  </style>
</head>
<body class="bg-light">
<div class="container py-4" style="max-width:1000px">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3><?php echo $product ? 'Edit' : 'Add'; ?> Product</h3>
    <div>
      <a href="products.php" class="btn btn-outline-secondary">Back to list</a>
    </div>
  </div>

  <div class="card p-3 shadow-sm">
    <form action="product_save.php" method="post" enctype="multipart/form-data" id="product-form">
      <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($csrf); ?>">
      <input type="hidden" name="id" value="<?php echo $product ? (int)$product['id'] : 0; ?>">

      <div class="row">
        <div class="col-md-8">
          <div class="mb-3">
            <label class="form-label">Product Name</label>
            <input name="name" class="form-control" required value="<?php echo $product ? htmlspecialchars($product['name']) : ''; ?>">
          </div>

          <div class="mb-3">
            <label class="form-label">SKU</label>
            <input name="sku" class="form-control" value="<?php echo $product ? htmlspecialchars($product['sku']) : ''; ?>">
            <div class="form-text">Base SKU. Variant SKU optional per variant.</div>
          </div>

          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" rows="6" class="form-control"><?php echo $product ? htmlspecialchars($product['description']) : ''; ?></textarea>
          </div>
        </div>

        <div class="col-md-4">
          <div class="mb-3">
            <label class="form-label">Base Price (INR)</label>
            <input name="price" type="number" step="0.01" class="form-control" required value="<?php echo $product ? htmlspecialchars($product['price']) : '0.00'; ?>">
            <div class="form-text">Variant price (if set) will override this.</div>
          </div>

          <div class="mb-3">
            <label class="form-label">Stock (base)</label>
            <input name="stock" type="number" class="form-control" required value="<?php echo $product ? (int)$product['stock'] : 0; ?>">
            <div class="form-text">Use product-level stock if you don't use variants.</div>
          </div>

          <div class="mb-3">
            <label class="form-label">Main Image (optional)</label>
            <input type="file" name="image" accept="image/*" class="form-control">
            <?php if ($product && !empty($product['image']) && file_exists(__DIR__ . '/../public/' . $product['image'])): ?>
              <div class="mt-2">
                <img src="<?php echo '../' . htmlspecialchars($product['image']); ?>" style="height:80px; object-fit:cover;" alt="">
                <div class="form-text">Uploading a new image replaces the old one.</div>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <hr>
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h5 class="mb-0">Variants (size & color)</h5>
        <button type="button" class="btn btn-sm btn-success" id="add-variant">Add Variant</button>
      </div>

      <div id="variants-container">
        <?php if (!empty($variants)): ?>
          <?php foreach ($variants as $i => $v): ?>
            <div class="variant-row" data-variant-id="<?php echo (int)$v['id']; ?>">
              <input type="hidden" name="variants[<?php echo $i; ?>][id]" value="<?php echo (int)$v['id']; ?>">
              <div class="row g-2">
                <div class="col-md-3">
                  <label class="form-label small">Variant SKU</label>
                  <input name="variants[<?php echo $i; ?>][sku]" class="form-control" value="<?php echo htmlspecialchars($v['variant_sku']); ?>">
                </div>
                <div class="col-md-3">
                  <label class="form-label small">Size</label>
                  <input name="variants[<?php echo $i; ?>][size]" class="form-control" value="<?php echo htmlspecialchars($v['size']); ?>">
                </div>
                <div class="col-md-3">
                  <label class="form-label small">Color</label>
                  <input name="variants[<?php echo $i; ?>][color]" class="form-control" value="<?php echo htmlspecialchars($v['color']); ?>">
                </div>
                <div class="col-md-2">
                  <label class="form-label small">Price (override)</label>
                  <input name="variants[<?php echo $i; ?>][price]" type="number" step="0.01" class="form-control" value="<?php echo $v['price'] !== null ? htmlspecialchars($v['price']) : ''; ?>">
                </div>
                <div class="col-md-1">
                  <label class="form-label small">Stock</label>
                  <input name="variants[<?php echo $i; ?>][stock]" type="number" class="form-control" value="<?php echo (int)$v['stock']; ?>">
                </div>
              </div>
              <div class="mt-2">
                <label class="form-label small">Variant image (optional)</label>
                <input type="file" name="variants_files[<?php echo $i; ?>]" accept="image/*" class="form-control">
                <?php if (!empty($v['image']) && file_exists(__DIR__ . '/../public/' . $v['image'])): ?>
                  <div class="mt-2"><img src="<?php echo '../' . htmlspecialchars($v['image']); ?>" style="height:60px;object-fit:cover" alt=""></div>
                <?php endif; ?>
              </div>
              <div class="mt-2 text-end">
                <button type="button" class="btn btn-sm btn-danger remove-variant">Remove</button>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>

      <!-- template (hidden) -->
      <template id="variant-template">
        <div class="variant-row" data-variant-id="">
          <input type="hidden" name="__INDEX__" value="">
          <div class="row g-2">
            <div class="col-md-3">
              <label class="form-label small">Variant SKU</label>
              <input name="variants[__INDEX__][sku]" class="form-control" value="">
            </div>
            <div class="col-md-3">
              <label class="form-label small">Size</label>
              <input name="variants[__INDEX__][size]" class="form-control" value="">
            </div>
            <div class="col-md-3">
              <label class="form-label small">Color</label>
              <input name="variants[__INDEX__][color]" class="form-control" value="">
            </div>
            <div class="col-md-2">
              <label class="form-label small">Price (override)</label>
              <input name="variants[__INDEX__][price]" type="number" step="0.01" class="form-control" value="">
            </div>
            <div class="col-md-1">
              <label class="form-label small">Stock</label>
              <input name="variants[__INDEX__][stock]" type="number" class="form-control" value="0">
            </div>
          </div>
          <div class="mt-2">
            <label class="form-label small">Variant image (optional)</label>
            <input type="file" name="variants_files[__INDEX__]" accept="image/*" class="form-control">
          </div>
          <div class="mt-2 text-end">
            <button type="button" class="btn btn-sm btn-danger remove-variant">Remove</button>
          </div>
        </div>
      </template>

      <div class="mt-4 d-flex gap-2">
        <button class="btn btn-primary" type="submit">Save Product</button>
        <a class="btn btn-secondary" href="products.php">Cancel</a>
      </div>
    </form>
  </div>
</div>

<script>
(function(){
  const container = document.getElementById('variants-container');
  const tpl = document.getElementById('variant-template').innerHTML;
  // compute next index based on existing rows
  function nextIndex(){
    const rows = container.querySelectorAll('.variant-row');
    let max = -1;
    rows.forEach(r=>{
      const input = r.querySelector('input[name^="variants"]');
      if (!input) return;
      // extract index from name like variants[3][sku]
      const m = input.name.match(/^variants\[(\d+)\]/);
      if (m) max = Math.max(max, parseInt(m[1],10));
    });
    return max + 1;
  }

  document.getElementById('add-variant').addEventListener('click', function(){
    const idx = nextIndex();
    let html = tpl.replace(/__INDEX__/g, idx);
    const wrapper = document.createElement('div');
    wrapper.innerHTML = html;
    // append variant row
    container.appendChild(wrapper.firstElementChild);
  });

  // delegate remove
  container.addEventListener('click', function(e){
    if (e.target.matches('.remove-variant')) {
      const row = e.target.closest('.variant-row');
      if (row) row.remove();
    }
  });
})();
</script>
</body>
</html>
