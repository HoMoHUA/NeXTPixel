<?php
// بررسی session و احراز هویت
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// بررسی لاگین بودن کاربر
$isLoggedIn = isset($_SESSION['user_id']);
$username = $_SESSION['username'] ?? '';
$displayName = $_SESSION['display_name'] ?? '';

// اگر لاگین نیست، به صفحه لاگین هدایت شود
if (!$isLoggedIn) {
    header('Location: login.php');
    exit;
}

// بارگذاری تنظیمات n8n
require_once 'config/n8n-config.php';
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl" class="overflow-x-hidden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پنل مدیریت n8n | NextPixel</title>
    <link rel="icon" type="image/x-icon" href="/static/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js" defer></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Vazirmatn:wght@100;200;300;400;500;600;700;800;900&display=swap');
        
        * {
            font-family: 'Vazirmatn', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
            color: #f8fafc;
            line-height: 1.8;
            min-height: 100vh;
        }
        
        .glass-effect {
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(12px) saturate(180%);
            -webkit-backdrop-filter: blur(12px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.125);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        
        .gradient-text {
            background: linear-gradient(90deg, #60a5fa, #818cf8, #a78bfa);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            background-size: 200% auto;
        }
        
        nav.ios-glass-header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: saturate(180%) blur(30px);
            -webkit-backdrop-filter: saturate(180%) blur(30px);
            border: 0.5px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 1px 0 0 rgba(255, 255, 255, 0.05) inset,
                        0 -1px 0 0 rgba(0, 0, 0, 0.1) inset,
                        0 8px 32px rgba(0, 0, 0, 0.12);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        nav.ios-glass-header.scrolled {
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: saturate(200%) blur(40px);
            -webkit-backdrop-filter: saturate(200%) blur(40px);
        }
        
        .workflow-card {
            transition: all 0.3s ease;
        }
        
        .workflow-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(59, 130, 246, 0.3);
        }
        
        .status-active {
            background: linear-gradient(45deg, #10b981, #059669);
            color: white;
        }
        
        .status-inactive {
            background: linear-gradient(45deg, #6b7280, #4b5563);
            color: white;
        }
        
        .btn-primary {
            background: linear-gradient(45deg, #3b82f6, #8b5cf6);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
        }
        
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(59, 130, 246, 0.4); }
            50% { box-shadow: 0 0 30px rgba(59, 130, 246, 0.6); }
        }
        
        .loading {
            animation: pulse-glow 2s ease-in-out infinite;
        }
        
        .modal-overlay {
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(8px);
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .modal-content {
            animation: fadeIn 0.3s ease;
        }
        
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }
        
        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #4b5563;
            transition: .4s;
            border-radius: 34px;
        }
        
        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        
        input:checked + .slider {
            background: linear-gradient(45deg, #10b981, #059669);
        }
        
        input:checked + .slider:before {
            transform: translateX(26px);
        }
    </style>
</head>
<body>
    <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    ?>

    <style>
        /* Header Styles */
        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            background: rgba(15, 23, 42, 0.5);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        header.scrolled {
            background: rgba(15, 23, 42, 0.8);
            border-bottom-color: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        .header-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 70px;
        }

        @media (min-width: 768px) {
            .header-container {
                padding: 1rem 2rem;
            }
        }

        .header-logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            flex-shrink: 0;
        }

        .header-logo img {
            height: 40px;
            width: auto;
            max-width: 100%;
            transition: transform 0.3s;
        }

        .header-logo:hover img {
            transform: scale(1.05);
        }

        .header-logo-text {
            font-size: 1.25rem;
            font-weight: 800;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            white-space: nowrap;
        }

        @media (max-width: 640px) {
            .header-logo-text {
                font-size: 1.1rem;
            }
        }

        .header-nav {
            display: none;
        }

        @media (min-width: 768px) {
            .header-nav {
                display: flex;
                align-items: center;
                gap: 2rem;
                flex: 1;
                margin: 0 2rem;
            }

            .header-nav a {
                color: #f8fafc;
                text-decoration: none;
                font-weight: 500;
                font-size: 0.95rem;
                transition: all 0.3s;
                position: relative;
                padding-bottom: 0.25rem;
            }

            .header-nav a::after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 0;
                width: 0;
                height: 2px;
                background: linear-gradient(90deg, #3b82f6, #8b5cf6);
                transition: width 0.3s;
            }

            .header-nav a:hover::after,
            .header-nav a.active::after {
                width: 100%;
            }

            .header-nav a:hover,
            .header-nav a.active {
                color: #60a5fa;
            }
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-shrink: 0;
        }

        @media (max-width: 767px) {
            .header-actions {
                gap: 0.25rem;
            }
        }

        .header-btn {
            padding: 0.4rem 1rem;
            border-radius: 9999px;
            font-weight: 500;
            font-size: 0.8rem;
            text-decoration: none;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            transition: all 0.3s;
            white-space: nowrap;
        }

        @media (min-width: 768px) {
            .header-btn {
                padding: 0.5rem 1.25rem;
                font-size: 0.875rem;
            }
        }

        .header-btn-primary {
            background-color: #3b82f6;
            color: white;
        }

        .header-btn-primary:hover {
            background-color: #2563eb;
            transform: translateY(-2px);
        }

        .header-btn-success {
            background-color: #16a34a;
            color: white;
        }

        .header-btn-success:hover {
            background-color: #15803d;
            transform: translateY(-2px);
        }

        .header-btn-purple {
            background-color: #a855f7;
            color: white;
        }

        .header-btn-purple:hover {
            background-color: #9333ea;
            transform: translateY(-2px);
        }

        .menu-toggle {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: none;
            border: none;
            cursor: pointer;
            color: white;
            transition: all 0.3s;
            padding: 0;
        }

        .menu-toggle:hover {
            transform: scale(1.1);
        }

        @media (min-width: 768px) {
            .menu-toggle {
                display: none;
            }
        }

        .mobile-menu {
            display: none;
            position: fixed;
            inset: 0;
            top: 70px;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.95), rgba(30, 41, 59, 0.95));
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            z-index: 999;
            overflow-y: auto;
        }

        .mobile-menu.active {
            display: flex;
            flex-direction: column;
            animation: slideInFromTop 0.3s ease-out forwards;
        }

        @keyframes slideInFromTop {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .mobile-menu-content {
            padding: 2rem 1.5rem;
        }

        .mobile-menu-section {
            margin-bottom: 2rem;
        }

        .mobile-menu-section-title {
            font-size: 0.75rem;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 1rem;
        }

        .mobile-menu-links {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .mobile-menu-links a {
            color: #f8fafc;
            text-decoration: none;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.3s;
            font-weight: 500;
        }

        .mobile-menu-links a:hover,
        .mobile-menu-links a.active {
            background: rgba(59, 130, 246, 0.2);
            color: #60a5fa;
            transform: translateX(-0.5rem);
        }

        .mobile-menu-buttons {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .mobile-menu-buttons .header-btn {
            width: 100%;
            justify-content: center;
            padding: 0.75rem 1rem;
        }

        @media (min-width: 768px) {
            .mobile-menu {
                display: none !important;
            }
        }
    </style>

    <!-- Header -->
    <header class="header-main" id="main-header">
        <div class="header-container">
            <a href="/" class="header-logo">
                <img src="/assets/img/NeXTPixel.png" alt="NeXTPixel" />
                <span class="header-logo-text">NeXTPixel</span>
            </a>

            <nav class="header-nav" id="desktop-nav">
                <a href="/" class="<?php echo $currentPage === 'index.php' ? 'active' : ''; ?>">صفحه اصلی</a>
                <a href="/services.php" class="<?php echo $currentPage === 'services.php' ? 'active' : ''; ?>">خدمات</a>
                <a href="/portfolio.php" class="<?php echo $currentPage === 'portfolio.php' ? 'active' : ''; ?>">نمونه کارها</a>
                <a href="/contact.php" class="<?php echo $currentPage === 'contact.php' ? 'active' : ''; ?>">تماس با ما</a>
                <a href="/about.php" class="<?php echo $currentPage === 'about.php' ? 'active' : ''; ?>">درباره ما</a>
            </nav>

            <div class="header-actions">
                <?php if ($isLoggedIn): ?>
                    <?php if ($isN8NAdmin): ?>
                        <a href="/n8n-admin.php" class="header-btn header-btn-success" title="مدیریت n8n">
                            <i data-feather="zap" class="w-4 h-4"></i>
                            <span class="hidden sm:inline">n8n</span>
                        </a>
                    <?php endif; ?>
                    <a href="/panel/" class="header-btn header-btn-purple">
                        <span class="hidden sm:inline"><?php echo htmlspecialchars($username); ?></span>
                        <span class="sm:hidden"><?php echo substr(htmlspecialchars($username), 0, 1); ?></span>
                    </a>
                <?php else: ?>
                    <a href="/login.php" class="header-btn header-btn-primary">
                        ورود
                    </a>
                <?php endif; ?>

                <button class="menu-toggle" id="menu-toggle" aria-label="منو">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Mobile Menu -->
    <nav class="mobile-menu" id="mobile-menu">
        <div class="mobile-menu-content">
            <div class="mobile-menu-section">
                <div class="mobile-menu-section-title">القائمة</div>
                <div class="mobile-menu-links">
                    <a href="/" class="<?php echo $currentPage === 'index.php' ? 'active' : ''; ?>">صفحه اصلی</a>
                    <a href="/services.php" class="<?php echo $currentPage === 'services.php' ? 'active' : ''; ?>">خدمات</a>
                    <a href="/portfolio.php" class="<?php echo $currentPage === 'portfolio.php' ? 'active' : ''; ?>">نمونه کارها</a>
                    <a href="/contact.php" class="<?php echo $currentPage === 'contact.php' ? 'active' : ''; ?>">تماس با ما</a>
                    <a href="/about.php" class="<?php echo $currentPage === 'about.php' ? 'active' : ''; ?>">درباره ما</a>
                </div>
            </div>

            <?php if (!$isLoggedIn): ?>
            <div class="mobile-menu-section">
                <div class="mobile-menu-buttons">
                    <a href="/login.php" class="header-btn header-btn-primary">
                        ورود
                    </a>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </nav>
    
    <!-- Main Content -->
    <main style="padding-top: 70px;" class="container mx-auto px-4 py-8 max-w-7xl">
        <!-- Header Section -->
        <div class="text-center mb-12" data-aos="fade-up">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                <span class="gradient-text">پنل مدیریت n8n</span>
            </h1>
            <p class="text-gray-300 text-lg">مدیریت و کنترل کامل سرویس‌های اتوماسیون n8n</p>
        </div>
        
        <!-- Connection Status -->
        <div class="glass-effect rounded-2xl p-6 mb-8" data-aos="fade-up" data-aos-delay="100">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4 space-x-reverse">
                    <div id="connection-status" class="w-4 h-4 rounded-full bg-gray-500"></div>
                    <div>
                        <h3 class="font-bold text-lg">وضعیت اتصال</h3>
                        <p id="connection-text" class="text-gray-400 text-sm">در حال بررسی...</p>
                    </div>
                </div>
                <button id="refresh-connection" class="btn-primary px-6 py-2 rounded-full text-white font-medium">
                    <i data-feather="refresh-cw" class="w-4 h-4 inline ml-2"></i>
                    بروزرسانی
                </button>
            </div>
        </div>
        
        <!-- Actions Bar -->
        <div class="glass-effect rounded-2xl p-6 mb-8 flex flex-col md:flex-row justify-between items-center gap-4" data-aos="fade-up" data-aos-delay="200">
            <div class="flex items-center space-x-4 space-x-reverse">
                <button id="refresh-workflows" class="btn-primary px-6 py-2 rounded-full text-white font-medium">
                    <i data-feather="refresh-cw" class="w-4 h-4 inline ml-2"></i>
                    بروزرسانی لیست
                </button>
                <button id="create-workflow" class="bg-green-600 hover:bg-green-700 px-6 py-2 rounded-full text-white font-medium transition-all">
                    <i data-feather="plus" class="w-4 h-4 inline ml-2"></i>
                    ساخت Workflow جدید
                </button>
            </div>
            <div class="flex items-center space-x-4 space-x-reverse">
                <input type="text" id="search-workflows" placeholder="جستجو در workflows..." 
                       class="bg-slate-800/50 border border-slate-700 rounded-full px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:border-blue-500">
            </div>
        </div>
        
        <!-- Workflows List -->
        <div id="workflows-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Workflows will be loaded here -->
            <div class="col-span-full text-center py-12">
                <div class="loading inline-block w-12 h-12 border-4 border-blue-500 border-t-transparent rounded-full"></div>
                <p class="text-gray-400 mt-4">در حال بارگذاری workflows...</p>
            </div>
        </div>
    </main>
    
    <!-- Create/Edit Workflow Modal -->
    <div id="workflow-modal" class="modal-overlay hidden fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="modal-content glass-effect rounded-2xl p-8 max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h2 id="modal-title" class="text-2xl font-bold gradient-text">ساخت Workflow جدید</h2>
                <button id="close-modal" class="text-gray-400 hover:text-white">
                    <i data-feather="x" class="w-6 h-6"></i>
                </button>
            </div>
            <form id="workflow-form">
                <input type="hidden" id="workflow-id" name="workflow_id">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">نام Workflow</label>
                        <input type="text" id="workflow-name" name="name" required
                               class="w-full bg-slate-800/50 border border-slate-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">توضیحات</label>
                        <textarea id="workflow-description" name="description" rows="3"
                                  class="w-full bg-slate-800/50 border border-slate-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-blue-500"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">نوع Workflow</label>
                        <select id="workflow-type" name="type"
                                class="w-full bg-slate-800/50 border border-slate-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-blue-500">
                            <option value="webhook">Webhook</option>
                            <option value="schedule">Schedule</option>
                            <option value="manual">Manual</option>
                            <option value="trigger">Trigger</option>
                        </select>
                    </div>
                    <div>
                        <label class="flex items-center space-x-2 space-x-reverse">
                            <input type="checkbox" id="workflow-active" name="active" class="rounded">
                            <span>فعال باشد</span>
                        </label>
                    </div>
                </div>
                <div class="flex justify-end space-x-4 space-x-reverse mt-6">
                    <button type="button" id="cancel-form" class="px-6 py-2 rounded-full border border-gray-600 text-gray-300 hover:bg-gray-700 transition">
                        انصراف
                    </button>
                    <button type="submit" class="btn-primary px-6 py-2 rounded-full text-white font-medium">
                        ذخیره
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Scripts -->
    <script>
        // Initialize Feather Icons
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
            
            // Initialize AOS
            if (typeof AOS !== 'undefined') {
                AOS.init({
                    duration: 800,
                    easing: 'ease-in-out',
                    once: true
                });
            }
            
            // Load workflows on page load
            checkConnection();
            loadWorkflows();
            
            // Event listeners
            document.getElementById('refresh-connection').addEventListener('click', checkConnection);
            document.getElementById('refresh-workflows').addEventListener('click', loadWorkflows);
            document.getElementById('create-workflow').addEventListener('click', () => openWorkflowModal());
            document.getElementById('close-modal').addEventListener('click', closeWorkflowModal);
            document.getElementById('cancel-form').addEventListener('click', closeWorkflowModal);
            document.getElementById('workflow-form').addEventListener('submit', saveWorkflow);
            document.getElementById('search-workflows').addEventListener('input', filterWorkflows);
        });
        
        // Check n8n connection
        async function checkConnection() {
            const statusEl = document.getElementById('connection-status');
            const textEl = document.getElementById('connection-text');
            
            try {
                const response = await fetch('api/n8n-connection.php');
                const data = await response.json();
                
                if (data.success && data.connected) {
                    statusEl.className = 'w-4 h-4 rounded-full bg-green-500';
                    textEl.textContent = `متصل به ${data.url || 'n8n'}`;
                } else {
                    statusEl.className = 'w-4 h-4 rounded-full bg-red-500';
                    textEl.textContent = 'اتصال برقرار نشد';
                }
            } catch (error) {
                statusEl.className = 'w-4 h-4 rounded-full bg-red-500';
                textEl.textContent = 'خطا در اتصال';
            }
        }
        
        // Load workflows from n8n
        async function loadWorkflows() {
            const container = document.getElementById('workflows-container');
            container.innerHTML = '<div class="col-span-full text-center py-12"><div class="loading inline-block w-12 h-12 border-4 border-blue-500 border-t-transparent rounded-full"></div><p class="text-gray-400 mt-4">در حال بارگذاری workflows...</p></div>';
            
            try {
                const response = await fetch('api/n8n-workflows.php?action=list');
                const data = await response.json();
                
                if (data.success && data.workflows) {
                    displayWorkflows(data.workflows);
                } else {
                    container.innerHTML = '<div class="col-span-full text-center py-12"><p class="text-red-400">خطا در بارگذاری workflows</p></div>';
                }
            } catch (error) {
                container.innerHTML = '<div class="col-span-full text-center py-12"><p class="text-red-400">خطا در ارتباط با سرور</p></div>';
            }
        }
        
        // Display workflows
        function displayWorkflows(workflows) {
            const container = document.getElementById('workflows-container');
            
            if (!workflows || workflows.length === 0) {
                container.innerHTML = '<div class="col-span-full text-center py-12"><p class="text-gray-400">هیچ workflow یافت نشد</p></div>';
                return;
            }
            
            container.innerHTML = workflows.map(workflow => `
                <div class="workflow-card glass-effect rounded-2xl p-6" data-workflow-id="${workflow.id}">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex-1">
                            <h3 class="text-xl font-bold mb-2">${workflow.name || 'بدون نام'}</h3>
                            <p class="text-gray-400 text-sm mb-3">${workflow.description || 'بدون توضیحات'}</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" ${workflow.active ? 'checked' : ''} 
                                   onchange="toggleWorkflow(${workflow.id}, this.checked)">
                            <span class="slider"></span>
                        </label>
                    </div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-3 py-1 rounded-full text-xs font-medium ${workflow.active ? 'status-active' : 'status-inactive'}">
                            ${workflow.active ? 'فعال' : 'غیرفعال'}
                        </span>
                        <span class="text-gray-400 text-xs">ID: ${workflow.id}</span>
                    </div>
                    <div class="flex space-x-2 space-x-reverse">
                        <button onclick="editWorkflow(${workflow.id})" 
                                class="flex-1 bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-white text-sm transition">
                            <i data-feather="edit" class="w-4 h-4 inline ml-1"></i>
                            ویرایش
                        </button>
                        <button onclick="deleteWorkflow(${workflow.id})" 
                                class="flex-1 bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg text-white text-sm transition">
                            <i data-feather="trash-2" class="w-4 h-4 inline ml-1"></i>
                            حذف
                        </button>
                    </div>
                </div>
            `).join('');
            
            // Re-initialize Feather Icons
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        }
        
        // Toggle workflow active status
        async function toggleWorkflow(workflowId, isActive) {
            try {
                const response = await fetch('api/n8n-workflows.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        action: isActive ? 'activate' : 'deactivate',
                        workflow_id: workflowId
                    })
                });
                
                const data = await response.json();
                if (!data.success) {
                    alert('خطا در تغییر وضعیت workflow');
                    loadWorkflows(); // Reload to revert
                }
            } catch (error) {
                alert('خطا در ارتباط با سرور');
                loadWorkflows(); // Reload to revert
            }
        }
        
        // Open workflow modal for editing
        async function editWorkflow(workflowId) {
            try {
                const response = await fetch(`api/n8n-workflows.php?action=get&id=${workflowId}`);
                const data = await response.json();
                
                if (data.success && data.workflow) {
                    const workflow = data.workflow;
                    document.getElementById('workflow-id').value = workflow.id;
                    document.getElementById('workflow-name').value = workflow.name || '';
                    document.getElementById('workflow-description').value = workflow.description || '';
                    document.getElementById('workflow-type').value = workflow.type || 'webhook';
                    document.getElementById('workflow-active').checked = workflow.active || false;
                    document.getElementById('modal-title').textContent = 'ویرایش Workflow';
                    document.getElementById('workflow-modal').classList.remove('hidden');
                } else {
                    alert('خطا در بارگذاری workflow');
                }
            } catch (error) {
                alert('خطا در ارتباط با سرور');
            }
        }
        
        // Open workflow modal for creating
        function openWorkflowModal() {
            document.getElementById('workflow-form').reset();
            document.getElementById('workflow-id').value = '';
            document.getElementById('modal-title').textContent = 'ساخت Workflow جدید';
            document.getElementById('workflow-modal').classList.remove('hidden');
        }
        
        // Close workflow modal
        function closeWorkflowModal() {
            document.getElementById('workflow-modal').classList.add('hidden');
        }
        
        // Save workflow (create or update)
        async function saveWorkflow(e) {
            e.preventDefault();
            
            const formData = {
                action: document.getElementById('workflow-id').value ? 'update' : 'create',
                workflow_id: document.getElementById('workflow-id').value || null,
                name: document.getElementById('workflow-name').value,
                description: document.getElementById('workflow-description').value,
                type: document.getElementById('workflow-type').value,
                active: document.getElementById('workflow-active').checked
            };
            
            try {
                const response = await fetch('api/n8n-workflows.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(formData)
                });
                
                const data = await response.json();
                if (data.success) {
                    closeWorkflowModal();
                    loadWorkflows();
                } else {
                    alert('خطا در ذخیره workflow: ' + (data.message || 'خطای ناشناخته'));
                }
            } catch (error) {
                alert('خطا در ارتباط با سرور');
            }
        }
        
        // Delete workflow
        async function deleteWorkflow(workflowId) {
            if (!confirm('آیا مطمئن هستید که می‌خواهید این workflow را حذف کنید؟')) {
                return;
            }
            
            try {
                const response = await fetch('api/n8n-workflows.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        action: 'delete',
                        workflow_id: workflowId
                    })
                });
                
                const data = await response.json();
                if (data.success) {
                    loadWorkflows();
                } else {
                    alert('خطا در حذف workflow');
                }
            } catch (error) {
                alert('خطا در ارتباط با سرور');
            }
        }
        
        // Filter workflows
        function filterWorkflows(e) {
            const searchTerm = e.target.value.toLowerCase();
            const cards = document.querySelectorAll('.workflow-card');
            
            cards.forEach(card => {
                const text = card.textContent.toLowerCase();
                card.style.display = text.includes(searchTerm) ? 'block' : 'none';
            });
        }

        // Header Scroll Detection
        window.addEventListener('scroll', () => {
            const header = document.getElementById('main-header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        }, { passive: true });

        // Mobile Menu Toggle
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileLinks = document.querySelectorAll('.mobile-menu-links a');

        if (menuToggle) {
            menuToggle.addEventListener('click', () => {
                mobileMenu.classList.toggle('active');
            });
        }

        mobileLinks.forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.remove('active');
            });
        });

        // Close menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('header') && !e.target.closest('.mobile-menu')) {
                mobileMenu.classList.remove('active');
            }
        });

        // Active link highlighting
        const currentPage = window.location.pathname.split('/').pop() || 'index.php';
        const navLinks = document.querySelectorAll('.header-nav a, .mobile-menu-links a');
        navLinks.forEach(link => {
            const href = link.getAttribute('href');
            if (href === '/' && currentPage === '' || currentPage === 'index.php') {
                link.classList.add('active');
            } else if (href === `/${currentPage}` || href === currentPage) {
                link.classList.add('active');
            }
        });
