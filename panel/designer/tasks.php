<?php
/**
 * Designer Tasks Management
 * مدیریت وظایف طراح - Kanban Board
 */

$pageTitle = 'مدیریت وظایف';
$currentPage = 'designer-tasks';

require_once __DIR__ . '/../includes/auth.php';
requireLogin();

// بررسی نقش
if (!hasRole('designer')) {
    header('Location: /panel/index.php');
    exit();
}

$currentUser = getCurrentUser();
require_once __DIR__ . '/../config/db.php';

$db = getPanelDB();
$userId = getCurrentUserId();

// دریافت تسک‌ها
$stmt = $db->prepare("SELECT * FROM tasks WHERE designer_id = ? ORDER BY created_at DESC");
$stmt->execute([$userId]);
$allTasks = $stmt->fetchAll();

// دسته‌بندی تسک‌ها بر اساس وضعیت
$tasks = [
    'todo' => [],
    'in_progress' => [],
    'done' => []
];

foreach ($allTasks as $task) {
    $tasks[$task['status']][] = $task;
}

include __DIR__ . '/../includes/header.php';
?>

<main class="geex-main-content">
    <?php include __DIR__ . '/../includes/sidebar.php'; ?>
    
    <div class="geex-content">
        <div class="geex-content__header">
            <div class="geex-content__header__content">
                <h2 class="geex-content__header__title">مدیریت وظایف</h2>
                <p class="geex-content__header__subtitle">سازماندهی و مدیریت کارهای روزانه</p>
            </div>
            <div class="geex-content__header__action">
                <button class="geex-btn" onclick="showNewTaskModal()" 
                        style="background: linear-gradient(45deg, #10b981, #3b82f6); border: none; padding: 12px 30px;">
                    <i class="uil uil-plus"></i> تسک جدید
                </button>
            </div>
        </div>

        <div class="geex-content__wrapper">
            <!-- Kanban Board -->
            <div class="geex-content__section" style="overflow-x: auto;">
                <div class="kanban-board" style="display: flex; gap: 20px; min-width: 1200px; padding: 20px 0;">
                    <!-- Todo Column -->
                    <div class="kanban-column" style="flex: 1; background: var(--np-dark-card-bg); border-radius: 12px; padding: 20px; border: 1px solid rgba(59, 130, 246, 0.2);">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                            <h4 style="color: #f8fafc; margin: 0;">📋 انجام نشده</h4>
                            <span class="badge" style="background: #64748b; padding: 5px 12px; border-radius: 12px; font-size: 12px;">
                                <?php echo count($tasks['todo']); ?>
                            </span>
                        </div>
                        <div class="kanban-tasks" data-status="todo">
                            <?php foreach ($tasks['todo'] as $task): ?>
                                <div class="kanban-task" data-task-id="<?php echo $task['id']; ?>" draggable="true"
                                     style="background: #1e293b; padding: 15px; border-radius: 8px; margin-bottom: 15px; 
                                            cursor: move; border: 1px solid #3b82f6; transition: all 0.3s;"
                                     onmouseover="this.style.borderColor='#8b5cf6'; this.style.transform='translateY(-2px)';"
                                     onmouseout="this.style.borderColor='#3b82f6'; this.style.transform='translateY(0)';"
                                     onclick="viewTask(<?php echo $task['id']; ?>)">
                                    <h5 style="color: #f8fafc; margin-bottom: 10px; font-size: 16px;">
                                        <?php echo htmlspecialchars($task['title']); ?>
                                    </h5>
                                    <?php if ($task['description']): ?>
                                        <p style="color: #94a3b8; font-size: 13px; margin-bottom: 10px; line-height: 1.5;">
                                            <?php echo htmlspecialchars(mb_substr($task['description'], 0, 100)); ?>
                                            <?php echo mb_strlen($task['description']) > 100 ? '...' : ''; ?>
                                        </p>
                                    <?php endif; ?>
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px;">
                                        <span style="color: #64748b; font-size: 12px;">
                                            <?php echo date('Y/m/d', strtotime($task['created_at'])); ?>
                                        </span>
                                        <?php if ($task['time_logged'] > 0): ?>
                                            <span style="color: #3b82f6; font-size: 12px;">
                                                ⏱ <?php echo $task['time_logged']; ?> دقیقه
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- In Progress Column -->
                    <div class="kanban-column" style="flex: 1; background: var(--np-dark-card-bg); border-radius: 12px; padding: 20px; border: 1px solid rgba(245, 158, 11, 0.2);">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                            <h4 style="color: #f8fafc; margin: 0;">⚡ در حال انجام</h4>
                            <span class="badge" style="background: #f59e0b; padding: 5px 12px; border-radius: 12px; font-size: 12px;">
                                <?php echo count($tasks['in_progress']); ?>
                            </span>
                        </div>
                        <div class="kanban-tasks" data-status="in_progress">
                            <?php foreach ($tasks['in_progress'] as $task): ?>
                                <div class="kanban-task" data-task-id="<?php echo $task['id']; ?>" draggable="true"
                                     style="background: #1e293b; padding: 15px; border-radius: 8px; margin-bottom: 15px; 
                                            cursor: move; border: 1px solid #f59e0b; transition: all 0.3s;"
                                     onmouseover="this.style.borderColor='#fbbf24'; this.style.transform='translateY(-2px)';"
                                     onmouseout="this.style.borderColor='#f59e0b'; this.style.transform='translateY(0)';"
                                     onclick="viewTask(<?php echo $task['id']; ?>)">
                                    <h5 style="color: #f8fafc; margin-bottom: 10px; font-size: 16px;">
                                        <?php echo htmlspecialchars($task['title']); ?>
                                    </h5>
                                    <?php if ($task['description']): ?>
                                        <p style="color: #94a3b8; font-size: 13px; margin-bottom: 10px; line-height: 1.5;">
                                            <?php echo htmlspecialchars(mb_substr($task['description'], 0, 100)); ?>
                                            <?php echo mb_strlen($task['description']) > 100 ? '...' : ''; ?>
                                        </p>
                                    <?php endif; ?>
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px;">
                                        <span style="color: #64748b; font-size: 12px;">
                                            <?php echo date('Y/m/d', strtotime($task['created_at'])); ?>
                                        </span>
                                        <?php if ($task['time_logged'] > 0): ?>
                                            <span style="color: #f59e0b; font-size: 12px;">
                                                ⏱ <?php echo $task['time_logged']; ?> دقیقه
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Done Column -->
                    <div class="kanban-column" style="flex: 1; background: var(--np-dark-card-bg); border-radius: 12px; padding: 20px; border: 1px solid rgba(16, 185, 129, 0.2);">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                            <h4 style="color: #f8fafc; margin: 0;">✅ انجام شده</h4>
                            <span class="badge" style="background: #10b981; padding: 5px 12px; border-radius: 12px; font-size: 12px;">
                                <?php echo count($tasks['done']); ?>
                            </span>
                        </div>
                        <div class="kanban-tasks" data-status="done">
                            <?php foreach ($tasks['done'] as $task): ?>
                                <div class="kanban-task" data-task-id="<?php echo $task['id']; ?>" draggable="true"
                                     style="background: #1e293b; padding: 15px; border-radius: 8px; margin-bottom: 15px; 
                                            cursor: move; border: 1px solid #10b981; opacity: 0.8; transition: all 0.3s;"
                                     onmouseover="this.style.opacity='1'; this.style.transform='translateY(-2px)';"
                                     onmouseout="this.style.opacity='0.8'; this.style.transform='translateY(0)';"
                                     onclick="viewTask(<?php echo $task['id']; ?>)">
                                    <h5 style="color: #f8fafc; margin-bottom: 10px; font-size: 16px;">
                                        <?php echo htmlspecialchars($task['title']); ?>
                                    </h5>
                                    <?php if ($task['description']): ?>
                                        <p style="color: #94a3b8; font-size: 13px; margin-bottom: 10px; line-height: 1.5;">
                                            <?php echo htmlspecialchars(mb_substr($task['description'], 0, 100)); ?>
                                            <?php echo mb_strlen($task['description']) > 100 ? '...' : ''; ?>
                                        </p>
                                    <?php endif; ?>
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px;">
                                        <span style="color: #64748b; font-size: 12px;">
                                            <?php echo date('Y/m/d', strtotime($task['created_at'])); ?>
                                        </span>
                                        <?php if ($task['time_logged'] > 0): ?>
                                            <span style="color: #10b981; font-size: 12px;">
                                                ⏱ <?php echo $task['time_logged']; ?> دقیقه
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- New Task Modal -->
<div id="newTaskModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; 
                                background: rgba(0, 0, 0, 0.7); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: var(--np-dark-card-bg); padding: 30px; border-radius: 12px; width: 90%; max-width: 500px; 
                border: 1px solid rgba(59, 130, 246, 0.2);">
        <h3 style="color: #f8fafc; margin-bottom: 20px;">تسک جدید</h3>
        <form id="newTaskForm">
            <div class="form-group mb-3">
                <label style="color: #cbd5e1; margin-bottom: 5px; display: block;">عنوان:</label>
                <input type="text" id="task_title" name="title" class="form-control" required
                       style="background: #1e293b; border: 1px solid #3b82f6; color: white; padding: 12px; border-radius: 8px; width: 100%;">
            </div>
            <div class="form-group mb-3">
                <label style="color: #cbd5e1; margin-bottom: 5px; display: block;">توضیحات:</label>
                <textarea id="task_description" name="description" class="form-control" rows="4"
                          style="background: #1e293b; border: 1px solid #3b82f6; color: white; padding: 12px; border-radius: 8px; width: 100%;"></textarea>
            </div>
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" onclick="closeNewTaskModal()" class="geex-btn" 
                        style="background: #64748b; border: none; padding: 10px 20px; border-radius: 8px; color: white;">
                    انصراف
                </button>
                <button type="submit" class="geex-btn" 
                        style="background: linear-gradient(45deg, #10b981, #3b82f6); border: none; padding: 10px 20px; border-radius: 8px; color: white;">
                    ایجاد
                </button>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>

<script>
// Drag and Drop functionality
let draggedElement = null;

document.querySelectorAll('.kanban-task').forEach(task => {
    task.addEventListener('dragstart', function(e) {
        draggedElement = this;
        this.style.opacity = '0.5';
    });
    
    task.addEventListener('dragend', function(e) {
        this.style.opacity = '1';
        draggedElement = null;
    });
});

document.querySelectorAll('.kanban-tasks').forEach(column => {
    column.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.style.backgroundColor = 'rgba(59, 130, 246, 0.1)';
    });
    
    column.addEventListener('dragleave', function(e) {
        this.style.backgroundColor = 'transparent';
    });
    
    column.addEventListener('drop', function(e) {
        e.preventDefault();
        this.style.backgroundColor = 'transparent';
        
        if (draggedElement) {
            const newStatus = this.dataset.status;
            const taskId = draggedElement.dataset.taskId;
            
            // Update task status
            updateTaskStatus(taskId, newStatus);
            
            // Move element
            this.appendChild(draggedElement);
        }
    });
});

function updateTaskStatus(taskId, newStatus) {
    fetch('/panel/api/update_task_status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            task_id: taskId,
            status: newStatus
        })
    })
    .then(response => response.json())
    .then(result => {
        if (!result.success) {
            alert('خطا در به‌روزرسانی وضعیت تسک');
            window.location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('خطا در ارتباط با سرور');
        window.location.reload();
    });
}

function viewTask(taskId) {
    // TODO: Open task detail modal
    alert('جزئیات تسک #' + taskId);
}

function showNewTaskModal() {
    document.getElementById('newTaskModal').style.display = 'flex';
}

function closeNewTaskModal() {
    document.getElementById('newTaskModal').style.display = 'none';
    document.getElementById('newTaskForm').reset();
}

document.getElementById('newTaskForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const title = document.getElementById('task_title').value;
    const description = document.getElementById('task_description').value;
    
    fetch('/panel/api/create_task.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            title: title,
            description: description,
            status: 'todo'
        })
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            window.location.reload();
        } else {
            alert('خطا: ' + result.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('خطا در ارتباط با سرور');
    });
});
</script>

