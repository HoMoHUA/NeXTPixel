<?php
// تنظیمات برای جلوگیری از توقف اسکریپت در صورت خطاهای جزئی
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

// دریافت آدرس مقصد
$url = isset($_GET['url']) ? $_GET['url'] : '';

if (empty($url)) {
    die('URL parameter is missing.');
}

// دیکد کردن آدرس
$decodedUrl = urldecode($url);

// بررسی اعتبار URL
if (!filter_var($decodedUrl, FILTER_VALIDATE_URL)) {
    die('Invalid URL.');
}

// استخراج ریشه آدرس برای بازنویسی لینک‌ها
$parsed = parse_url($decodedUrl);
$baseUrl = $parsed['scheme'] . '://' . $parsed['host'] . (isset($parsed['port']) ? ':' . $parsed['port'] : '');
$basePath = isset($parsed['path']) ? dirname($parsed['path']) : '';
if ($basePath === '/' || $basePath === '.') $basePath = '';

// تنظیم هدرهای cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $decodedUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');
// فوروارد کردن هدرهای ضروری برای جلوگیری از بلاک شدن
$headers = [];
if (isset($_SERVER['HTTP_ACCEPT'])) $headers[] = "Accept: " . $_SERVER['HTTP_ACCEPT'];
if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) $headers[] = "Accept-Language: " . $_SERVER['HTTP_ACCEPT_LANGUAGE'];
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$content = curl_exec($ch);
$contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
curl_close($ch);

// تنظیم هدر خروجی
header('Content-Type: ' . $contentType);

// اگر محتوا HTML است، نیاز به تزریق کدهای اصلاحی داریم
if (strpos($contentType, 'text/html') !== false) {
    
    // نام همین فایل برای ارجاع
    $proxyScript = basename($_SERVER['PHP_SELF']);
    
    // 1. بازنویسی لینک‌های ساده در HTML
    $content = preg_replace_callback('/(href|src|action)\s*=\s*(["\'])(.*?)\2/i', function($matches) use ($proxyScript, $baseUrl) {
        $attr = $matches[1];
        $link = $matches[3];
        
        // نادیده گرفتن لینک‌های دیتا و لنگر
        if (strpos($link, 'data:') === 0 || strpos($link, '#') === 0 || strpos($link, 'javascript:') === 0) {
            return $matches[0];
        }
        
        // تبدیل لینک نسبی به مطلق و عبور از پروکسی
        if (strpos($link, '//') === 0) {
            $abs = 'https:' . $link;
        } elseif (strpos($link, '/') === 0) {
            $abs = $baseUrl . $link;
        } elseif (strpos($link, 'http') !== 0) {
            $abs = $baseUrl . '/' . $link;
        } else {
            $abs = $link;
        }
        
        return $attr . '="' . $proxyScript . '?url=' . urlencode($abs) . '"';
    }, $content);

    // 2. تزریق اسکریپت‌های حیاتی برای اجرای React/Next.js
    // این بخش بسیار مهم است: ما History API و Fetch را هوک می‌کنیم تا درخواست‌ها درست هدایت شوند.
    $scriptInjection = <<<JS
    <script>
    (function() {
        // الف) فریب دادن Router: تغییر آدرس ظاهری به ریشه تا Router سایت گیج نشود
        try {
            window.history.replaceState(null, '', '/');
        } catch(e) {}

        // ب) تنظیمات پروکسی برای درخواست‌های جاوااسکریپتی (Fetch/XHR)
        const proxyBase = "{$proxyScript}?url=";
        const targetOrigin = "{$baseUrl}";

        function rewriteUrl(u) {
            if (!u || typeof u !== 'string') return u;
            if (u.startsWith('data:') || u.startsWith('blob:') || u.includes('{$proxyScript}')) return u;
            
            // اگر آدرس کامل است و مربوط به سایت هدف است
            if (u.startsWith(targetOrigin)) {
                return proxyBase + encodeURIComponent(u);
            }
            // اگر آدرس نسبی از ریشه است (/api/...)
            if (u.startsWith('/')) {
                return proxyBase + encodeURIComponent(targetOrigin + u);
            }
            // اگر آدرس نسبی است (assets/...)
            if (!u.startsWith('http')) {
                return proxyBase + encodeURIComponent(targetOrigin + '/' + u);
            }
            return u;
        }

        // هوک کردن Fetch
        const originalFetch = window.fetch;
        window.fetch = function(input, init) {
            if (typeof input === 'string') {
                input = rewriteUrl(input);
            }
            return originalFetch(input, init);
        };

        // هوک کردن XMLHttpRequest
        const originalOpen = XMLHttpRequest.prototype.open;
        XMLHttpRequest.prototype.open = function(method, url, ...args) {
            url = rewriteUrl(url);
            return originalOpen.apply(this, [method, url, ...args]);
        };
        
        // جلوگیری از خطاهای متداول Cross-Origin در آی‌فریم
        window.onerror = function() { return true; };
    })();
    </script>
    <base href="{$baseUrl}/">
JS;
    
    // تزریق کدها به ابتدای <head>
    $content = str_replace('<head>', '<head>' . $scriptInjection, $content);
}

// اگر CSS است، لینک‌های url() را اصلاح کن
elseif (strpos($contentType, 'css') !== false) {
    $proxyScript = basename($_SERVER['PHP_SELF']);
    $content = preg_replace_callback('/url\(\s*[\'"]?(.*?)[\'"]?\s*\)/i', function($matches) use ($proxyScript, $baseUrl) {
        $link = $matches[1];
        if (strpos($link, 'data:') === 0) return $matches[0];
        
        if (strpos($link, '/') === 0) {
            $abs = $baseUrl . $link;
        } elseif (strpos($link, 'http') !== 0) {
            $abs = $baseUrl . '/' . $link;
        } else {
            $abs = $link;
        }
        return 'url(' . $proxyScript . '?url=' . urlencode($abs) . ')';
    }, $content);
}

echo $content;
?>