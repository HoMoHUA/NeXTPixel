<?php
/**
 * Database Configuration File
 * این فایل شامل تنظیمات اتصال به دیتابیس است
 */

// تنظیمات اتصال به دیتابیس
define('DB_HOST', 'localhost'); // آدرس هاست دیتابیس
define('DB_NAME', 'nxgbufsb_NP'); // نام دیتابیس
define('DB_USER', 'nxgbufsb_HoMo'); // نام کاربری دیتابیس
define('DB_PASS', '@HoMo13833831'); // رمز عبور دیتابیس
define('DB_CHARSET', 'utf8mb4'); // کاراکترست

// انواع کاربران
define('USER_TYPE_ADMIN', 'admin'); // ادمین اصلی
define('USER_TYPE_STAFF', 'staff'); // همکار
define('USER_TYPE_CUSTOMER', 'customer'); // مشتری

// جدول کاربران
define('TABLE_USERS', 'users');

?>

