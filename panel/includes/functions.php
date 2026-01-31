<?php

function calculateSalary($totalSales) {
    
    $x = floatval($totalSales);

    if ($x >= 0 && $x < 25000000) {
        return $x * 0.10;
    }

    if ($x == 25000000) {
        return 5000000;
    }

    if ($x > 25000000 && $x < 50000000) {
        return 5000000 + ($x * 0.10);
    }

    if ($x == 50000000) {
        return 7500000;
    }

    if ($x > 50000000 && $x < 75000000) {
        return 7500000 + ($x * 0.15);
    }

    if ($x == 75000000) {
        return 12000000 + 750000; 
    }

    if ($x > 75000000) {
        
        return 12000000 + (($x - 75000000) * 0.20);
    }
    
    return 0;
}

function formatNumber($number) {
    return number_format($number, 0, '.', ',');
}

function generateSupportID() {
    return 'NP-' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 8)) . '-' . date('Ymd');
}

function isValidImage($file) {
    $allowed = ['image/jpeg', 'image/jpg', 'image/png'];
    $type = $file['type'];
    return in_array($type, $allowed);
}

function isValidAudio($file) {
    $allowed = ['audio/mpeg', 'audio/mp3', 'audio/mpeg3'];
    $type = $file['type'];
    return in_array($type, $allowed);
}

function uploadFile($file, $uploadDir = 'uploads/', $allowedTypes = []) {
    if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
        return false;
    }
    
    $fileName = time() . '_' . basename($file['name']);
    $targetPath = __DIR__ . '/../' . $uploadDir . $fileName;

    $fullUploadDir = __DIR__ . '/../' . $uploadDir;
    if (!file_exists($fullUploadDir)) {
        mkdir($fullUploadDir, 0777, true);
    }
    
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return $uploadDir . $fileName;
    }
    
    return false;
}

function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

?>

