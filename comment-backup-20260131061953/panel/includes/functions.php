<?php
/**
 * Global Functions File
 * توابع عمومی استفاده شده در پنل
 */

/**
 * Calculate Seller Salary based on total sales
 * محاسبه حقوق فروشنده بر اساس کل فروش
 * 
 * @param float $totalSales Total sales amount in Tomans
 * @return float Calculated salary in Tomans
 */
function calculateSalary($totalSales) {
    // تبدیل به عدد صحیح برای مقایسه
    $x = floatval($totalSales);
    
    // 0 <= x < 25,000,000
    if ($x >= 0 && $x < 25000000) {
        return $x * 0.10;
    }
    
    // x = 25,000,000
    if ($x == 25000000) {
        return 5000000;
    }
    
    // 25,000,000 < x < 50,000,000
    if ($x > 25000000 && $x < 50000000) {
        return 5000000 + ($x * 0.10);
    }
    
    // x = 50,000,000
    if ($x == 50000000) {
        return 7500000;
    }
    
    // 50,000,000 < x < 75,000,000
    if ($x > 50000000 && $x < 75000000) {
        return 7500000 + ($x * 0.15);
    }
    
    // x = 75,000,000
    if ($x == 75000000) {
        return 12000000 + 750000; // 12,750,000
    }
    
    // x > 75,000,000
    if ($x > 75000000) {
        // Base is 12m for first 75m, plus 20% on remainder
        return 12000000 + (($x - 75000000) * 0.20);
    }
    
    return 0;
}

/**
 * Format number with Persian separators
 * فرمت کردن عدد با جداکننده فارسی
 */
function formatNumber($number) {
    return number_format($number, 0, '.', ',');
}

/**
 * Generate random Support ID
 * تولید شناسه پشتیبانی تصادفی
 */
function generateSupportID() {
    return 'NP-' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 8)) . '-' . date('Ymd');
}

/**
 * Check if file is valid image (JPG/PNG)
 */
function isValidImage($file) {
    $allowed = ['image/jpeg', 'image/jpg', 'image/png'];
    $type = $file['type'];
    return in_array($type, $allowed);
}

/**
 * Check if file is valid audio (MP3)
 */
function isValidAudio($file) {
    $allowed = ['audio/mpeg', 'audio/mp3', 'audio/mpeg3'];
    $type = $file['type'];
    return in_array($type, $allowed);
}

/**
 * Upload file and return path
 */
function uploadFile($file, $uploadDir = 'uploads/', $allowedTypes = []) {
    if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
        return false;
    }
    
    $fileName = time() . '_' . basename($file['name']);
    $targetPath = __DIR__ . '/../' . $uploadDir . $fileName;
    
    // ایجاد پوشه در صورت عدم وجود
    $fullUploadDir = __DIR__ . '/../' . $uploadDir;
    if (!file_exists($fullUploadDir)) {
        mkdir($fullUploadDir, 0777, true);
    }
    
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return $uploadDir . $fileName;
    }
    
    return false;
}

/**
 * Sanitize input
 */
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

?>

