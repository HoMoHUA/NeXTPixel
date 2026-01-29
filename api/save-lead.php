<?php
// اجازه دسترسی از دامنه شما
// در محیط واقعی، '*' را با دامنه اصلی خود (مثل https://nextpixel.top) جایگزین کنید
header("Access-Control-Allow-Origin: *"); // برای تست می‌توانید * بگذارید
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// مدیریت درخواست OPTIONS (Preflight)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

// مسیر پوشه‌ای که می‌خواهید لاگ‌ها در آن ذخیره شوند
// مطمئن شوید که این پوشه روی هاست شما وجود دارد و مجوز نوشتن (Write Permission 755 or 777) دارد
$logDirectory = __DIR__ . '/leads/';
if (!is_dir($logDirectory)) {
    mkdir($logDirectory, 0755, true);
}

// دریافت داده‌های JSON ارسال شده
$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['summary'])) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
    exit;
}

// تمیز کردن و آماده‌سازی خلاصه
$summary = $input['summary'];
$summary = str_replace(['[START_LEAD_SUMMARY]', '[END_LEAD_SUMMARY]'], '', $summary);
$summary = trim($summary);

// ایجاد یک نام فایل منحصر به فرد بر اساس تاریخ و زمان
date_default_timezone_set('Asia/Tehran');
$filename = $logDirectory . 'lead_' . date('Y-m-d_H-i-s') . '_' . uniqid() . '.txt';

// آماده‌سازی محتوا برای فایل
$fileContent = "تاریخ و زمان (تهران): " . date('Y-m-d H:i:s') . "\n";
$fileContent .= "IP کاربر: " . $_SERVER['REMOTE_ADDR'] . "\n";
$fileContent .= "User-Agent: " . $_SERVER['HTTP_USER_AGENT'] . "\n";
$fileContent .= "--------------------------------------------------\n\n";
$fileContent .= $summary;

// ذخیره فایل
if (file_put_contents($filename, $fileContent)) {
    echo json_encode(['status' => 'success', 'message' => 'Lead saved']);
} else {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Failed to write to file on server. Check permissions for /api/leads/']);
}
?>

