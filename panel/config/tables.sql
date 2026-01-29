-- جداول لازم برای پنل NextPixel
-- اجرای این فایل SQL در دیتابیس gcifyhuc_NP

USE `gcifyhuc_NP`;

-- جدول مشتریان (Client Onboarding Data)
CREATE TABLE IF NOT EXISTS `client_onboarding` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `step` TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'مرحله فعلی (1-7)',
  `contract_signature` TEXT DEFAULT NULL COMMENT 'امضای دیجیتال (Base64)',
  `advisor_id` INT(11) DEFAULT NULL COMMENT 'شناسه مشاور انتخاب شده',
  `payment_method` ENUM('cash_check', 'progressive', 'full_cash') DEFAULT NULL,
  `support_id` VARCHAR(50) DEFAULT NULL COMMENT 'شناسه پشتیبانی',
  `project_description` TEXT DEFAULT NULL,
  `project_duration` VARCHAR(255) DEFAULT NULL,
  `total_price` DECIMAL(15,2) DEFAULT NULL,
  `payment_status` ENUM('pending', 'partial', 'completed') DEFAULT 'pending',
  `onboarding_completed` BOOLEAN DEFAULT FALSE,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `advisor_id` (`advisor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- جدول گزارش‌های روزانه فروشنده
CREATE TABLE IF NOT EXISTS `seller_reports` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `report_date` DATE NOT NULL,
  `sales_amount` DECIMAL(15,2) DEFAULT 0,
  `report_text` TEXT DEFAULT NULL,
  `audio_file` VARCHAR(255) DEFAULT NULL COMMENT 'مسیر فایل صوتی',
  `image_file` VARCHAR(255) DEFAULT NULL COMMENT 'مسیر فایل تصویری',
  `no_sale_reason` TEXT DEFAULT NULL COMMENT 'دلیل عدم فروش',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `report_date` (`report_date`),
  UNIQUE KEY `unique_user_date` (`user_id`, `report_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- جدول تیکت‌ها (برای طراحان و مشتریان)
CREATE TABLE IF NOT EXISTS `tickets` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `client_id` INT(11) NOT NULL,
  `designer_id` INT(11) DEFAULT NULL,
  `subject` VARCHAR(255) NOT NULL,
  `status` ENUM('open', 'in_progress', 'resolved', 'closed') DEFAULT 'open',
  `priority` ENUM('low', 'medium', 'high', 'urgent') DEFAULT 'medium',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`),
  KEY `designer_id` (`designer_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- جدول پیام‌های تیکت
CREATE TABLE IF NOT EXISTS `ticket_messages` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` INT(11) NOT NULL,
  `user_id` INT(11) NOT NULL,
  `message` TEXT NOT NULL,
  `is_read` BOOLEAN DEFAULT FALSE,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `ticket_id` (`ticket_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- جدول تسک‌ها (برای طراحان)
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `designer_id` INT(11) NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `status` ENUM('todo', 'in_progress', 'done') DEFAULT 'todo',
  `time_logged` INT(11) DEFAULT 0 COMMENT 'زمان صرف شده (دقیقه)',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `designer_id` (`designer_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- افزودن ستون advisor به جدول users (اگر از قبل وجود ندارد)
ALTER TABLE `users` 
ADD COLUMN IF NOT EXISTS `is_advisor` BOOLEAN DEFAULT FALSE COMMENT 'آیا این کاربر مشاور است؟';

-- ایجاد ایندکس برای جستجوی سریع‌تر
ALTER TABLE `users` ADD INDEX IF NOT EXISTS `idx_is_advisor` (`is_advisor`);

