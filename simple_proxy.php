<?php
// تنظیمات خطا برای دیباگ (در محیط پروداکشن خاموش کنید)
error_reporting(0);

// دریافت URL مقصد
$url = isset($_GET['url']) ? $_GET['url'] : '';

if (empty($url)) {
    die('URL required.');
}

// دیکد کردن URL اگر انکد شده باشد
$url = urldecode($url);

// اعتبارسنجی URL
if (!filter_var($url, FILTER_VALIDATE_URL)) {
    die('Invalid URL.');
}

// استخراج اجزای URL برای مدیریت لینک‌های نسبی
$parsedUrl = parse_url($url);
$scheme = isset($parsedUrl['scheme']) ? $parsedUrl['scheme'] : 'http';
$host = isset($parsedUrl['host']) ? $parsedUrl['host'] : '';
$port = isset($parsedUrl['port']) ? ':' . $parsedUrl['port'] : '';
$path = isset($parsedUrl['path']) ? $parsedUrl['path'] : '';
$baseUrl = $scheme . '://' . $host . $port . dirname($path) . '/';
$rootUrl = $scheme . '://' . $host . $port;

// شروع cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // دنبال کردن ریدایرکت‌ها
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // شبیه‌سازی مرورگر کاربر
curl_setopt($ch, CURLOPT_HEADER, false);

// دریافت محتوا
$content = curl_exec($ch);
$contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
curl_close($ch);

// تنظیم هدر کانتنت تایپ برای مرورگر
header('Content-Type: ' . $contentType);

// اگر فایل متنی است (HTML, CSS, JS) لینک‌ها را بازنویسی کن
if (strpos($contentType, 'text/html') !== false) {
    // بازنویسی لینک‌های href و src در HTML
    // این الگوی regex لینک‌های نسبی و مطلق را پیدا کرده و آن‌ها را از طریق پروکسی رد می‌کند
    
    $proxyScript = basename(__FILE__); // نام همین فایل (simple_proxy.php)
    
    // تابع بازنویسی لینک
    $rewriteLink = function($matches) use ($proxyScript, $rootUrl, $baseUrl) {
        $attr = $matches[1]; // href or src
        $quote = $matches[2]; // " or '
        $link = $matches[3]; // the url
        
        // اگر لینک دیتایی یا لنگر است دست نزن
        if (strpos($link, 'data:') === 0 || strpos($link, '#') === 0 || strpos($link, 'javascript:') === 0) {
            return $matches[0];
        }
        
        // تبدیل لینک نسبی به مطلق
        if (strpos($link, '//') === 0) {
            $absoluteLink = 'https:' . $link;
        } elseif (strpos($link, '/') === 0) {
            $absoluteLink = $rootUrl . $link;
        } elseif (strpos($link, 'http') !== 0) {
            $absoluteLink = $baseUrl . $link;
        } else {
            $absoluteLink = $link;
        }
        
        return $attr . '=' . $quote . $proxyScript . '?url=' . urlencode($absoluteLink) . $quote;
    };

    // اعمال بازنویسی روی تگ‌ها
    $content = preg_replace_callback('/(href|src|action)\s*=\s*(["\'])(.*?)\2/i', $rewriteLink, $content);
    
    // بازنویسی srcset برای تصاویر ریسپانسیو
    $content = preg_replace_callback('/srcset\s*=\s*(["\'])(.*?)\1/i', function($matches) use ($proxyScript, $rootUrl, $baseUrl) {
        $srcs = explode(',', $matches[2]);
        $newSrcs = [];
        foreach($srcs as $src) {
            $parts = preg_split('/\s+/', trim($src));
            $link = $parts[0];
            
             // تبدیل لینک نسبی به مطلق (کپی منطق بالا)
            if (strpos($link, '/') === 0) {
                $absoluteLink = $rootUrl . $link;
            } elseif (strpos($link, 'http') !== 0) {
                $absoluteLink = $baseUrl . $link;
            } else {
                $absoluteLink = $link;
            }
            
            $parts[0] = $proxyScript . '?url=' . urlencode($absoluteLink);
            $newSrcs[] = implode(' ', $parts);
        }
        return 'srcset="' . implode(', ', $newSrcs) . '"';
    }, $content);
    
    // افزودن تگ Base برای اطمینان بیشتر (اختیاری)
    // $content = str_replace('<head>', '<head><base href="'.$baseUrl.'">', $content);

} elseif (strpos($contentType, 'css') !== false) {
    // بازنویسی url() در فایل‌های CSS
    $proxyScript = basename(__FILE__);
    $content = preg_replace_callback('/url\(\s*[\'"]?(.*?)[\'"]?\s*\)/i', function($matches) use ($proxyScript, $rootUrl, $baseUrl) {
        $link = $matches[1];
        if (strpos($link, 'data:') === 0) return $matches[0];
        
        if (strpos($link, '/') === 0) {
            $absoluteLink = $rootUrl . $link;
        } elseif (strpos($link, 'http') !== 0) {
            $absoluteLink = $baseUrl . $link;
        } else {
            $absoluteLink = $link;
        }
        return 'url(' . $proxyScript . '?url=' . urlencode($absoluteLink) . ')';
    }, $content);
}

echo $content;
?>