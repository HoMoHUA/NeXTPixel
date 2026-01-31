<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    require_once __DIR__ . '/config/db-connection.php';
    
    try {
        $db = getDB();
        $userId = $_SESSION['user_id'];

        $stmt = $db->prepare("SELECT user_type, role FROM " . TABLE_USERS . " WHERE id = ? LIMIT 1");
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            $actualRole = $user['role'] ?? $user['user_type'];
            $_SESSION['role'] = $actualRole;

            switch ($actualRole) {
                case 'customer':
                case 'client':
                    header('Location: /panel/client/index.php');
                    exit;
                case 'seller':
                    header('Location: /panel/seller/dashboard.php');
                    exit;
                case 'designer':
                    header('Location: /panel/designer/index.php');
                    exit;
                case 'admin':
                    header('Location: /panel/index.php');
                    exit;
                default:
                    header('Location: /panel/index.php');
                    exit;
            }
        } else {
            
            header('Location: index.php');
            exit;
        }
    } catch (Exception $e) {
        
        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود - NextPixel</title>
    <link rel="stylesheet" href="/assets/css/nextpixel-global.css">
</head>
</head>
<body>
    
    <a href="index.php" class="back-home">
        <box-icon name='arrow-back' color="#cbd5e1"></box-icon>
        بازگشت به صفحه اصلی
    </a>

    <div class="container" id="loginContainer">
        <div class="curved-shape"></div>
        <div class="curved-shape2"></div>

        <div class="tab-buttons">
            <button class="tab-btn active" data-tab="staff">ورود همکاران</button>
            <button class="tab-btn" data-tab="customer">ورود مشتریان</button>
        </div>

        <div class="form-box staff">
            <h2 class="animation">ورود همکاران</h2>
            <p class="subtitle animation">دسترسی به پنل مدیریت و سیستم‌های داخلی</p>
            <form id="staff-login-form" class="animation">
                <input type="hidden" name="action" value="login">
                <input type="hidden" name="user_type" value="staff">
                <div class="input-box animation">
                    <input type="text" id="staff-username" name="username" required>
                    <label for="staff-username">نام کاربری</label>
                    <box-icon type='solid' name='user' color="#9ca3af"></box-icon>
                </div>

                <div class="input-box animation">
                    <input type="password" id="staff-password" name="password" required>
                    <label for="staff-password">رمز عبور</label>
                    <box-icon name='lock-alt' type='solid' color="#9ca3af"></box-icon>
                </div>

                <div class="input-box animation">
                    <button class="btn" type="submit">ورود</button>
                </div>
                
                <div id="staff-message" class="message-box animation"></div>
            </form>
            
            <div class="note-text animation">
                <strong>توجه:</strong> ثبت نام فقط توسط مدیریت امکان‌پذیر است.
            </div>
        </div>

        <div class="form-box customer">
            <h2 class="animation">ورود مشتریان</h2>
            <p class="subtitle animation">دسترسی به پنل مشتری و پیگیری پروژه‌ها</p>
            <form id="customer-login-form" class="animation">
                <input type="hidden" name="action" value="login">
                <input type="hidden" name="user_type" value="customer">
                <div class="input-box animation">
                    <input type="text" id="customer-username" name="username" required>
                    <label for="customer-username">نام کاربری</label>
                    <box-icon type='solid' name='user' color="#9ca3af"></box-icon>
                </div>

                <div class="input-box animation">
                    <input type="password" id="customer-password" name="password" required>
                    <label for="customer-password">رمز عبور</label>
                    <box-icon name='lock-alt' type='solid' color="#9ca3af"></box-icon>
                </div>

                <div class="input-box animation">
                    <button class="btn" type="submit">ورود</button>
                </div>
                
                <div id="customer-message" class="message-box animation"></div>
            </form>
            
            <div class="note-text animation">
                <strong>توجه:</strong> ثبت نام فقط توسط مدیریت امکان‌پذیر است.
            </div>
        </div>

        <div class="info-content staff">
            <h2 class="animation">همکاران محترم</h2>
            <p class="animation">خوش آمدید! برای دسترسی به پنل مدیریت و سیستم‌های داخلی، لطفا اطلاعات حساب کاربری خود را وارد کنید.</p>
        </div>

        <div class="info-content customer">
            <h2 class="animation">مشتریان عزیز</h2>
            <p class="animation">خوش آمدید! برای دسترسی به پنل مشتری و پیگیری پروژه‌های خود، لطفا اطلاعات حساب کاربری خود را وارد کنید.</p>
        </div>

    </div>

    <script>
        const container = document.getElementById('loginContainer');
        const tabButtons = document.querySelectorAll('.tab-btn');
        const staffForm = document.getElementById('staff-login-form');
        const customerForm = document.getElementById('customer-login-form');
        const staffMessage = document.getElementById('staff-message');
        const customerMessage = document.getElementById('customer-message');

        tabButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                const tab = btn.dataset.tab;

                tabButtons.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                if (tab === 'customer') {
                    container.classList.add('active');
                } else {
                    container.classList.remove('active');
                }
            });
        });

        const showMessage = (element, message, isError = true) => {
            element.textContent = message;
            element.className = 'message-box';
            if (isError) {
                element.classList.add('error');
            } else {
                element.classList.add('success');
            }
        };

        staffForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            showMessage(staffMessage, '', false);
            
            const formData = new FormData(staffForm);

            try {
                const response = await fetch('auth.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    showMessage(staffMessage, data.message, false);
                    setTimeout(() => {
                        
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        } else {
                            
                            window.location.href = '/panel/';
                        }
                    }, 1500);
                } else {
                    showMessage(staffMessage, data.message, true);
                }
            } catch (error) {
                console.error('Error:', error);
                showMessage(staffMessage, 'خطا در ارتباط با سرور.', true);
            }
        });

        customerForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            showMessage(customerMessage, '', false);
            
            const formData = new FormData(customerForm);

            try {
                const response = await fetch('auth.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    showMessage(customerMessage, data.message, false);
                    setTimeout(() => {
                        
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        } else {
                            
                            window.location.href = '/panel/client/index.php';
                        }
                    }, 1500);
                } else {
                    showMessage(customerMessage, data.message, true);
                }
            } catch (error) {
                console.error('Error:', error);
                showMessage(customerMessage, 'خطا در ارتباط با سرور.', true);
            }
        });

    </script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>

</body>
</html>
