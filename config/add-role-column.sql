-- افزودن ستون role به جدول users برای نقش‌های دقیق‌تر
-- این فایل را در دیتابیس gcifyhuc_NP اجرا کنید

USE `gcifyhuc_NP`;

-- افزودن ستون role (اگر وجود ندارد)
ALTER TABLE `users` 
ADD COLUMN IF NOT EXISTS `role` VARCHAR(50) DEFAULT NULL COMMENT 'نقش دقیق کاربر: seller, designer, admin, customer';

-- به‌روزرسانی نقش‌های موجود بر اساس user_type
-- مشتریان
UPDATE `users` SET `role` = 'customer' WHERE `user_type` = 'customer' AND `role` IS NULL;

-- ادمین‌ها
UPDATE `users` SET `role` = 'admin' WHERE `user_type` = 'admin' AND `role` IS NULL;

-- همکاران: اگر role ندارند، به عنوان staff باقی می‌مانند
-- مدیر اصلی (HoMo) باید نقش‌های دقیق‌تر را تنظیم کند:
-- UPDATE `users` SET `role` = 'seller' WHERE `username` = 'seller_username';
-- UPDATE `users` SET `role` = 'designer' WHERE `username` = 'designer_username';

-- ایجاد ایندکس برای جستجوی سریع‌تر
ALTER TABLE `users` ADD INDEX IF NOT EXISTS `idx_role` (`role`);

