<?php

$url = isset($_GET['url']) ? $_GET['url'] : '#';
$title = isset($_GET['title']) ? $_GET['title'] : 'پیش‌نمایش وبسایت';


$url = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
$title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پیش‌نمایش: <?php echo $title; ?> | NextPixel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Vazirmatn:wght@100;200;300;400;500;600;700;800;900&display=swap');
        body {
            font-family: 'Vazirmatn', sans-serif;
            margin: 0;
            padding: 0;
            overflow: hidden; 
            background-color: #0f172a;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: rgba(59, 130, 246, 0.2);
            z-index: 2000;
        }

            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6); 
            transition: width 0.2s ease;
            box-shadow: 0 0 10px rgba(59, 130, 246, 0.7);
        }

        .preview-header {
            height: 60px;
            background: rgba(15, 23, 42, 0.95);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            z-index: 1000;
            flex-shrink: 0;
        }

        .preview-iframe {
            flex-grow: 1;
            width: 100%;
            border: none;
            background: white;
        }
        
        .btn-close {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #94a3b8;
            transition: color 0.3s;
        }
        .btn-close:hover {
            color: white;
        }
        
        .btn-buy {
            background: linear-gradient(45deg, #3b82f6, #8b5cf6);
            color: white;
            padding: 0.5rem 1.25rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }
        .btn-buy:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
        }
    </style>
</head>
<body>

    
    <div id="progress-container">
        <div id="progress-bar"></div>
    </div>

    
    <header class="preview-header">
        <div class="flex items-center gap-4">
            <a href="/portfolio.php" class="btn-close">
                <i data-feather="x" class="w-5 h-5"></i>
                <span class="hidden sm:inline">بستن پیش‌نمایش</span>
            </a>
            <div class="h-6 w-px bg-slate-700 mx-2 hidden sm:block"></div>
            <div class="flex items-center gap-3">
                <span class="text-white font-bold text-lg hidden sm:block">NextPixel</span>
                <span class="text-slate-400 text-sm truncate max-w-[150px] sm:max-w-xs">/ <?php echo $title; ?></span>
            </div>
        </div>

        <div class="flex items-center gap-3">
            
            <div class="hidden md:flex gap-2 mr-4 bg-slate-800 p-1 rounded-lg">
                <button onclick="setDevice('desktop')" class="p-2 text-white hover:bg-slate-700 rounded transition"><i data-feather="monitor" class="w-4 h-4"></i></button>
                <button onclick="setDevice('tablet')" class="p-2 text-gray-400 hover:bg-slate-700 hover:text-white rounded transition"><i data-feather="tablet" class="w-4 h-4"></i></button>
                <button onclick="setDevice('mobile')" class="p-2 text-gray-400 hover:bg-slate-700 hover:text-white rounded transition"><i data-feather="smartphone" class="w-4 h-4"></i></button>
            </div>
            
            <a href="<?php echo $url; ?>" class="btn-buy flex items-center gap-2">
                <span>مشاهده مستقیم</span>
                <i data-feather="external-link" class="w-4 h-4"></i>
            </a>
        </div>
    </header>

    
    <div id="iframe-wrapper" class="w-full h-full flex justify-center bg-gray-900 transition-all duration-300">
        <iframe id="main-iframe" src="<?php echo $url; ?>" class="preview-iframe w-full h-full transition-all duration-300" title="<?php echo $title; ?>"></iframe>
    </div>

    <script>
        feather.replace();

        
        const progressBar = document.getElementById('progress-bar');
        const iframe = document.getElementById('main-iframe');
        const progressContainer = document.getElementById('progress-container');
        
        let width = 0;
        const interval = setInterval(() => {
            if (width >= 90) {
                clearInterval(interval);
            } else {
                width += Math.random() * 10;
                progressBar.style.width = width + '%';
            }
        }, 200);

        
        iframe.onload = function() {
            clearInterval(interval);
            progressBar.style.width = '100%';
            
            setTimeout(() => {
                progressContainer.style.opacity = '0';
                progressContainer.style.transition = 'opacity 0.5s ease';
            }, 500);
        };

        
        function setDevice(device) {
            const wrapper = document.getElementById('iframe-wrapper');
            const iframe = document.getElementById('main-iframe');
            
            
            document.querySelectorAll('button[onclick^="setDevice"] i').forEach(icon => {
                icon.parentElement.classList.remove('text-white');
                icon.parentElement.classList.add('text-gray-400');
            });
            
            
            const activeBtn = document.querySelector(`button[onclick="setDevice('${device}')"]`);
            if(activeBtn) {
                activeBtn.classList.remove('text-gray-400');
                activeBtn.classList.add('text-white');
            }

            if (device === 'mobile') {
                iframe.style.width = '375px';
                iframe.style.borderLeft = '1px solid #333';
                iframe.style.borderRight = '1px solid #333';
            } else if (device === 'tablet') {
                iframe.style.width = '768px';
                iframe.style.borderLeft = '1px solid #333';
                iframe.style.borderRight = '1px solid #333';
            } else {
                iframe.style.width = '100%';
                iframe.style.border = 'none';
            }
        }
    </script>
</body>
</html>
