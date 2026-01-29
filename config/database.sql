-- ساختار دیتابیس NextPixel
-- این فایل SQL را در دیتابیس خود اجرا کنید
-- توجه: اگر دیتابیس از قبل وجود دارد، فقط دستورات CREATE TABLE را اجرا کنید

-- انتخاب دیتابیس
USE `gcifyhuc_NP`;

-- حذف جدول قبلی در صورت وجود (اگر می‌خواهید از اول شروع کنید)
-- DROP TABLE IF EXISTS `users`;

-- ایجاد جدول کاربران
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(100) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `display_name` VARCHAR(255) DEFAULT NULL,
  `user_type` ENUM('admin', 'staff', 'customer') NOT NULL DEFAULT 'customer',
  `role` VARCHAR(50) DEFAULT NULL COMMENT 'نقش دقیق کاربر: seller, designer, admin, customer (توسط HoMo تنظیم می‌شود)',
  `phone` VARCHAR(20) DEFAULT NULL,
  `status` ENUM('active', 'inactive', 'suspended') NOT NULL DEFAULT 'active',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` INT(11) DEFAULT NULL COMMENT 'شناسه ادمینی که این کاربر را ایجاد کرده',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `idx_username` (`username`),
  KEY `idx_email` (`email`),
  KEY `idx_user_type` (`user_type`),
  KEY `idx_role` (`role`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ایجاد کاربر ادمین اصلی (HoMo)
-- پسورد پیش‌فرض: admin123 (باید تغییر دهید!)
-- Hash این پسورد: $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi
-- user_type = 'admin' برای دسترسی به پنل ادمین
-- role = 'admin' برای تشخیص نقش دقیق و ورود از تب "ورود همکاران"
INSERT INTO `users` (`username`, `email`, `password`, `display_name`, `user_type`, `role`, `status`) 
VALUES ('HoMo', 'admin@nextpixel.ir', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'مدیر اصلی', 'admin', 'admin', 'active')
ON DUPLICATE KEY UPDATE 
    `username` = `username`,
    `role` = 'admin';

-- توضیحات:
-- 1. user_type: نوع کاربر (admin, staff, customer)
-- 2. status: وضعیت کاربر (active, inactive, suspended)
-- 3. created_by: شناسه ادمینی که این کاربر را ایجاد کرده (برای مدیریت کاربران)
-- 4. همه کاربران باید توسط ادمین اصلی (HoMo) ایجاد شوند
-- 5. پسورد باید با password_hash() هش شود

