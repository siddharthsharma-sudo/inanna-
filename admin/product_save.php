<?php
// admin/product_save.php (with variants)
require_once __DIR__ . '/../public/includes/db.php';
require_once __DIR__ . '/auth.php';
require_admin();

if (session_status() === PHP_SESSION_NONE) session_start();
$csrf = $_POST['csrf'] ?? '';
if (empty($csrf) || empty($_SESSION['crud_csrf']) || !hash_equals($_SESSION['crud_csrf'], $csrf)) {
    die('Invalid CSRF token');
}

$action = $_POST['action'] ?? 'save';

if ($action === 'delete') {
    $id = (int)($_POST['id'] ?? 0);
    if ($id <= 0) {
        header('Location: products.php?err=invalid');
        exit;
    }
    // delete variant images
    $vstmt = $pdo->prepare("SELECT image FROM product_variants WHERE product_id = :pid");
    $vstmt->execute(['pid'=>$id]);
    while ($vr = $vstmt->fetch()) {
        if (!empty($vr['image'])) {
            $imgPath = __DIR__ . '/../public/' . $vr['image'];
            if (file_exists($imgPath)) @unlink($imgPath);
        }
    }
    // delete product main image
    $stmt = $pdo->prepare("SELECT image FROM products WHERE id = :id LIMIT 1");
    $stmt->execute(['id'=>$id]);
    $row = $stmt->fetch();
    if ($row && !empty($row['image'])) {
        $imgPath = __DIR__ . '/../public/' . $row['image'];
        if (file_exists($imgPath)) @unlink($imgPath);
    }

    // DELETE will cascade to product_variants because FK ON DELETE CASCADE if you created table that way
    $del = $pdo->prepare("DELETE FROM products WHERE id = :id");
    $del->execute(['id'=>$id]);
    header('Location: products.php?msg=deleted');
    exit;
}

// Save path
$id = (int)($_POST['id'] ?? 0);
$name = trim($_POST['name'] ?? '');
$sku = trim($_POST['sku'] ?? '');
$price = (float)($_POST['price'] ?? 0);
$stock = (int)($_POST['stock'] ?? 0);
$description = $_POST['description'] ?? '';

if ($name === '') {
    header('Location: product_edit.php?id=' . $id . '&err=missing_name');
    exit;
}

// handle main image upload
$imagePath = null;
if (!empty($_FILES['image']['tmp_name'])) {
    $f = $_FILES['image'];
    if ($f['error'] === UPLOAD_ERR_OK) {
        $allowed = ['image/jpeg','image/png','image/webp','image/gif'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimetype = finfo_file($finfo, $f['tmp_name']);
        finfo_close($finfo);
        if (!in_array($mimetype, $allowed)) {
            header('Location: product_edit.php?id=' . $id . '&err=notsupported');
            exit;
        }
        $ext = pathinfo($f['name'], PATHINFO_EXTENSION);
        $ext = strtolower($ext) ?: (strpos($mimetype,'jpeg')!==false ? 'jpg' : 'png');
        $nameOnDisk = time() . '-' . bin2hex(random_bytes(6)) . '.' . $ext;
        $destRel = 'uploads/' . $nameOnDisk; // relative to public/
        $destAbs = __DIR__ . '/../public/' . $destRel;
        if (!is_dir(dirname($destAbs))) mkdir(dirname($destAbs), 0755, true);
        if (!move_uploaded_file($f['tmp_name'], $destAbs)) {
            header('Location: product_edit.php?id=' . $id . '&err=uploadfail');
            exit;
        }
        $imagePath = $destRel;
    }
}

// Begin transaction for safety
$pdo->beginTransaction();

try {
    if ($id > 0) {
        // update main product (if new image uploaded replace old)
        if ($imagePath) {
            // delete old
            $stmt = $pdo->prepare("SELECT image FROM products WHERE id = :id LIMIT 1");
            $stmt->execute(['id'=>$id]);
            $old = $stmt->fetch();
            if ($old && !empty($old['image'])) {
                $oldAbs = __DIR__ . '/../public/' . $old['image'];
                if (file_exists($oldAbs)) @unlink($oldAbs);
            }
            $stmt = $pdo->prepare("UPDATE products SET sku=:sku, name=:name, description=:description, price=:price, stock=:stock, image=:image WHERE id = :id");
            $stmt->execute(['sku'=>$sku,'name'=>$name,'description'=>$description,'price'=>$price,'stock'=>$stock,'image'=>$imagePath,'id'=>$id]);
        } else {
            $stmt = $pdo->prepare("UPDATE products SET sku=:sku, name=:name, description=:description, price=:price, stock=:stock WHERE id = :id");
            $stmt->execute(['sku'=>$sku,'name'=>$name,'description'=>$description,'price'=>$price,'stock'=>$stock,'id'=>$id]);
        }

        // delete existing variants (we will insert posted ones)
        $pdo->prepare("DELETE FROM product_variants WHERE product_id = :pid")->execute(['pid'=>$id]);
    } else {
        // insert product
        $stmt = $pdo->prepare("INSERT INTO products (sku,name,description,price,stock,image) VALUES (:sku,:name,:description,:price,:stock,:image)");
        $stmt->execute(['sku'=>$sku,'name'=>$name,'description'=>$description,'price'=>$price,'stock'=>$stock,'image'=>$imagePath]);
        $id = (int)$pdo->lastInsertId();
    }

    // Handle variants (if any)
    // variants come as $_POST['variants'] = array(index => ['sku'=>..,'size'=>..,'color'=>..,'price'=>..,'stock'=>..])
    $variants = $_POST['variants'] ?? [];
    // handle uploaded files for variants: $_FILES['variants_files']
    $vfiles = $_FILES['variants_files'] ?? null;

    foreach ($variants as $idx => $v) {
        $vsku = trim($v['sku'] ?? '');
        $vsize = trim($v['size'] ?? '');
        $vcolor = trim($v['color'] ?? '');
        $vprice = $v['price'] !== '' ? (float)$v['price'] : null;
        $vstock = (int)($v['stock'] ?? 0);

        $vImageRel = null;
        // check uploaded file for this variant index
        if ($vfiles && isset($vfiles['tmp_name'][$idx]) && $vfiles['tmp_name'][$idx]) {
            // reorganized structure: because we used variants_files[IDX] as single file per index,
            // $_FILES['variants_files']['tmp_name'][$idx] will exist only if browser sent it correctly.
            $vf = [
                'name' => $vfiles['name'][$idx] ?? $vfiles['name'],
                'type' => $vfiles['type'][$idx] ?? $vfiles['type'],
                'tmp_name' => $vfiles['tmp_name'][$idx] ?? $vfiles['tmp_name'],
                'error' => $vfiles['error'][$idx] ?? $vfiles['error'],
                'size' => $vfiles['size'][$idx] ?? $vfiles['size'],
            ];
            if ($vf['error'] === UPLOAD_ERR_OK) {
                $allowed = ['image/jpeg','image/png','image/webp','image/gif'];
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimetype = finfo_file($finfo, $vf['tmp_name']);
                finfo_close($finfo);
                if (in_array($mimetype, $allowed)) {
                    $ext = pathinfo($vf['name'], PATHINFO_EXTENSION);
                    $ext = strtolower($ext) ?: (strpos($mimetype,'jpeg')!==false ? 'jpg' : 'png');
                    $nameOnDisk = time() . '-' . bin2hex(random_bytes(6)) . '.' . $ext;
                    $destRel = 'uploads/' . $nameOnDisk;
                    $destAbs = __DIR__ . '/../public/' . $destRel;
                    if (!is_dir(dirname($destAbs))) mkdir(dirname($destAbs), 0755, true);
                    move_uploaded_file($vf['tmp_name'], $destAbs);
                    $vImageRel = $destRel;
                }
            }
        }

        // Insert variant row
        $ins = $pdo->prepare("INSERT INTO product_variants (product_id, variant_sku, size, color, price, stock, image) VALUES (:pid, :vsku, :vsize, :vcolor, :vprice, :vstock, :vimg)");
        $ins->execute([
            'pid'=>$id,
            'vsku'=>$vsku ?: null,
            'vsize'=>$vsize ?: null,
            'vcolor'=>$vcolor ?: null,
            'vprice'=>$vprice,
            'vstock'=>$vstock,
            'vimg'=>$vImageRel
        ]);
    }

    $pdo->commit();
} catch (Exception $e) {
    $pdo->rollBack();
    // log error in production
    die("Save failed: " . htmlspecialchars($e->getMessage()));
}

header('Location: products.php?msg=ok');
exit;
