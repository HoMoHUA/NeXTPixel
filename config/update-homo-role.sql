-- به‌روزرسانی نقش کاربر HoMo به 'admin'
-- این فایل را در دیتابیس اجرا کنید تا نقش HoMo به درستی تنظیم شود

USE `gcifyhuc_NP`;

-- به‌روزرسانی نقش HoMo به 'admin'
UPDATE `users` 
SET `role` = 'admin' 
WHERE `username` = 'HoMo' AND (`role` IS NULL OR `role` != 'admin');

-- بررسی نتیجه
SELECT `username`, `user_type`, `role`, `display_name`, `status` 
FROM `users` 
WHERE `username` = 'HoMo';

