<?php
// public/logout.php
session_start();
unset($_SESSION['user_id'], $_SESSION['user_name'], $_SESSION['after_login']);
session_regenerate_id(true);
session_destroy();
header('Location: login.php');
exit;
