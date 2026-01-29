-- اگر جدول users از قبل وجود دارد اما ستون password و دیگر ستون‌ها را ندارد
-- این دستورات را به ترتیب اجرا کنید

USE `gcifyhuc_NP`;

-- بررسی ساختار فعلی جدول (این دستور را ابتدا اجرا کنید تا ببینید چه ستون‌هایی وجود دارد)
-- DESCRIBE `users`;

-- اضافه کردن ستون‌های لازم (فقط ستون‌هایی که وجود ندارند را اضافه کنید)

-- 1. اضافه کردن ستون password
ALTER TABLE `users` 
ADD COLUMN `password` VARCHAR(255) NOT NULL AFTER `email`;

-- 2. اضافه کردن ستون display_name
ALTER TABLE `users` 
ADD COLUMN `display_name` VARCHAR(255) DEFAULT NULL AFTER `password`;

-- 3. اضافه کردن ستون user_type
ALTER TABLE `users` 
ADD COLUMN `user_type` ENUM('admin', 'staff', 'customer') NOT NULL DEFAULT 'customer' AFTER `display_name`;

-- 4. اضافه کردن ستون phone
ALTER TABLE `users` 
ADD COLUMN `phone` VARCHAR(20) DEFAULT NULL AFTER `user_type`;

-- 5. اضافه کردن ستون status
ALTER TABLE `users` 
ADD COLUMN `status` ENUM('active', 'inactive', 'suspended') NOT NULL DEFAULT 'active' AFTER `phone`;

-- 6. اضافه کردن ستون created_at
ALTER TABLE `users` 
ADD COLUMN `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `status`;

-- 7. اضافه کردن ستون updated_at
ALTER TABLE `users` 
ADD COLUMN `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER `created_at`;

-- 8. اضافه کردن ستون created_by
ALTER TABLE `users` 
ADD COLUMN `created_by` INT(11) DEFAULT NULL COMMENT 'شناسه ادمینی که این کاربر را ایجاد کرده' AFTER `updated_at`;

-- اضافه کردن ایندکس‌ها
ALTER TABLE `users` ADD INDEX `idx_username` (`username`);
ALTER TABLE `users` ADD INDEX `idx_email` (`email`);
ALTER TABLE `users` ADD INDEX `idx_user_type` (`user_type`);
ALTER TABLE `users` ADD INDEX `idx_status` (`status`);

-- پس از اضافه کردن ستون‌ها، کاربر ادمین را اضافه کنید:
INSERT INTO `users` (`username`, `email`, `password`, `display_name`, `user_type`, `status`) 
VALUES ('HoMo', 'admin@nextpixel.ir', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'مدیر اصلی', 'admin', 'active')
ON DUPLICATE KEY UPDATE `username` = `username`;



