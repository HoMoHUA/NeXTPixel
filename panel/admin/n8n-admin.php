<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = isset($_SESSION['user_id']);
$username = $_SESSION['username'] ?? '';
$displayName = $_SESSION['display_name'] ?? '';

if (!$isLoggedIn) {
    header('Location: login.php');
    exit;
}

require_once 'config/n8n-config.php';
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl" class="overflow-x-hidden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پنل مدیریت n8n | NextPixel</title>
    <link rel="icon" type="image/x-icon" href="/static/favicon.ico">
    <link rel="stylesheet" href="/assets/css/nextpixel-global.css">
    <link rel="stylesheet" href="/assets/css/vendor/aos.min.css">
    <script src="/assets/js/vendor/tailwind.min.js" defer></script>
    <script src="/assets/js/vendor/aos.min.js" defer></script>
    <script src="/assets/js/vendor/feather.min.js" defer></script>
<<<<<<< Updated upstream
=======
    
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
>>>>>>> Stashed changes
</head>
<body>
    
    <nav class="ios-glass-header flex justify-between items-center py-4 px-4 md:px-8 mx-auto max-w-full md:max-w-6xl rounded-2xl md:rounded-full my-4">
        <a href="index.php" class="text-2xl font-bold gradient-text">NextPixel</a>
        <div class="hidden md:flex items-center space-x-6 space-x-reverse">
            <a href="index.php" class="hover:text-blue-400 transition">صفحه اصلی</a>
            <a href="services.php" class="hover:text-blue-400 transition">خدمات</a>
            <a href="about.php" class="hover:text-blue-400 transition">درباره ما</a>
            <a href="portfolio.php" class="hover:text-blue-400 transition">نمونه کارها</a>
            <a href="contact.php" class="hover:text-amber-400 transition">تماس با ما</a>
            <span class="text-green-400 font-medium"><?php echo htmlspecialchars($displayName); ?></span>
        </div>
    </nav>

    <main class="container mx-auto px-4 py-8 max-w-7xl">
        
        <div class="text-center mb-12" data-aos="fade-up">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                <span class="gradient-text">پنل مدیریت n8n</span>
            </h1>
            <p class="text-gray-300 text-lg">مدیریت و کنترل کامل سرویس‌های اتوماسیون n8n</p>
        </div>

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

        <div id="workflows-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <div class="col-span-full text-center py-12">
                <div class="loading inline-block w-12 h-12 border-4 border-blue-500 border-t-transparent rounded-full"></div>
                <p class="text-gray-400 mt-4">در حال بارگذاری workflows...</p>
            </div>
        </div>
    </main>

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

    <script>
        
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }

            if (typeof AOS !== 'undefined') {
                AOS.init({
                    duration: 800,
                    easing: 'ease-in-out',
                    once: true
                });
            }

            checkConnection();
            loadWorkflows();

            document.getElementById('refresh-connection').addEventListener('click', checkConnection);
            document.getElementById('refresh-workflows').addEventListener('click', loadWorkflows);
            document.getElementById('create-workflow').addEventListener('click', () => openWorkflowModal());
            document.getElementById('close-modal').addEventListener('click', closeWorkflowModal);
            document.getElementById('cancel-form').addEventListener('click', closeWorkflowModal);
            document.getElementById('workflow-form').addEventListener('submit', saveWorkflow);
            document.getElementById('search-workflows').addEventListener('input', filterWorkflows);
        });

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

            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        }

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
                    loadWorkflows(); 
                }
            } catch (error) {
                alert('خطا در ارتباط با سرور');
                loadWorkflows(); 
            }
        }

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

        function openWorkflowModal() {
            document.getElementById('workflow-form').reset();
            document.getElementById('workflow-id').value = '';
            document.getElementById('modal-title').textContent = 'ساخت Workflow جدید';
            document.getElementById('workflow-modal').classList.remove('hidden');
        }

        function closeWorkflowModal() {
            document.getElementById('workflow-modal').classList.add('hidden');
        }

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

        function filterWorkflows(e) {
            const searchTerm = e.target.value.toLowerCase();
            const cards = document.querySelectorAll('.workflow-card');
            
            cards.forEach(card => {
                const text = card.textContent.toLowerCase();
                card.style.display = text.includes(searchTerm) ? 'block' : 'none';
            });
        }
    </script>
</body>
</html>

