<?php

$pageTitle = 'مدیریت n8n - NextPixel';
$currentPage = 'n8n';

require_once __DIR__ . '/../includes/auth.php';
requireLogin();
requireRole('admin');

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/sidebar.php';

$currentUser = getCurrentUser();

require_once __DIR__ . '/../../config/n8n-config.php';
?>

<main class="geex-main-content">
    <div class="geex-content">
        <div class="geex-content__header">
            <div class="geex-content__header__content">
                <h2 class="geex-content__header__title">
                    <span class="np-gradient-text">مدیریت n8n</span>
                </h2>
                <p class="geex-content__header__subtitle">مدیریت و کنترل کامل سرویس‌های اتوماسیون n8n</p>
            </div>
        </div>

        <div class="geex-content__wrapper">
            <div class="geex-content__section-wrapper">
                
                <div class="geex-content__section mb-30">
                    <div class="geex-content__section__content">
                        <div class="geex-content__feature__card">
                            <div class="geex-content__feature__card__text">
                                <p class="geex-content__feature__card__subtitle">وضعیت اتصال</p>
                                <h4 id="connection-text" class="geex-content__feature__card__title">در حال بررسی...</h4>
                                <span id="connection-status" class="geex-content__feature__card__badge">بررسی</span>
                            </div>
                            <div class="geex-content__feature__card__img">
                                <i class="uil uil-plug" style="font-size: 48px; color: #3b82f6;"></i>
                            </div>
                            <button id="refresh-connection" class="geex-btn geex-btn--sm mt-3">
                                <i class="uil uil-sync"></i>
                                بروزرسانی
                            </button>
                        </div>
                    </div>
                </div>

                <div class="geex-content__section mb-30">
                    <div class="geex-content__section__header">
                        <h4 class="geex-content__section__header__title">عملیات</h4>
                    </div>
                    <div class="geex-content__section__content">
                        <div class="d-flex gap-3 mb-3">
                            <button id="refresh-workflows" class="geex-btn geex-btn--primary">
                                <i class="uil uil-sync"></i>
                                بروزرسانی لیست
                            </button>
                            <button id="create-workflow" class="geex-btn" style="background: linear-gradient(45deg, #10b981, #059669);">
                                <i class="uil uil-plus"></i>
                                ساخت Workflow جدید
                            </button>
                        </div>
                        <div class="geex-form__group">
                            <input type="text" 
                                   id="search-workflows" 
                                   class="geex-form__input" 
                                   placeholder="جستجو در workflows...">
                        </div>
                    </div>
                </div>

                <div class="geex-content__section">
                    <div class="geex-content__section__header">
                        <h4 class="geex-content__section__header__title">لیست Workflows</h4>
                    </div>
                    <div class="geex-content__section__content">
                        <div id="workflows-container" class="row">
                            <div class="col-12 text-center py-5">
                                <div class="np-loading" style="display: inline-block; width: 40px; height: 40px; border: 4px solid var(--np-primary); border-top-color: transparent; border-radius: 50%;"></div>
                                <p class="mt-3 text-muted">در حال بارگذاری workflows...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<div id="workflow-modal" class="modal-overlay" style="display: none; position: fixed; inset: 0; z-index: 10000; background: rgba(0, 0, 0, 0.8); backdrop-filter: blur(8px); align-items: center; justify-content: center; padding: 20px;">
    <div class="modal-content" style="background: rgba(15, 23, 42, 0.95); backdrop-filter: blur(20px); border-radius: 16px; padding: 30px; max-width: 600px; width: 100%; max-height: 90vh; overflow-y: auto; border: 1px solid rgba(59, 130, 246, 0.2);">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 id="modal-title" class="np-gradient-text" style="font-size: 24px; font-weight: 700;">ساخت Workflow جدید</h2>
            <button id="close-modal" class="geex-btn geex-btn--sm" style="background: transparent; border: none; color: var(--np-text-muted); font-size: 24px;">
                <i class="uil uil-times"></i>
            </button>
        </div>
        <form id="workflow-form">
            <input type="hidden" id="workflow-id" name="workflow_id">
            <div class="geex-form__group">
                <label class="geex-form__label">نام Workflow <span class="text-red-500">*</span></label>
                <input type="text" id="workflow-name" name="name" class="geex-form__input" required>
            </div>
            <div class="geex-form__group">
                <label class="geex-form__label">توضیحات</label>
                <textarea id="workflow-description" name="description" rows="3" class="geex-form__textarea"></textarea>
            </div>
            <div class="geex-form__group">
                <label class="geex-form__label">نوع Workflow</label>
                <select id="workflow-type" name="type" class="geex-form__select">
                    <option value="webhook">Webhook</option>
                    <option value="schedule">Schedule</option>
                    <option value="manual">Manual</option>
                    <option value="trigger">Trigger</option>
                </select>
            </div>
            <div class="geex-form__group">
                <label class="d-flex align-items-center gap-2">
                    <input type="checkbox" id="workflow-active" name="active" class="form-check-input">
                    <span>فعال باشد</span>
                </label>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-4">
                <button type="button" id="cancel-form" class="geex-btn geex-btn--secondary">
                    انصراف
                </button>
                <button type="submit" class="geex-btn geex-btn--primary">
                    ذخیره
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.workflow-card {
    background: rgba(15, 23, 42, 0.6);
    border: 1px solid rgba(59, 130, 246, 0.15);
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
    transition: all 0.3s ease;
}

.workflow-card:hover {
    background: rgba(15, 23, 42, 0.8);
    border-color: rgba(59, 130, 246, 0.3);
    transform: translateY(-2px);
    box-shadow: 0 8px 32px rgba(59, 130, 246, 0.15);
}

.toggle-switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 28px;
}

.toggle-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.toggle-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #4b5563;
    transition: .4s;
    border-radius: 28px;
}

.toggle-slider:before {
    position: absolute;
    content: "";
    height: 20px;
    width: 20px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
}

input:checked + .toggle-slider {
    background: linear-gradient(45deg, #10b981, #059669);
}

input:checked + .toggle-slider:before {
    transform: translateX(22px);
}

.status-badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 500;
}

.status-active {
    background: rgba(16, 185, 129, 0.2);
    color: #10b981;
}

.status-inactive {
    background: rgba(107, 114, 128, 0.2);
    color: #6b7280;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.np-loading {
    animation: spin 1s linear infinite;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    checkConnection();
    loadWorkflows();

    document.getElementById('refresh-connection').addEventListener('click', checkConnection);
    document.getElementById('refresh-workflows').addEventListener('click', loadWorkflows);
    document.getElementById('create-workflow').addEventListener('click', () => openWorkflowModal());
    document.getElementById('close-modal').addEventListener('click', closeWorkflowModal);
    document.getElementById('cancel-form').addEventListener('click', closeWorkflowModal);
    document.getElementById('workflow-form').addEventListener('submit', saveWorkflow);
    document.getElementById('search-workflows').addEventListener('input', filterWorkflows);

    document.getElementById('workflow-modal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeWorkflowModal();
        }
    });
});

async function checkConnection() {
    const statusEl = document.getElementById('connection-status');
    const textEl = document.getElementById('connection-text');
    
    statusEl.textContent = 'در حال بررسی...';
    statusEl.className = 'geex-content__feature__card__badge';
    
    try {
        const response = await fetch('/api/n8n-connection.php');
        const data = await response.json();
        
        if (data.success && data.connected) {
            statusEl.textContent = 'متصل';
            statusEl.className = 'geex-content__feature__card__badge success-color';
            textEl.textContent = `متصل به ${data.url || 'n8n'}`;
        } else {
            statusEl.textContent = 'قطع';
            statusEl.className = 'geex-content__feature__card__badge danger-color';
            textEl.textContent = 'اتصال برقرار نشد';
        }
    } catch (error) {
        statusEl.textContent = 'خطا';
        statusEl.className = 'geex-content__feature__card__badge danger-color';
        textEl.textContent = 'خطا در اتصال';
    }
}

async function loadWorkflows() {
    const container = document.getElementById('workflows-container');
    container.innerHTML = '<div class="col-12 text-center py-5"><div class="np-loading" style="display: inline-block; width: 40px; height: 40px; border: 4px solid var(--np-primary); border-top-color: transparent; border-radius: 50%;"></div><p class="mt-3 text-muted">در حال بارگذاری workflows...</p></div>';
    
    try {
        const response = await fetch('/api/n8n-workflows.php?action=list');
        const data = await response.json();
        
        if (data.success && data.workflows) {
            displayWorkflows(data.workflows);
        } else {
            container.innerHTML = '<div class="col-12 text-center py-5"><p class="danger-color">خطا در بارگذاری workflows</p></div>';
        }
    } catch (error) {
        container.innerHTML = '<div class="col-12 text-center py-5"><p class="danger-color">خطا در ارتباط با سرور</p></div>';
    }
}

function displayWorkflows(workflows) {
    const container = document.getElementById('workflows-container');
    
    if (!workflows || workflows.length === 0) {
        container.innerHTML = '<div class="col-12 text-center py-5"><p class="text-muted">هیچ workflow یافت نشد</p></div>';
        return;
    }
    
    container.innerHTML = workflows.map(workflow => `
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="workflow-card" data-workflow-id="${workflow.id}">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="flex-1">
                        <h5 class="mb-2">${workflow.name || 'بدون نام'}</h5>
                        <p class="text-muted small mb-3">${workflow.description || 'بدون توضیحات'}</p>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" ${workflow.active ? 'checked' : ''} 
                               onchange="toggleWorkflow(${workflow.id}, this.checked)">
                        <span class="toggle-slider"></span>
                    </label>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="status-badge ${workflow.active ? 'status-active' : 'status-inactive'}">
                        ${workflow.active ? 'فعال' : 'غیرفعال'}
                    </span>
                    <span class="text-muted small">ID: ${workflow.id}</span>
                </div>
                <div class="d-flex gap-2">
                    <button onclick="editWorkflow(${workflow.id})" 
                            class="geex-btn geex-btn--sm geex-btn--primary flex-1">
                        <i class="uil uil-edit"></i>
                        ویرایش
                    </button>
                    <button onclick="deleteWorkflow(${workflow.id})" 
                            class="geex-btn geex-btn--sm" style="background: #ef4444; flex: 1;">
                        <i class="uil uil-trash"></i>
                        حذف
                    </button>
                </div>
            </div>
        </div>
    `).join('');
}

async function toggleWorkflow(workflowId, isActive) {
    try {
        const response = await fetch('/api/n8n-workflows.php', {
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
        const response = await fetch(`/api/n8n-workflows.php?action=get&id=${workflowId}`);
        const data = await response.json();
        
        if (data.success && data.workflow) {
            const workflow = data.workflow;
            document.getElementById('workflow-id').value = workflow.id;
            document.getElementById('workflow-name').value = workflow.name || '';
            document.getElementById('workflow-description').value = workflow.description || '';
            document.getElementById('workflow-type').value = workflow.type || 'webhook';
            document.getElementById('workflow-active').checked = workflow.active || false;
            document.getElementById('modal-title').textContent = 'ویرایش Workflow';
            document.getElementById('workflow-modal').style.display = 'flex';
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
    document.getElementById('workflow-modal').style.display = 'flex';
}

function closeWorkflowModal() {
    document.getElementById('workflow-modal').style.display = 'none';
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
        const response = await fetch('/api/n8n-workflows.php', {
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
        const response = await fetch('/api/n8n-workflows.php', {
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
        const parent = card.closest('.col-md-6');
        if (parent) {
            parent.style.display = text.includes(searchTerm) ? 'block' : 'none';
        }
    });
}
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

