<?php
/**
 * API Endpoint برای بررسی اتصال به n8n
 */

header('Content-Type: application/json');

// بررسی session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// بررسی دسترسی - فقط باید لاگین باشد
$isLoggedIn = isset($_SESSION['user_id']);

if (!$isLoggedIn) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'لطفا ابتدا وارد شوید']);
    exit;
}

// بارگذاری تنظیمات
require_once __DIR__ . '/../config/n8n-config.php';

$baseUrl = N8N_BASE_URL;
$apiKey = N8N_API_KEY;

// بررسی اتصال به n8n
try {
    $url = rtrim($baseUrl, '/') . '/api/v1/workflows';
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, N8N_TIMEOUT);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    
    // آماده‌سازی headers
    $headers = [];
    
    // اگر API Key وجود دارد، اضافه کن
    if (!empty($apiKey)) {
        $headers[] = 'X-N8N-API-KEY: ' . $apiKey;
    }
    
    // اگر username و password وجود دارد، از Basic Auth استفاده کن
    if (!empty(N8N_USERNAME) && !empty(N8N_PASSWORD)) {
        curl_setopt($ch, CURLOPT_USERPWD, N8N_USERNAME . ':' . N8N_PASSWORD);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    }
    
    // اضافه کردن headers
    if (!empty($headers)) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }
    
    // اگر Cookie وجود دارد (از session)، استفاده کن
    if (isset($_COOKIE) && !empty($_COOKIE)) {
        $cookieString = '';
        foreach ($_COOKIE as $key => $value) {
            $cookieString .= $key . '=' . $value . '; ';
        }
        if (!empty($cookieString)) {
            curl_setopt($ch, CURLOPT_COOKIE, rtrim($cookieString, '; '));
        }
    }
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    $responseBody = $response;
    curl_close($ch);
    
    if ($error) {
        echo json_encode([
            'success' => false,
            'connected' => false,
            'message' => 'خطا در اتصال: ' . $error,
            'debug' => [
                'url' => $url,
                'has_api_key' => !empty($apiKey),
                'has_basic_auth' => !empty(N8N_USERNAME) && !empty(N8N_PASSWORD)
            ]
        ]);
        exit;
    }
    
    if ($httpCode >= 200 && $httpCode < 300) {
        echo json_encode([
            'success' => true,
            'connected' => true,
            'url' => $baseUrl,
            'http_code' => $httpCode
        ]);
    } else {
        // بررسی نوع خطا
        $errorMessage = 'خطا در اتصال. کد HTTP: ' . $httpCode;
        
        if ($httpCode == 401) {
            $errorMessage = 'خطا در احراز هویت (401). لطفا API Key یا نام کاربری/رمز عبور را در فایل config/n8n-config.php تنظیم کنید.';
        } elseif ($httpCode == 403) {
            $errorMessage = 'دسترسی غیرمجاز (403). لطفا دسترسی‌های خود را بررسی کنید.';
        } elseif ($httpCode == 404) {
            $errorMessage = 'مسیر یافت نشد (404). لطفا آدرس n8n را بررسی کنید.';
        }
        
        // تلاش برای خواندن پیام خطا از response
        $errorData = json_decode($responseBody, true);
        if ($errorData && isset($errorData['message'])) {
            $errorMessage .= ' - ' . $errorData['message'];
        }
        
        echo json_encode([
            'success' => false,
            'connected' => false,
            'message' => $errorMessage,
            'http_code' => $httpCode,
            'debug' => [
                'url' => $url,
                'has_api_key' => !empty($apiKey),
                'has_basic_auth' => !empty(N8N_USERNAME) && !empty(N8N_PASSWORD),
                'response_preview' => substr($responseBody, 0, 200)
            ]
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'connected' => false,
        'message' => 'خطا: ' . $e->getMessage()
    ]);
}
?>


