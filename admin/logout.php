<?php
// admin/logout.php
if (session_status() === PHP_SESSION_NONE) session_start();

// Unset admin session keys and destroy session
unset($_SESSION['admin_id'], $_SESSION['admin_name'], $_SESSION['after_login']);
session_regenerate_id(true);
session_destroy();

// Redirect to login
header('Location: login.php');
exit;
