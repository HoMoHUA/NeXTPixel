<?php
session_start();

require_once __DIR__ . '/../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ' . __DIR__ . '/../../login.php');
    exit;
}

$db = $GLOBALS['db'] ?? null;
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مدیریت نمونه کارها | NextPixel</title>
    <link rel="stylesheet" href="../../assets/css/nextpixel-global.css">
    <link rel="stylesheet" href="../assets/css/nextpixel-theme.css">
    <style>
        .portfolio-manager {
            background: var(--np-bg-dark);
            border-radius: 12px;
            padding: 24px;
            margin: 20px 0;
        }

        .portfolio-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }

        .portfolio-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 16px;
            transition: all 0.3s ease;
        }

        .portfolio-card:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.2);
        }

        .portfolio-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 12px;
        }

        .portfolio-card h3 {
            font-size: 18px;
            font-weight: 600;
            margin: 12px 0 8px;
            color: #fff;
        }

        .portfolio-actions {
            display: flex;
            gap: 8px;
            margin-top: 12px;
        }

        .btn-small {
            padding: 8px 12px;
            font-size: 13px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-edit {
            background: #3b82f6;
            color: white;
        }

        .btn-delete {
            background: #ef4444;
            color: white;
        }

        .btn-small:hover {
            opacity: 0.9;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }

        .modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.95) 0%, rgba(15, 23, 42, 0.95) 100%);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 32px;
            max-width: 600px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(20px);
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #cbd5e1;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            background: rgba(0, 0, 0, 0.3);
            color: #fff;
            font-family: inherit;
            transition: border-color 0.2s;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #3b82f6;
            background: rgba(0, 0, 0, 0.5);
        }

        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .checkbox-group input[type="checkbox"] {
            width: auto;
        }

        .btn-submit {
            background: #3b82f6;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s;
            width: 100%;
        }

        .btn-submit:hover {
            background: #2563eb;
        }

        .btn-cancel {
            background: transparent;
            color: #cbd5e1;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .btn-cancel:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-active {
            background: rgba(34, 197, 94, 0.1);
            color: #22c55e;
        }

        .status-inactive {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        .tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .tab-btn {
            padding: 12px 16px;
            background: transparent;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            transition: all 0.2s;
            border-bottom: 2px solid transparent;
        }

        .tab-btn.active {
            color: #3b82f6;
            border-bottom-color: #3b82f6;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .loader {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #3b82f6;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 16px;
            display: none;
        }

        .alert.show {
            display: block;
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.1);
            color: #22c55e;
            border: 1px solid rgba(34, 197, 94, 0.3);
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }
    </style>
</head>
<body>
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-white">مدیریت نمونه کارها</h1>
            <button class="btn-primary" onclick="openPortfolioModal()">
                <i data-feather="plus"></i> افزودن نمونه کار جدید
            </button>
        </div>

        <div id="alertContainer" class="alert"></div>

        <div class="tabs">
            <button class="tab-btn active" data-tab="all" onclick="filterPortfolios('all')">همه</button>
            <button class="tab-btn" data-tab="store" onclick="filterPortfolios('store')">فروشگاهی</button>
            <button class="tab-btn" data-tab="service" onclick="filterPortfolios('service')">خدماتی</button>
            <button class="tab-btn" data-tab="landing" onclick="filterPortfolios('landing')">لندینگ پیج</button>
            <button class="tab-btn" data-tab="other" onclick="filterPortfolios('other')">سایر</button>
        </div>

        <div id="portfolioContainer" class="portfolio-grid">
            <div class="text-center text-gray-400 col-span-full py-8">
                <div class="loader mx-auto"></div>
                <p class="mt-4">در حال بارگیری...</p>
            </div>
        </div>
    </div>

    <div id="portfolioModal" class="modal">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-white" id="modalTitle">افزودن نمونه کار</h2>
                <button onclick="closePortfolioModal()" style="background: none; border: none; color: #cbd5e1; font-size: 24px; cursor: pointer;">&times;</button>
            </div>

            <form id="portfolioForm" onsubmit="savePortfolio(event)">
                <div class="form-group">
                    <label>عنوان پروژه *</label>
                    <input type="text" id="title" required>
                </div>

                <div class="form-group">
                    <label>توضیح *</label>
                    <textarea id="description" required></textarea>
                </div>

                <div class="form-group">
                    <label>دسته‌بندی *</label>
                    <select id="category" required>
                        <option value="">انتخاب کنید</option>
                        <option value="store">فروشگاهی</option>
                        <option value="service">خدماتی</option>
                        <option value="landing">لندینگ پیج</option>
                        <option value="other">سایر</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>مسیر تصویر بندانگشتی *</label>
                    <input type="text" id="thumbnail" placeholder="/src/example.png" required>
                </div>

                <div class="form-group">
                    <label>مسیر تصویر محلی (اختیاری)</label>
                    <input type="text" id="thumbnail_local_path" placeholder="/src/example-local.png">
                </div>

                <div class="form-group">
                    <label>لینک وبسایت</label>
                    <input type="url" id="project_url" placeholder="https://example.com">
                </div>

                <div class="form-group">
                    <label>نوع دمو</label>
                    <select id="demo_type">
                        <option value="external">خارجی</option>
                        <option value="internal">محلی</option>
                        <option value="both">هر دو</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>لینک دمو محلی (اختیاری)</label>
                    <input type="text" id="internal_demo_url" placeholder="/demos/example">
                </div>

                <div class="form-group">
                    <label>نام کلاینت</label>
                    <input type="text" id="client_name">
                </div>

                <div class="form-group">
                    <label>متن Alt برای تصویر</label>
                    <input type="text" id="image_alt_text">
                </div>

                <div class="form-group">
                    <label class="checkbox-group">
                        <input type="checkbox" id="featured">
                        <span>نمایش در صفحه اصلی</span>
                    </label>
                </div>

                <div class="form-group">
                    <label>ترتیب نمایش</label>
                    <input type="number" id="display_order" value="0" min="0">
                </div>

                <div class="form-group">
                    <label>وضعیت</label>
                    <select id="status">
                        <option value="active">فعال</option>
                        <option value="inactive">غیرفعال</option>
                        <option value="draft">پیش‌نویس</option>
                    </select>
                </div>

                <div style="display: flex; gap: 12px;">
                    <button type="submit" class="btn-submit">ذخیره</button>
                    <button type="button" class="btn-submit btn-cancel" onclick="closePortfolioModal()">لغو</button>
                </div>
            </form>
        </div>
    </div>

    <script src="../../assets/js/vendor/feather.min.js" defer></script>
    <script>
        let currentFilter = 'all';
        let editingPortfolioId = null;

        document.addEventListener('DOMContentLoaded', () => {
            feather.replace();
            loadPortfolios();
        });

        function loadPortfolios(category = 'all') {
            const container = document.getElementById('portfolioContainer');
            container.innerHTML = '<div class="text-center text-gray-400 col-span-full py-8"><div class="loader mx-auto"></div><p class="mt-4">در حال بارگیری...</p></div>';

            let url = '/panel/api/manage-portfolios.php?action=list&status=active';
            if (category !== 'all') {
                url += '&category=' + category;
            }

            fetch(url)
                .then(r => r.json())
                .then(portfolios => {
                    if (portfolios.length === 0) {
                        container.innerHTML = '<div class="text-center text-gray-400 col-span-full py-8">هیچ نمونه کاری پیدا نشد</div>';
                        return;
                    }

                    container.innerHTML = portfolios.map(p => `
                        <div class="portfolio-card">
                            <img src="${p.thumbnail}" alt="${p.title}" onerror="this.src='/assets/img/placeholder.png'">
                            <h3>${p.title}</h3>
                            <p class="text-sm text-gray-400">${p.description?.substring(0, 80) || ''}...</p>
                            <div style="margin: 8px 0;">
                                <span class="status-badge status-${p.status}">${p.status === 'active' ? 'فعال' : p.status === 'inactive' ? 'غیرفعال' : 'پیش‌نویس'}</span>
                            </div>
                            <div class="portfolio-actions">
                                <button class="btn-small btn-edit" onclick="editPortfolio(${p.id})">ویرایش</button>
                                <button class="btn-small btn-delete" onclick="deletePortfolio(${p.id})">حذف</button>
                            </div>
                        </div>
                    `).join('');

                    feather.replace();
                })
                .catch(e => showAlert('خطا: ' + e.message, 'error'));
        }

        function filterPortfolios(category) {
            currentFilter = category;
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            loadPortfolios(category);
        }

        function openPortfolioModal() {
            editingPortfolioId = null;
            document.getElementById('modalTitle').textContent = 'افزودن نمونه کار';
            document.getElementById('portfolioForm').reset();
            document.getElementById('portfolioModal').classList.add('active');
        }

        function closePortfolioModal() {
            document.getElementById('portfolioModal').classList.remove('active');
        }

        function editPortfolio(id) {
            fetch(`/panel/api/manage-portfolios.php?action=get&id=${id}`)
                .then(r => r.json())
                .then(portfolio => {
                    editingPortfolioId = id;
                    document.getElementById('modalTitle').textContent = 'ویرایش نمونه کار';
                    document.getElementById('title').value = portfolio.title;
                    document.getElementById('description').value = portfolio.description || '';
                    document.getElementById('category').value = portfolio.category;
                    document.getElementById('thumbnail').value = portfolio.thumbnail;
                    document.getElementById('thumbnail_local_path').value = portfolio.thumbnail_local_path || '';
                    document.getElementById('project_url').value = portfolio.project_url || '';
                    document.getElementById('demo_type').value = portfolio.demo_type;
                    document.getElementById('internal_demo_url').value = portfolio.internal_demo_url || '';
                    document.getElementById('client_name').value = portfolio.client_name || '';
                    document.getElementById('image_alt_text').value = portfolio.image_alt_text || '';
                    document.getElementById('featured').checked = portfolio.featured === 1 || portfolio.featured === true;
                    document.getElementById('display_order').value = portfolio.display_order;
                    document.getElementById('status').value = portfolio.status;
                    
                    document.getElementById('portfolioModal').classList.add('active');
                })
                .catch(e => showAlert('خطا: ' + e.message, 'error'));
        }

        function savePortfolio(e) {
            e.preventDefault();

            const data = {
                action: editingPortfolioId ? 'update' : 'create',
                title: document.getElementById('title').value,
                description: document.getElementById('description').value,
                category: document.getElementById('category').value,
                thumbnail: document.getElementById('thumbnail').value,
                thumbnail_local_path: document.getElementById('thumbnail_local_path').value,
                project_url: document.getElementById('project_url').value,
                demo_type: document.getElementById('demo_type').value,
                internal_demo_url: document.getElementById('internal_demo_url').value,
                client_name: document.getElementById('client_name').value,
                image_alt_text: document.getElementById('image_alt_text').value,
                featured: document.getElementById('featured').checked,
                display_order: parseInt(document.getElementById('display_order').value),
                status: document.getElementById('status').value
            };

            if (editingPortfolioId) {
                data.id = editingPortfolioId;
            }

            fetch('/panel/api/manage-portfolios.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            })
                .then(r => r.json())
                .then(result => {
                    if (result.success) {
                        showAlert(editingPortfolioId ? 'نمونه کار بروزرسانی شد' : 'نمونه کار اضافه شد', 'success');
                        closePortfolioModal();
                        loadPortfolios(currentFilter);
                    } else {
                        showAlert('خطا: ' + (result.error || 'خطای نامشخص'), 'error');
                    }
                })
                .catch(e => showAlert('خطا: ' + e.message, 'error'));
        }

        function deletePortfolio(id) {
            if (!confirm('آیا مطمئن هستید؟')) return;

            fetch(`/panel/api/manage-portfolios.php?action=delete&id=${id}`, {
                method: 'GET'
            })
                .then(r => r.json())
                .then(result => {
                    if (result.success) {
                        showAlert('نمونه کار حذف شد', 'success');
                        loadPortfolios(currentFilter);
                    } else {
                        showAlert('خطا: ' + (result.error || 'خطای نامشخص'), 'error');
                    }
                })
                .catch(e => showAlert('خطا: ' + e.message, 'error'));
        }

        function showAlert(message, type = 'success') {
            const alert = document.getElementById('alertContainer');
            alert.textContent = message;
            alert.className = `alert alert-${type} show`;
            setTimeout(() => alert.classList.remove('show'), 4000);
        }

        window.onclick = function(event) {
            const modal = document.getElementById('portfolioModal');
            if (event.target === modal) {
                closePortfolioModal();
            }
        }
    </script>
</body>
</html>
