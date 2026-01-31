<?php
/**
 * Logout Handler
 * مدیریت خروج از سیستم
 */

session_start();
session_unset();
session_destroy();

header('Location: /panel/auth/login.php');
exit;

?>

