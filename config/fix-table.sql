-- اگر جدول users وجود دارد اما ستون‌های لازم را ندارد، این دستورات را اجرا کنید
-- ابتدا بررسی کنید که آیا جدول وجود دارد یا نه

USE `gcifyhuc_NP`;

-- اگر جدول وجود ندارد، ابتدا آن را ایجاد کنید
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(100) NOT NULL UNIQUE,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `display_name` VARCHAR(255) DEFAULT NULL,
  `user_type` ENUM('admin', 'staff', 'customer') NOT NULL DEFAULT 'customer',
  `phone` VARCHAR(20) DEFAULT NULL,
  `status` ENUM('active', 'inactive', 'suspended') NOT NULL DEFAULT 'active',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` INT(11) DEFAULT NULL COMMENT 'شناسه ادمینی که این کاربر را ایجاد کرده',
  PRIMARY KEY (`id`),
  KEY `idx_username` (`username`),
  KEY `idx_email` (`email`),
  KEY `idx_user_type` (`user_type`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- اگر جدول وجود دارد اما ستون‌ها را ندارد، این دستورات را اجرا کنید:
-- (ابتدا بررسی کنید که کدام ستون‌ها وجود ندارد)

-- اضافه کردن ستون password (اگر وجود ندارد)
ALTER TABLE `users` 
ADD COLUMN IF NOT EXISTS `password` VARCHAR(255) NOT NULL AFTER `email`;

-- اضافه کردن ستون display_name (اگر وجود ندارد)
ALTER TABLE `users` 
ADD COLUMN IF NOT EXISTS `display_name` VARCHAR(255) DEFAULT NULL AFTER `password`;

-- اضافه کردن ستون user_type (اگر وجود ندارد)
ALTER TABLE `users` 
ADD COLUMN IF NOT EXISTS `user_type` ENUM('admin', 'staff', 'customer') NOT NULL DEFAULT 'customer' AFTER `display_name`;

-- اضافه کردن ستون phone (اگر وجود ندارد)
ALTER TABLE `users` 
ADD COLUMN IF NOT EXISTS `phone` VARCHAR(20) DEFAULT NULL AFTER `user_type`;

-- اضافه کردن ستون status (اگر وجود ندارد)
ALTER TABLE `users` 
ADD COLUMN IF NOT EXISTS `status` ENUM('active', 'inactive', 'suspended') NOT NULL DEFAULT 'active' AFTER `phone`;

-- اضافه کردن ستون created_at (اگر وجود ندارد)
ALTER TABLE `users` 
ADD COLUMN IF NOT EXISTS `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `status`;

-- اضافه کردن ستون updated_at (اگر وجود ندارد)
ALTER TABLE `users` 
ADD COLUMN IF NOT EXISTS `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER `created_at`;

-- اضافه کردن ستون created_by (اگر وجود ندارد)
ALTER TABLE `users` 
ADD COLUMN IF NOT EXISTS `created_by` INT(11) DEFAULT NULL COMMENT 'شناسه ادمینی که این کاربر را ایجاد کرده' AFTER `updated_at`;

-- اضافه کردن ایندکس‌ها (اگر وجود ندارند)
ALTER TABLE `users` ADD INDEX IF NOT EXISTS `idx_username` (`username`);
ALTER TABLE `users` ADD INDEX IF NOT EXISTS `idx_email` (`email`);
ALTER TABLE `users` ADD INDEX IF NOT EXISTS `idx_user_type` (`user_type`);
ALTER TABLE `users` ADD INDEX IF NOT EXISTS `idx_status` (`status`);



