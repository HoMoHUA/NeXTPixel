<?php
// شروع سشن در ابتدای فایل
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// اگر کاربر از قبل وارد شده بود، او را به پنل مناسب هدایت کن
if (isset($_SESSION['user_id'])) {
    require_once __DIR__ . '/config/db-connection.php';
    
    try {
        $db = getDB();
        $userId = $_SESSION['user_id'];
        
        // دریافت نقش کاربر از دیتابیس
        $stmt = $db->prepare("SELECT user_type, role FROM " . TABLE_USERS . " WHERE id = ? LIMIT 1");
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            $actualRole = $user['role'] ?? $user['user_type'];
            $_SESSION['role'] = $actualRole;
            
            // هدایت به پنل مناسب
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
            // اگر کاربر پیدا نشد، به صفحه اصلی
            header('Location: index.php');
            exit;
        }
    } catch (Exception $e) {
        // در صورت خطا، به صفحه اصلی
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
    <link rel="icon" type="image/x-icon" href="/static/favicon.ico">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Vazirmatn:wght@100;200;300;400;500;600;700;800;900&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Vazirmatn', 'Tahoma', 'Arial', sans-serif;
            color: #fff;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
            direction: rtl;
            padding: 1rem;
        }

        .container {
            position: relative;
            width: 100%;
            max-width: 900px;
            min-height: 550px;
            height: auto;
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(12px) saturate(180%);
            -webkit-backdrop-filter: blur(12px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.125);
            box-shadow: 0 0 25px rgba(59, 130, 246, 0.3);
            overflow: hidden;
            border-radius: 15px;
        }

        .tabs-container {
            display: flex;
            width: 100%;
            height: 100%;
            position: relative;
        }

        .tab-buttons {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
            z-index: 10;
            background: rgba(30, 41, 59, 0.8);
            padding: 5px;
            border-radius: 50px;
            backdrop-filter: blur(10px);
        }

        .tab-btn {
            padding: 10px 30px;
            border: none;
            background: transparent;
            color: #cbd5e1;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .tab-btn.active {
            background: linear-gradient(45deg, #3b82f6, #8b5cf6);
            color: white;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }

        .form-box {
            position: absolute;
            top: 0;
            width: 50%;
            height: 100%;
            display: flex;
            justify-content: center;
            flex-direction: column;
            padding: 80px 40px 40px;
            transition: all 0.7s ease;
            z-index: 5;
        }

        .form-box.staff {
            left: 0;
        }

        .form-box.customer {
            right: 0;
        }

        .form-box form {
            position: relative;
            z-index: 5;
        }

        .form-box h2 {
            font-size: 32px;
            text-align: center;
            margin-bottom: 10px;
            position: relative;
            z-index: 5;
        }

        .form-box .subtitle {
            text-align: center;
            color: #9ca3af;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .form-box .input-box {
            position: relative;
            width: 100%;
            height: 50px;
            margin-top: 20px;
            z-index: 5;
        }

        .input-box input {
            width: 100%;
            height: 100%;
            background: transparent;
            border: none;
            outline: none;
            font-size: 16px;
            color: #fff;
            font-weight: 600;
            border-bottom: 2px solid #fff;
            padding-right: 23px;
            padding-left: 23px;
            text-align: right;
            direction: rtl;
            transition: .5s;
            position: relative;
            z-index: 10;
            pointer-events: auto;
            cursor: text;
        }

        .input-box input:focus,
        .input-box input:valid {
            border-bottom: 2px solid #8b5cf6;
        }

        .input-box label {
            position: absolute;
            top: 50%;
            right: 23px;
            transform: translateY(-50%);
            font-size: 16px;
            color: #fff;
            transition: .5s;
            pointer-events: none;
            z-index: 7;
        }

        .input-box input:focus ~ label,
        .input-box input:valid ~ label {
            top: -5px;
            color: #8b5cf6;
        }

        .input-box box-icon {
            position: absolute;
            top: 50%;
            left: 0;
            font-size: 18px;
            transform: translateY(-50%);
            color: #9ca3af;
            pointer-events: none;
            z-index: 7;
        }

        .input-box input:focus ~ box-icon,
        .input-box input:valid ~ box-icon {
            color: #8b5cf6;
        }

        .btn {
            position: relative;
            width: 100%;
            height: 45px;
            background: transparent;
            border-radius: 40px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            border: 2px solid #8b5cf6;
            overflow: hidden;
            z-index: 1;
            color: white;
            transition: all 0.3s ease;
        }

        .btn::before {
            content: "";
            position: absolute;
            height: 300%;
            width: 100%;
            background: linear-gradient(#0f172a, #8b5cf6, #0f172a, #3b82f6);
            top: -100%;
            left: 0;
            z-index: -1;
            transition: .5s;
        }

        .btn:hover:before {
            top: 0;
        }

        .message-box {
            text-align: center;
            margin-top: 15px;
            padding: 10px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 8px;
            display: none;
        }

        .message-box.error {
            background-color: rgba(239, 68, 68, 0.2);
            color: #f87171;
            border: 1px solid #ef4444;
            display: block;
        }

        .message-box.success {
            background-color: rgba(16, 185, 129, 0.2);
            color: #34d399;
            border: 1px solid #10b981;
            display: block;
        }

        .info-content {
            position: absolute;
            top: 0;
            height: 100%;
            width: 50%;
            display: flex;
            justify-content: center;
            flex-direction: column;
            padding: 0 40px 60px;
            transition: all 0.7s ease;
            z-index: 2;
            pointer-events: none;
        }

        .info-content.staff {
            right: 0;
            text-align: right;
            padding-left: 150px;
        }

        .info-content.customer {
            left: 0;
            text-align: left;
            padding-right: 150px;
        }

        .info-content h2 {
            text-transform: uppercase;
            font-size: 36px;
            line-height: 1.3;
            margin-bottom: 20px;
        }

        .info-content p {
            font-size: 16px;
            color: #cbd5e1;
        }

        .container .curved-shape {
            position: absolute;
            right: 0;
            top: -5px;
            height: 600px;
            width: 850px;
            background: linear-gradient(45deg, #1e293b, #4f46e5);
            transform: rotate(10deg) skewY(40deg);
            transform-origin: bottom right;
            transition: 1.5s ease;
            opacity: 0.3;
            z-index: 1;
            pointer-events: none;
        }

        .container.active .curved-shape {
            transform: rotate(0deg) skewY(0deg);
        }

        .container .curved-shape2 {
            position: absolute;
            left: 0;
            top: -5px;
            height: 600px;
            width: 850px;
            background: linear-gradient(45deg, #8b5cf6, #3b82f6);
            transform: rotate(-10deg) skewY(-40deg);
            transform-origin: bottom left;
            transition: 1.5s ease;
            opacity: 0.3;
            z-index: 1;
            pointer-events: none;
        }

        .container.active .curved-shape2 {
            transform: rotate(0deg) skewY(0deg);
        }

        .back-home {
            position: fixed;
            top: 20px;
            left: 20px;
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            background-color: rgba(30, 41, 59, 0.8);
            color: #cbd5e1;
            text-decoration: none;
            border-radius: 9999px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            z-index: 100;
        }

        .back-home:hover {
            background-color: #3b82f6;
            color: white;
        }

        .back-home box-icon {
            margin-left: 8px;
        }

        /* Animation for forms */
        .form-box.staff .animation {
            transform: translateX(0%);
            opacity: 1;
            transition: .7s ease;
        }

        .form-box.customer .animation {
            transform: translateX(120%);
            opacity: 0;
            transition: .7s ease;
        }

        .container.active .form-box.staff .animation {
            transform: translateX(-120%);
            opacity: 0;
        }

        .container.active .form-box.customer .animation {
            transform: translateX(0%);
            opacity: 1;
        }

        .info-content.staff .animation {
            transform: translateX(0);
            opacity: 1;
            transition: .7s ease;
        }

        .info-content.customer .animation {
            transform: translateX(-120%);
            opacity: 0;
            transition: .7s ease;
        }

        .container.active .info-content.staff .animation {
            transform: translateX(120%);
            opacity: 0;
        }

        .container.active .info-content.customer .animation {
            transform: translateX(0);
            opacity: 1;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .container {
                width: 95%;
                max-width: 400px;
                min-height: 550px;
            }

            .form-box {
                width: 100%;
                padding: 80px 20px 20px;
            }

            .info-content {
                display: none;
            }

            .container .curved-shape,
            .container .curved-shape2 {
                display: none;
            }

            .container.active .form-box.staff {
                transform: translateX(-100%);
                opacity: 0;
                position: absolute;
            }

            .container.active .form-box.customer {
                transform: translateX(0);
                opacity: 1;
            }

            .tab-buttons {
                width: calc(100% - 40px);
                left: 20px;
                transform: none;
            }
        }

        .note-text {
            text-align: center;
            margin-top: 20px;
            padding: 15px;
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.3);
            border-radius: 8px;
            font-size: 13px;
            color: #93c5fd;
        }
    </style>
</head>
<body>
    
    <a href="index.php" class="back-home">
        <box-icon name='arrow-back' color="#cbd5e1"></box-icon>
        بازگشت به صفحه اصلی
    </a>

    <div class="container" id="loginContainer">
        <div class="curved-shape"></div>
        <div class="curved-shape2"></div>
        
        <!-- دکمه‌های تغییر تب -->
        <div class="tab-buttons">
            <button class="tab-btn active" data-tab="staff">ورود همکاران</button>
            <button class="tab-btn" data-tab="customer">ورود مشتریان</button>
        </div>
        
        <!-- فرم ورود همکاران -->
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

        <!-- فرم ورود مشتریان -->
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

        <!-- محتوای اطلاعاتی همکاران -->
        <div class="info-content staff">
            <h2 class="animation">همکاران محترم</h2>
            <p class="animation">خوش آمدید! برای دسترسی به پنل مدیریت و سیستم‌های داخلی، لطفا اطلاعات حساب کاربری خود را وارد کنید.</p>
        </div>

        <!-- محتوای اطلاعاتی مشتریان -->
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

        // تغییر تب
        tabButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                const tab = btn.dataset.tab;
                
                // فعال کردن دکمه
                tabButtons.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                
                // تغییر وضعیت container
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

        // --- Staff Login Form Submission ---
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
                        // هدایت به پنل مناسب بر اساس نقش کاربر
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        } else {
                            // در صورت عدم وجود redirect، به پنل اصلی
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

        // --- Customer Login Form Submission ---
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
                        // هدایت به پنل مناسب بر اساس نقش کاربر
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        } else {
                            // در صورت عدم وجود redirect، به پنل مشتری
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
