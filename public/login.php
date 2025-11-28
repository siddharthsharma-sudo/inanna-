<?php
// public/login.php
require_once __DIR__ . '/../public/includes/db.php'; // <-- use this if includes/ is at project root
// If your db.php is at public/includes/db.php, use:
// require_once __DIR__ . '/includes/db.php';

session_start();

// If already logged in, go to account
if (!empty($_SESSION['user_id'])) {
    header('Location: account.php');
    exit;
}

// CSRF
if (empty($_SESSION['login_csrf'])) $_SESSION['login_csrf'] = bin2hex(random_bytes(16));
$csrf = $_SESSION['login_csrf'];

$error = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf'] ?? '';
    if (!hash_equals($csrf, (string)$token)) {
        $error = 'Invalid request (CSRF).';
    } else {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
            $error = 'Please enter email and password.';
        } else {
            $stmt = $pdo->prepare("SELECT id,name,password_hash,role FROM users WHERE email = :email LIMIT 1");
            $stmt->execute(['email'=>$email]);
            $user = $stmt->fetch();
            if ($user && !empty($user['password_hash']) && password_verify($password, $user['password_hash'])) {
                // login success
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'] ?? '';
                // redirect to account or preserved page
                $dest = $_SESSION['after_login'] ?? 'account.php';
                unset($_SESSION['after_login']);
                header('Location: ' . $dest);
                exit;
            } else {
                $error = 'Invalid email or password.';
            }
        }
    }
}

include __DIR__ . '/includes/header.php';
?>
<div class="container my-4" style="max-width:540px;">
  <h2>Sign in</h2>

  <?php if ($error): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
  <?php endif; ?>

  <div class="card p-4 shadow-sm">
    <form method="post" novalidate>
      <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($csrf); ?>">
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input name="email" type="email" class="form-control" required value="<?php echo htmlspecialchars($email); ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input name="password" type="password" class="form-control" required>
      </div>

      <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
          <button class="btn btn-primary" type="submit">Sign in</button>
        </div>
        <div>
          <!-- Forgot password link -->
          <a href="forgot_password.php" class="small">Forgot password?</a>
        </div>
      </div>

      <div>
        <a class="btn btn-outline-secondary" href="register.php">Create account</a>
      </div>
    </form>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
