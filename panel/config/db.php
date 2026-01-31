<?php
/**
 * Database Connection File for Panel
 * اتصال به دیتابیس برای پنل
 */

// استفاده از فایل تنظیمات دیتابیس موجود
require_once __DIR__ . '/../../config/db-config.php';
require_once __DIR__ . '/../../config/db-connection.php';

/**
 * Helper function to get database connection
 */
function getPanelDB() {
    return getDB();
}

?>

