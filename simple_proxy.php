<?php

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);


$url = isset($_GET['url']) ? $_GET['url'] : '';

if (empty($url)) {
    die('URL parameter is missing.');
}


$decodedUrl = urldecode($url);


if (!filter_var($decodedUrl, FILTER_VALIDATE_URL)) {
    die('Invalid URL.');
}


$parsed = parse_url($decodedUrl);
$baseUrl = $parsed['scheme'] . '://' . $parsed['host'] . (isset($parsed['port']) ? ':' . $parsed['port'] : '');
$basePath = isset($parsed['path']) ? dirname($parsed['path']) : '';
if ($basePath === '/' || $basePath === '.') $basePath = '';


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $decodedUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');

$headers = [];
if (isset($_SERVER['HTTP_ACCEPT'])) $headers[] = "Accept: " . $_SERVER['HTTP_ACCEPT'];
if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) $headers[] = "Accept-Language: " . $_SERVER['HTTP_ACCEPT_LANGUAGE'];
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$content = curl_exec($ch);
$contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
curl_close($ch);


header('Content-Type: ' . $contentType);


if (strpos($contentType, 'text/html') !== false) {
    
    
    $proxyScript = basename($_SERVER['PHP_SELF']);
    
    
    $content = preg_replace_callback('/(href|src|action)\s*=\s*(["\'])(.*?)\2/i', function($matches) use ($proxyScript, $baseUrl) {
        $attr = $matches[1];
        $link = $matches[3];
        
        
        if (strpos($link, 'data:') === 0 || strpos($link, '#') === 0 || strpos($link, 'javascript:') === 0) {
            return $matches[0];
        }
        
        
        if (strpos($link, '
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

    
    
    $scriptInjection = <<<JS
    <script>
    (function() {
        
        try {
            window.history.replaceState(null, '', '/');
        } catch(e) {}

        
        const proxyBase = "{$proxyScript}?url=";
        const targetOrigin = "{$baseUrl}";

        function rewriteUrl(u) {
            if (!u || typeof u !== 'string') return u;
            if (u.startsWith('data:') || u.startsWith('blob:') || u.includes('{$proxyScript}')) return u;
            
            
            if (u.startsWith(targetOrigin)) {
                return proxyBase + encodeURIComponent(u);
            }
            
            if (u.startsWith('/')) {
                return proxyBase + encodeURIComponent(targetOrigin + u);
            }
            
            if (!u.startsWith('http')) {
                return proxyBase + encodeURIComponent(targetOrigin + '/' + u);
            }
            return u;
        }

        
        const originalFetch = window.fetch;
        window.fetch = function(input, init) {
            if (typeof input === 'string') {
                input = rewriteUrl(input);
            }
            return originalFetch(input, init);
        };

        
        const originalOpen = XMLHttpRequest.prototype.open;
        XMLHttpRequest.prototype.open = function(method, url, ...args) {
            url = rewriteUrl(url);
            return originalOpen.apply(this, [method, url, ...args]);
        };
        
        
        window.onerror = function() { return true; };
    })();
    </script>
    <base href="{$baseUrl}/">
JS;
    
    
    $content = str_replace('<head>', '<head>' . $scriptInjection, $content);
}


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
