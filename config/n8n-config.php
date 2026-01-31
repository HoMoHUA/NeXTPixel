<?php
/**
 * n8n Configuration File
 * این فایل شامل تنظیمات اتصال به n8n است
 */

// تنظیمات اتصال به n8n
define('N8N_BASE_URL', 'https://32947-kp4r5.s5.irann8n.com'); // آدرس دامنه n8n شما
define('N8N_API_KEY', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiI3MzhjMTk5Ni03M2RlLTQ3ZjMtYWNkMC0yOWM0MmYyYzc5YjkiLCJpc3MiOiJuOG4iLCJhdWQiOiJwdWJsaWMtYXBpIiwiaWF0IjoxNzY0OTM3MzAxfQ.YirwLsgV-MO4rRXkvjB0ylTXvsqq2Q9DEPht-n3PG4M'); // API Key برای دسترسی به n8n
define('N8N_USERNAME', 'mollahoseinih3@gmail.com'); // نام کاربری n8n
define('N8N_PASSWORD', ''); // رمز عبور n8n (در صورت نیاز)

// تنظیمات احراز هویت
// کاربری که می‌تواند به پنل n8n دسترسی داشته باشد
define('N8N_ADMIN_USERNAME', 'HoMo');
define('N8N_ADMIN_DISPLAY_NAME', 'N8N');

// تنظیمات API
define('N8N_API_VERSION', 'v1');
define('N8N_TIMEOUT', 30); // Timeout برای درخواست‌های API (ثانیه)

// مسیرهای API n8n
define('N8N_API_WORKFLOWS', '/api/v1/workflows');
define('N8N_API_EXECUTIONS', '/api/v1/executions');
define('N8N_API_ACTIVE', '/api/v1/active');
define('N8N_API_ACTIVATE', '/api/v1/workflows/activate');
define('N8N_API_DEACTIVATE', '/api/v1/workflows/deactivate');

?>

